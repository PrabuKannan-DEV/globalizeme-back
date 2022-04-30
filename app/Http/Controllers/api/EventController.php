<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EventResource;
use App\Http\Controllers\API\BaseController as BaseController;

class EventController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $events = $user->events;
        return $events;
        // return $this->sendResponse(EventResource::collection($events), 'Events retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, )
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'date'=>'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $event = Auth::user()->events()->create($input);

        // $event = Event::create($input);

        return $event;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        if (is_null($event)) {
            return $this->sendError('Event not found.');
        }
        return $event;

        // return $this->sendResponse(new EventResource($event), 'Event retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'date' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $event->name = $input['name'];
        $event->description = $input['description'];
        $event->date = $input['date'];
        $event->save();

        return $this->sendResponse(new EventResource($event), 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return $this->sendResponse([], 'Event deleted successfully.');
    }
}
