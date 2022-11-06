<?php

namespace App\Http\Controllers;

use App\Services\SessionService;
use App\Repositories\EventRepository;
use App\Repositories\MemberRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class HomeController extends Controller
{
    private $sessionService;

    public function __construct(SessionService $sessionService, EventRepository $eventRepository, MemberRepository $memberRepository) 
    {
        $this->sessionService = $sessionService;
        $this->eventRepository = $eventRepository;
        $this->memberRepository = $memberRepository;
    }

    public function home()
    {
        return view('home');
    }

    public function createTrackSpendingSystem()
    {
        $userName = $this->sessionService->getSession('userName');
        $userId = $this->sessionService->getSession('userId');
        $userEvent = $this->eventRepository->getEventByUserId($userId);

        return view('createTrackSpendingSystem', [
            'userName'  => $userName,
            'userId'    => $userId,
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
