<?php

namespace App\Interfaces\Academic;

use Illuminate\Http\Request;

interface SubjectInterface
{
    public function getDistinctNames();

    public function getFiltered(Request $request, $perPage);

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);
}