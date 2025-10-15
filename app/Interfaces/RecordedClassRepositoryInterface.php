<?php

namespace App\Interfaces;

interface RecordedClassRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data, $file = null);
    public function update($id, array $data, $file = null);
    public function delete($id);
    public function getByType(string $type);
}