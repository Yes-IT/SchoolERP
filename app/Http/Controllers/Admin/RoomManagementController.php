<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Academic\RoomManagementRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Academic\ClassRoom;

class RoomManagementController extends Controller
{
    protected $roomRepository;

    public function __construct(RoomManagementRepositoryInterface $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function index()
    {
        $rooms = $this->roomRepository->all();
        $lastRoom = ClassRoom::orderBy('room_no', 'desc')->first();
        $nextRoomNo = $lastRoom ? str_pad((int)$lastRoom->room_no + 1, 3, '0', STR_PAD_LEFT) : '001';
        return view('backend.room-management.index', compact('rooms', 'nextRoomNo'));
    }

    public function room_availability()
    {
        return view('backend.room-management.room-availability');
    }

    public function storeRoom(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_no' => 'required|string|size:3|unique:class_rooms,room_no',
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $data = $request->only(['room_no', 'capacity', 'location']);
            $data['status'] = $request->has('status') ? 1 : 0; // Handle checkbox
            $room = $this->roomRepository->create($data);
            return response()->json([
                'success' => true,
                'message' => 'Room created successfully.',
                'room' => $room
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create room: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $room = $this->roomRepository->find($id);
            return response()->json([
                'success' => true,
                'room' => $room
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Room not found.'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'room_no' => 'required|string|size:3|unique:class_rooms,room_no,' . $id,
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'status' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $data = $request->only(['room_no', 'capacity', 'location']);
            $data['status'] = $request->has('status') ? 1 : 0; // Handle checkbox
            $room = $this->roomRepository->update($id, $data);
            return response()->json([
                'success' => true,
                'message' => 'Room updated successfully.',
                'room' => $room
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Room not found.'
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->roomRepository->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Room deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Room not found or cannot be deleted.'
            ], 404);
        }
    }
}