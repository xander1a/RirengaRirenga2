<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomAdminController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::with('rooms')->get();
        $rooms     = Room::with('roomType')->get();
        return view('admin.rooms.index', compact('roomTypes', 'rooms'));
    }

    public function editType(RoomType $roomType)
    {
        return view('admin.rooms.edit-type', compact('roomType'));
    }

    public function updateType(Request $request, RoomType $roomType)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'currency'        => 'required|in:RWF,USD',
            'max_guests'      => 'required|integer|min:1',
            'amenities'       => 'nullable|string',
            'image'           => 'nullable|image|max:4096',
            'is_active'       => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($roomType->image) Storage::disk('public')->delete($roomType->image);
            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        if (isset($data['amenities'])) {
            $data['amenities'] = array_filter(array_map('trim', explode("\n", $data['amenities'])));
        }

        $data['is_active'] = $request->boolean('is_active');
        $roomType->update($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Room type updated.');
    }

    public function updateRoomStatus(Request $request, Room $room)
    {
        $request->validate(['status' => 'required|in:available,occupied,maintenance,cleaning']);
        $room->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Room status updated.');
    }

    public function storeRoom(Request $request)
    {
        $data = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'name'         => 'required|string|max:255',
            'room_number'  => 'required|string|max:50|unique:rooms,room_number',
            'image'        => 'nullable|image|max:4096',
            'status'       => 'required|in:available,occupied,maintenance,cleaning',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        Room::create($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Room added.');
    }

    public function destroyRoom(Room $room)
    {
        if ($room->bookings()->exists()) {
            return redirect()->route('admin.rooms.index')
                ->with('error', 'Cannot delete a room with existing bookings. Mark it under maintenance instead.');
        }

        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room removed.');
    }
}
