<?php

namespace App\Http\Controllers;

use App\Services\CacheService;
use App\Services\CalculateAveragePrice;
use App\Services\EventService;
use App\Services\GetSpendListService;
use App\Services\ItemService;
use App\Services\MemberService;
use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class HomeController extends Controller
{
    /** @const string */
    const ERROR_MESSAGE = '網頁發生錯誤，請稍後再試，謝謝。';

    /** @var CacheService */
    private $cacheService;

    /** @var CalculateAveragePrice */
    private $calculateAveragePrice;

    /** @var EventService */
    private $eventService;

    /** @var GetSpendListService */
    private $getSpendListService;

    /** @var ItemService */
    private $itemService;

    /** @var MemberService */
    private $memberService;

    /** @var SessionService */
    private $sessionService;

    /**
     * construct
     * @param CacheService $cacheService
     * @param CalculateAveragePrice $calculateAveragePrice
     * @param EventService $eventService
     * @param GetSpendListService $getSpendListService
     * @param ItemService $itemService
     * @param MemberService $memberService
     * @param SessionService $sessionService
     */
    public function __construct(CacheService $cacheService, CalculateAveragePrice $calculateAveragePrice, EventService $eventService, GetSpendListService $getSpendListService, ItemService $itemService, MemberService $memberService, SessionService $sessionService) 
    {
        $this->cacheService = $cacheService;
        $this->calculateAveragePrice = $calculateAveragePrice;
        $this->eventService = $eventService;
        $this->getSpendListService = $getSpendListService;
        $this->itemService = $itemService;
        $this->memberService = $memberService;
        $this->sessionService = $sessionService;
    }

    /**
     * createEventPage
     * @param Request $request
     */
    public function createEventPage()
    {
        // 取得 session 資料
        $sessionData = $this->getSessionData();

        // 取得 event 資料
        $userEvent = $this->eventService->getEventByUserId($sessionData['userId']);

        return view('createEvent', array_merge($sessionData, ['userEvent' => $userEvent,]));
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
            $event = $this->eventService->createEvent([
                'user_id'    => $this->sessionService->getSession('userId'),
                'event_name' => $eventData['name'],
                'event_date' => $eventData['date'],
            ]);

            // 新增成員
            collect($eventData['member'])->each(function (string $member) use ($event) {
                $this->memberService->createMember([
                    'event_id' => $event->id,
                    'name'     => $member,
                ]);
            });

            DB::commit();

            $this->cacheService->setCache(['event_' . $event->id => $event,]);
            $this->sessionService->setSession(['eventId' => $event->id,]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(self::ERROR_MESSAGE)->withInput();
        }

        return redirect()->route('trackSpendingPage');
    }

    /**
     * trackSpendingPage
     * @param Request $request
     */
    public function trackSpendingPage(Request $request)
    {
        // 取得 post 資料
        $post = $request->all();

        // 取得 event id
        $eventId = empty($post) ? (int)$this->sessionService->getSession('eventId') : (int)$post['event'];

        // 取得 session 資料
        $sessionData = $this->getSessionData();

        // 使用 id 取得分帳事件資料
        $eventData = $this->eventService->getEventById($eventId);
        
        // 取得事件名稱
        $eventName = $eventData->event_name;

        // 取得事件成員
        $eventMember = $eventData->member;

        // 取得事件項目
        $items = $eventData->item;

        // 整理項目的花費資訊
        $spendList = $this->getSpendListService->formatItems($eventData->item);

        // 計算成員花費平均
        $averageResult = $this->calculateAveragePrice->calculateAveragePrice($spendList);

        return view('trackSpending', array_merge($sessionData, 
            [
                'eventId'       => $eventId,
                'eventName'     => $eventName,
                'eventMember'   => $eventMember,
                'items'         => $items,
                'spendList'     => $spendList,
                'averageResult' => $averageResult,
            ]
        ));
    }

    /**
     * 取得 Session 資料
     *
     * @return array 包含 userName, userId, token 的陣列
     */
    private function getSessionData(): array
    {
        // 取得 session 資料
        $userName = $this->sessionService->getSession('userName');
        $userId = $this->sessionService->getSession('userId');
        $token = $this->sessionService->getSession('token');

        // 若 session 無資料則導到首頁 
        if (!$userName || !$userId || !$token) {
            redirect('/')->send();
        }

        return compact('userName', 'userId', 'token');
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
        $lastItemId = $this->itemService->getLastItemId();
        $newItemId = $lastItemId ? $lastItemId + 1 : 1;

        DB::beginTransaction();

        try {
            // 新增項目
            collect($itemData['average'])->each(function ($averageMember) use ($itemData, $newItemId) {
                $this->itemService->createItem([
                    'event_id'     => $itemData['eventId'],
                    'item_id'      => $newItemId,
                    'item_name'    => $itemData['item'],
                    'price'        => $itemData['price'],
                    'payer'        => $itemData['payer'],
                    'share_member' => $averageMember,
                ]);
            });
 
            DB::commit();
            $this->cacheService->forgetCache('event_' . $itemData['eventId']);
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
        $lastItemId = $this->itemService->getLastItemId();
        $newItemId = $lastItemId ? $lastItemId + 1 : 1;

        DB::beginTransaction();

        try {
            // 刪除舊的 item 資料
            $this->itemService->deleteItemByEventIdAndItemId($itemData['eventId'], $itemData['itemId']);

            // 新增項目
            collect($itemData['updateAverage'])->each(function ($averageMember) use ($itemData, $newItemId) {
                $this->itemService->createItem([
                    'event_id'     => $itemData['eventId'],
                    'item_id'      => $newItemId,
                    'item_name'    => $itemData['updateItem'],
                    'price'        => $itemData['updatePrice'],
                    'payer'        => $itemData['updatePayer'],
                    'share_member' => $averageMember,
                ]);
            });

            DB::commit();
            $this->cacheService->forgetCache('event_' . $itemData['eventId']);
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(self::ERROR_MESSAGE);
        }

        return redirect()->back();
    }
}
