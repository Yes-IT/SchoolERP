<?php

namespace App\Repositories\Academic;

use App\Interfaces\Academic\RoomManagementRepositoryInterface;
use App\Models\Academic\ClassRoom;
use Illuminate\Support\Facades\DB;

class RoomManagementRepository implements RoomManagementRepositoryInterface
{
    protected $model;

    public function __construct(ClassRoom $room)
    {
        $this->model = $room;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $room = $this->find($id);
        $room->update($data);
        return $room;
    }

    public function delete($id)
    {
        $room = $this->find($id);
        return $room->delete();
    }

    public function checkAvailability(\DateTime $checkIn, \DateTime $checkOut)
    {
        // Implementation for room availability check (if needed)
    }
}