<?php

namespace App\Http\Controllers\Api\V1;

use App\Event;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\EventResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EventsController extends BaseController
{
    public function index(Request $request)
    {
        $events = Event::orderBy('start_at', 'desc')->groupBy('responsible_id')->get();
        return $this->sendResponse(
            EventResource::collection($events),
            'Events loaded successfully.',
            200
        );
    }

    public function show(Request $request, Event $event)
    {
        return $this->sendResponse(
            EventResource::collection($event->toArray()),
            'Event loaded successfully',
            200
        );
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|string',
            'observation' => 'present|text',
            'start_at' => 'required|date_format:Y-m-d H:i',
            'end_at' => 'required|date_format:Y-m-d H:i',
            'responsible_id' => 'required|integer'
        ]);

        try {
            $event = new Event();
            $event->description = $request->description;
            $event->observation = $request->observation;
            $event->start_at = $request->start_at;
            $event->end_at = $request->end_at;
            $event->responsible_id = $request->responsible_id;
            $event->owner_id = Auth::id();
            $event->save();

            return $this->sendResponse(
                EventResource::collection($event->toArray()),
                'Event created successfully',
                201
            );
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function update(Request $request, Event $event)
    {
        $this->validate($request, [
            'description' => 'required|string',
            'observation' => 'present|text',
            'start_at' => 'required|date_format:Y-m-d H:i',
            'end_at' => 'required|date_format:Y-m-d H:i',
            'responsible_id' => 'required|integer'
        ]);

        try {
            $event->update($request->only(
                'description',
                'observation',
                'start_at',
                'end_at',
                'responsible_id'
            ));

            return $this->sendResponse(
                EventResource::collection($event->toArray()),
                'Event updated successfully',
                200
            );
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function remove(Request $request, Event $event)
    {
        $event->delete();
        return response()->noContent();
    }
}
