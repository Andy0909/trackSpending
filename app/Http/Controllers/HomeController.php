<?php

namespace App\Http\Controllers;

use App\Services\CacheService;
use App\Services\CalculateAveragePriceService;
use App\Services\EventService;
use App\Services\ItemsFormatService;
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

    /** @var CalculateAveragePriceService */
    private $calculateAveragePriceService;

    /** @var EventService */
    private $eventService;

    /** @var ItemsFormatService */
    private $itemsFormatService;

    /** @var ItemService */
    private $itemService;

    /** @var MemberService */
    private $memberService;

    /** @var SessionService */
    private $sessionService;

    /**
     * construct
     * @param CacheService $cacheService
     * @param CalculateAveragePriceService $calculateAveragePriceService
     * @param EventService $eventService
     * @param ItemsFormatService $itemsFormatService
     * @param ItemService $itemService
     * @param MemberService $memberService
     * @param SessionService $sessionService
     */
    public function __construct(
        CacheService $cacheService,
        CalculateAveragePriceService $calculateAveragePriceService,
        EventService $eventService,
        ItemsFormatService $itemsFormatService,
        ItemService $itemService,
        MemberService $memberService,
        SessionService $sessionService
    ) 
    {
        $this->cacheService = $cacheService;
        $this->calculateAveragePriceService = $calculateAveragePriceService;
        $this->eventService = $eventService;
        $this->itemsFormatService = $itemsFormatService;
        $this->itemService = $itemService;
        $this->memberService = $memberService;
        $this->sessionService = $sessionService;
    }

    /**
     * 新增活動頁面
     */
    public function createEventPage()
    {
        // 取得 session 資料
        $sessionData = $this->getSessionData();

        // 取得活動資料
        $userEvent = $this->eventService->getEventByUserId($sessionData['userId']);

        return view('createEvent', array_merge($sessionData, ['userEvent' => $userEvent,]));
    }

    /**
     * 新增活動
     * @param Request $request
     */
    public function createEventProcess(Request $request)
    {
        // 取得用戶輸入之活動資料
        $eventData = $request->all();

        DB::beginTransaction();

        try {
            // 新增活動
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

            // 活動資料存進 cache
            $this->cacheService->setCache(['event_' . $event->id => $event,]);

            // 活動 id 存進 seesion 讓 trackSpendingPage 使用
            $this->sessionService->setSession(['eventId' => $event->id,]);

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('errorMessage', self::ERROR_MESSAGE)->withInput();
        }

        return redirect()->route('trackSpendingPage');
    }

    /**
     * 分帳頁面
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
        $formattedItems = $this->itemsFormatService->formatItems($items);

        // 計算成員花費平均
        $averageResult = $this->calculateAveragePriceService->calculateAveragePrice($formattedItems);

        return view('trackSpending', array_merge($sessionData, 
            [
                'eventId'        => $eventId,
                'eventName'      => $eventName,
                'eventMember'    => $eventMember,
                'items'          => $items,
                'formattedItems' => $formattedItems,
                'averageResult'  => $averageResult,
            ]
        ));
    }

    /**
     * 取得 Session 資料
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
     * 新增分帳項目
     * @param Request $request
     */
    public function createItemProcess(Request $request)
    {
        // 取得項目資料
        $itemData = $request->all();

        // 取得資料庫最後一個 item_id 並 + 1
        $lastItemId = $this->itemService->getLastItemId();
        $newItemId = $lastItemId ? $lastItemId + 1 : 1;

        DB::beginTransaction();

        try {
            // 新增項目
            collect($itemData['average'])->each(function (string $shareMember) use ($itemData, $newItemId) {
                $this->itemService->createItem([
                    'event_id'     => $itemData['eventId'],
                    'item_id'      => $newItemId,
                    'item_name'    => $itemData['item'],
                    'price'        => $itemData['price'],
                    'payer'        => $itemData['payer'],
                    'share_member' => $shareMember,
                ]);
            });
 
            DB::commit();

            // 刪除 cache 以抓取新資料
            $this->cacheService->forgetCache('event_' . $itemData['eventId']);

            // 活動 id 存進 seesion 讓 trackSpendingPage 使用
            $this->sessionService->setSession(['eventId' => $itemData['eventId'],]);

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('errorMessage', self::ERROR_MESSAGE)->withInput();
        }

        return redirect()->back();
    }

    /**
     * 更新分帳項目
     * @param Request $request
     */
    public function updateItemProcess(Request $request)
    {
        // 取得項目資料
        $itemData = $request->all();

        // 取得資料庫最後一個 item_id 並 + 1
        $lastItemId = $this->itemService->getLastItemId();
        $newItemId = $lastItemId ? $lastItemId + 1 : 1;

        DB::beginTransaction();

        try {
            // 刪除舊的 item 資料
            $this->itemService->deleteItemByEventIdAndItemId($itemData['eventId'], $itemData['itemId']);

            // 新增項目
            collect($itemData['updateAverage'])->each(function ($shareMember) use ($itemData, $newItemId) {
                $this->itemService->createItem([
                    'event_id'     => $itemData['eventId'],
                    'item_id'      => $newItemId,
                    'item_name'    => $itemData['updateItem'],
                    'price'        => $itemData['updatePrice'],
                    'payer'        => $itemData['updatePayer'],
                    'share_member' => $shareMember,
                ]);
            });

            DB::commit();

            // 刪除 cache 以抓取新資料
            $this->cacheService->forgetCache('event_' . $itemData['eventId']);

            // 活動 id 存進 seesion 讓 trackSpendingPage 使用
            $this->sessionService->setSession(['eventId' => $itemData['eventId'],]);
    
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('errorMessage', self::ERROR_MESSAGE);
        }

        return redirect()->back();
    }
}