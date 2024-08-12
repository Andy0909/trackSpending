<?php

namespace App\Http\Controllers;

use App\Repositories\EventRepository;
use App\Repositories\MemberRepository;
use App\Repositories\ItemRepository;
use App\Services\CalculateAveragePrice;
use App\Services\GetSpendListService;
use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class HomeController extends Controller
{
    /** @const string */
    const ERROR_MESSAGE = '網頁發生錯誤，請稍後再試，謝謝。';

    /** @var SessionService */
    private $sessionService;

    /** @var CalculateAveragePrice */
    private $calculateAveragePrice;

    /** @var GetSpendListService */
    private $getSpendListService;

    /** @var EventRepository */
    private $eventRepository;

    /** @var MemberRepository */
    private $memberRepository;

    /** @var ItemRepository */
    private $itemRepository;

    /**
     * construct
     * @param SessionService $sessionService
     * @param CalculateAveragePrice $calculateAveragePrice
     * @param GetSpendListService $getSpendListService
     * @param EventRepository $eventRepository
     * @param MemberRepository $memberRepository
     * @param ItemRepository $itemRepository
     */
    public function __construct(SessionService $sessionService, CalculateAveragePrice $calculateAveragePrice, GetSpendListService $getSpendListService, EventRepository $eventRepository, MemberRepository $memberRepository, ItemRepository $itemRepository) 
    {
        $this->sessionService = $sessionService;
        $this->calculateAveragePrice = $calculateAveragePrice;
        $this->getSpendListService = $getSpendListService;
        $this->eventRepository = $eventRepository;
        $this->memberRepository = $memberRepository;
        $this->itemRepository = $itemRepository;
    }

    /**
     * trackSpendingPage
     * @param int $eventId
     * @param string $eventName
     */
    public function trackSpendingPage(int $eventId, string $eventName)
    {
        // 取得 session 資料
        $userName = $this->sessionService->getSession('userName');
        $userId = $this->sessionService->getSession('userId');
        $token = $this->sessionService->getSession('token');

        // 若 session 無資料則導到首頁 
        if (!$userName || !$userId || !$token) {
            return redirect('/');
        }

        // 使用 id 取得分帳事件資料
        $eventData = $this->eventRepository->getEventById($eventId);

        // 若資料庫取得的事件名稱與網址的名稱不同則導到 createEventPage
        if ($eventData->first()['event_name'] === $eventName) {
            // 取得事件名稱
            $eventName = $eventData->first()['event_name'];

            // 取得事件成員
            $eventMember = $eventData->first()['member'];

            // 取得事件項目
            $items = empty($eventData->first()['item']) ? [] : $eventData->first()['item'];

            // 整理項目的花費資訊
            $spendList = empty($items) ? [] : $this->getSpendListService->formatItems($items);

            // 計算成員花費平均
            $averageResult = empty($spendList) ? [] : $this->calculateAveragePrice->calculateAveragePrice($spendList);

            return view('trackSpending')->with([
                'userName'      => $userName,
                'userId'        => $userId,
                'token'         => $token,
                'eventId'       => $eventId,
                'eventName'     => $eventName,
                'eventMember'   => $eventMember,
                'items'         => $items,
                'spendList'     => $spendList,
                'averageResult' => $averageResult,
            ]);
        }
        else {
            return redirect()->route('createEventPage');
        }
    }

    /**
     * createItemProcess
     * @param Request $request
     */
    public function createItemProcess(Request $request)
    {
        // 取得項目資料
        $itemData = $request->all();

        // 取得資料庫最後一個項目的 id 並 + 1
        $lastItemId = $this->itemRepository->getLastItemId()->item_id;
        $newItemId = $lastItemId ? $lastItemId + 1 : 1;

        DB::beginTransaction();

        try {
            // 新增項目
            collect($itemData['average'])->each(function ($averageMember) use ($itemData, $newItemId) {
                $this->itemRepository->createItem([
                    'event_id'     => $itemData['eventId'],
                    'item_id'      => $newItemId,
                    'item_name'    => $itemData['item'],
                    'price'        => $itemData['price'],
                    'payer'        => $itemData['payer'],
                    'share_member' => $averageMember,
                ]);
            });
 
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(self::ERROR_MESSAGE);
        }

        return redirect()->back();
    }

    /**
     * updateItemProcess
     * @param Request $request
     */
    public function updateItemProcess(Request $request)
    {
        // 取得項目資料
        $itemData = $request->all();

        // 取得資料庫最後一個項目的 id 並 + 1
        $newItemId = $this->itemRepository->getLastItemId()->item_id + 1;

        DB::beginTransaction();

        try {
            // 刪除舊的 item 資料
            $this->itemRepository->deleteItemByEventIdAndItemId($itemData['eventId'], $itemData['itemId']);

            // 新增項目
            collect($itemData['updateAverage'])->each(function ($averageMember) use ($itemData, $newItemId) {
                $this->itemRepository->createItem([
                    'event_id'     => $itemData['eventId'],
                    'item_id'      => $newItemId,
                    'item_name'    => $itemData['updateItem'],
                    'price'        => $itemData['updatePrice'],
                    'payer'        => $itemData['updatePayer'],
                    'share_member' => $averageMember,
                ]);
            });

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(self::ERROR_MESSAGE);
        }

        return redirect()->back();
    }

    /**
     * createEventPage
     * @param Request $request
     */
    public function createEventPage()
    {
        // 取得 session 資料
        $userName = $this->sessionService->getSession('userName');
        $userId = $this->sessionService->getSession('userId');
        $token = $this->sessionService->getSession('token');

        // 若 session 無資料則導到首頁 
        if (!$userName || !$userId || !$token) {
            return redirect('/');
        }

        // 取得用戶事件資料
        $userEvent = $this->eventRepository->getEventByUserId($userId);

        return view('createEvent', [
            'userName'  => $userName,
            'userId'    => $userId,
            'token'     => $token,
            'userEvent' => $userEvent,
        ]);
    }

    /**
     * createEventProcess
     * @param Request $request
     */
    public function createEventProcess(Request $request)
    {
        // 取得用戶輸入之事件資料
        $eventData = $request->all();

        DB::beginTransaction();

        try {
            // 新增事件
            $event = $this->eventRepository->createEvent([
                'user_id' => $this->sessionService->getSession('userId'),
                'event_name' => $eventData['name'],
                'event_date' => $eventData['date'],
            ]);

            // 新增成員
            collect($eventData['member'])->each(function ($member) use ($event) {
                $this->memberRepository->createMember([
                    'event_id' => $event->id,
                    'name' => $member,
                ]);
            });

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(self::ERROR_MESSAGE)->withInput();
        }

        return redirect()->route('trackSpendingPage', ['eventId' => $event->id, 'eventName' => $eventData['name']]);
    }
}
