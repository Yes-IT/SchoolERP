<?php

namespace App\Repositories;

use App\Models\Panel;
use Illuminate\Support\Str;
use App\Interfaces\PanelInterface;

class PanelRepository implements PanelInterface
{

    private $model;

    public function __construct(Panel $panelModel)
    {
        $this->model = $panelModel;
    }

    public function all()
    {
        return $this->model->active()->get();
    }

}