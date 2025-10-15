<?php

namespace App\Interfaces;

interface AlumniGalleryRepositoryInterface
{
    public function all();
    public function create(array $data, $file);
}