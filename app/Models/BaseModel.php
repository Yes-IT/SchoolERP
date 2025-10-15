<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected static function boot()
    {
        parent::boot();

        if (hasModule('MultiBranch')) {
            static::addGlobalScope('branch_id', function (Builder $builder) {
                $table = $builder->getQuery()->from;
                $branchId = auth()->user()->branch_id ?? null;

                if ($branchId) {
                    $builder->where("{$table}.branch_id", $branchId);
                }
            });

            static::creating(function ($model) {
                $branchId = auth()->user()->branch_id ?? null;
                if ($branchId) {
                    $model->branch_id = $branchId;
                }
            });
        }
    }
}
