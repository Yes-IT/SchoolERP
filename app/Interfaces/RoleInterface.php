<?php

namespace App\Interfaces;

interface RoleInterface
{

    public function all();

    public function custom();

    public function customLatest();

    public function getAll();
    
    public function getLatest();

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);
}
