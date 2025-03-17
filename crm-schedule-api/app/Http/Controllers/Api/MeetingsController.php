<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeetingCreateRequest;
use App\Http\Requests\MeetingUpdateRequest;
use App\Models\Meetings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class MeetingsController extends Controller
{
    public function create(MeetingCreateRequest $request)
    {
        $meetingData = $request->all();

        $meetingData['user_id'] = $request->user()->id;
        $meetingData['link'] = 'https://meet.com/ashajhskjahsjhas';

        $meeting = Meetings::create($meetingData);
        $meeting->participants()->attach($request->get('participants_id'));

        return response()->json($meeting->toArray());
    }

    public function list(Request $request): JsonResponse
    {
        return response()->json(Meetings::all()->toArray());
    }

    public function read(int $id, Request $request): JsonResponse
    {
        return response()->json(Meetings::where('id', $id)->first());
    }

    public function update(int $id, MeetingUpdateRequest $request): JsonResponse
    {
        try {
            $meeting = Meetings::where('id', $id)->first();

            $meeting->update($request->all());
            $meeting->participants()->attach($request->get('participants_id'));

            return response()->json($meeting);
        } catch (Exception $exception) {
            return response()->json(['' => $exception->getMessage()], 500);
        }
    }
}
