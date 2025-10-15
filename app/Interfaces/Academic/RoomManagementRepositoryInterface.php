<?php

namespace App\Interfaces\Academic;

interface RoomManagementRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function checkAvailability(\DateTime $checkIn, \DateTime $checkOut);
}