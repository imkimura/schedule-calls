<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeetingCreateRequest;
use App\Http\Requests\MeetingUpdateRequest;
use App\Http\Resources\MeetingsResource;
use App\Models\Meetings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class MeetingsController extends Controller
{
    public function create(MeetingCreateRequest $request): JsonResponse
    {
        try {
            $meetingData = $this->prepareMeetingData($request);
            $meeting = Meetings::create($meetingData);
            $this->syncParticipants($meeting, $request->get('participants_id'));

            return response()->json($meeting->toArray());
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }

    public function list(Request $request): JsonResponse
    {
        $meetings = MeetingsResource::collection(Meetings::all());
        return response()->json($meetings);
    }

    public function read(int $id, Request $request): JsonResponse
    {
        $meeting = Meetings::find($id);

        if (!$meeting) {
            return response()->json(['error' => 'Meeting not found'], 404);
        }

        return response()->json((new MeetingsResource($meeting))->resolve());
    }

    public function update(int $id, MeetingUpdateRequest $request): JsonResponse
    {
        try {
            $meeting = Meetings::find($id);

            if (!$meeting) {
                return response()->json(['error' => 'Meeting not found'], 404);
            }

            $meeting->update($request->all());
            $this->syncParticipants($meeting, $request->get('participants_id'));

            return response()->json($meeting);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }

    private function prepareMeetingData(Request $request): array
    {
        return array_merge($request->all(), [
            'user_id' => $request->user()->id,
            'link' => $this->generateMeetingLink(),
        ]);
    }

    private function generateMeetingLink(): string
    {
        return 'https://meet.com/' . uniqid();
    }

    private function syncParticipants(Meetings $meeting, array $participantsId): void
    {
        $meeting->participants()->sync($participantsId);
    }

    private function handleException(Exception $exception): JsonResponse
    {
        return response()->json(['error' => $exception->getMessage()], 500);
    }
}
