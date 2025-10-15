<?php

namespace App\Repositories\Examination;

use App\Interfaces\Examination\ExamTypeInterface;;
use App\Models\Examination\ExamType;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Log;

class ExamTypeRepository implements ExamTypeInterface
{
    use ReturnFormatTrait;

    private $model;

    public function __construct(ExamType $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->active()->get();
    }

    public function getPaginateAll($perPage = 10)
    {
        return $this->model::latest()->paginate($perPage);
    }

    public function store($request)
    {
        // Log::info('request',['request'=>$request->all()] );
        try {
            $row                = new $this->model;
            $row->name          = $request->exam_name;
            $row->description   = $request->description;
            $row->status        = $request->status;
            $row->save();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            Log::error('error',[$th]);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);

        }
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
       Log::info('request',[$request->all()]);
        try {
            $row                = $this->model->findOrfail($id);
            $row->name          = $request->exam_name;
            $row->description   = $request->description;
            $row->status        = $request->status;
            $row->save();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            Log::error('error',[$th]);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        try {
            $row = $this->model->find($id);
            $row->delete();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
