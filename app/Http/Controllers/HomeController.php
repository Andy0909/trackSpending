<?php

namespace App\Http\Controllers;

use App\Services\SessionService;
use App\Repositories\EventRepository;
use App\Repositories\MemberRepository;
use App\Repositories\ItemRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class HomeController extends Controller
{
    private $sessionService;

    public function __construct(SessionService $sessionService, EventRepository $eventRepository, MemberRepository $memberRepository, ItemRepository $itemRepository) 
    {
        $this->sessionService = $sessionService;
        $this->eventRepository = $eventRepository;
        $this->memberRepository = $memberRepository;
        $this->itemRepository = $itemRepository;
    }

    public function home($eventId, $eventName)
    {
        $userName = $this->sessionService->getSession('userName');
        $eventData = $this->eventRepository->getEventById($eventId);
        if ($eventData->first()['event_name'] === $eventName) {
            $eventName = $eventData->first()['event_name'];
            $eventMember = $eventData->first()['member'];
            return view('home')->with([
                'eventId'     => $eventId,
                'eventName'   => $eventName,
                'eventMember' => $eventMember,
                'userName'    => $userName,
            ]);
        }
        return redirect()->back();
    }

    public function getTrackSpendingSystem(Request $request)
    {
        $trackSpendingSystem = $request->all();
        $eventData = $this->eventRepository->getEventById($trackSpendingSystem['eventId']);
        if ($eventData->first()['event_name'] === $trackSpendingSystem['eventName']) {
            $eventName = $eventData->first()['event_name'];
            return redirect()->route('home')->with('eventData',$eventName);
        }
        else {
            return redirect()->back();
        }
    }

    public function getItem(Request $request)
    {
        $itemData = $request->all();

        file_put_contents('itemData.php',print_r($itemData,true));

        DB::beginTransaction();
        try {
            collect($itemData['average'])->each(function ($averageMember) use ($itemData) {
                $this->itemRepository->createItem([
                    'event_id'     => $itemData['eventId'],
                    'item_name'    => $itemData['item'],
                    'price'        => $itemData['price'],
                    'payer'        => $itemData['payer'],
                    'share_member' => $averageMember,
                    'message'      => $itemData['message'],
                ]);
            });

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back();
        }

        return redirect()->back();
    }

    public function createTrackSpendingSystem()
    {
        $userName = $this->sessionService->getSession('userName');
        $userId = $this->sessionService->getSession('userId');
        $token = $this->sessionService->getSession('token');
        $userEvent = $this->eventRepository->getEventByUserId($userId);

        return view('createTrackSpendingSystem', [
            'userName'  => $userName,
            'userId'    => $userId,
            'token'     => $token,
            'userEvent' => $userEvent,
        ]);
    }

    public function getEvent(Request $request)
    {
        $eventData = $request->all();

        DB::beginTransaction();
        try {
            $event = $this->eventRepository->createEvent([
                'user_id' => $this->sessionService->getSession('userId'),
                'event_name' => $eventData['name'],
                'event_date' => $eventData['date'],
            ]);

            collect($eventData['member'])->each(function ($member) use ($event){
                $this->memberRepository->createMember([
                    'event_id' => $event->id,
                    'name' => $member,
                ]);
            });

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back();
        }

        return redirect()->route('home');
    }
}
