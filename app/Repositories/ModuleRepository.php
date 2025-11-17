<?php

namespace App\Repositories;

use App\Models\Module;
use App\Interfaces\ModuleInterface;

class ModuleRepository implements ModuleInterface
{
    protected Module $model;

    public function __construct(Module $moduleModel)
    {
        $this->model = $moduleModel;
    }

    public function all(): mixed
    {
        return $this->model->active()->get();
    }

    public function find(int $id): mixed
    {
        return $this->model->find($id);
    }

    public function create(array $data): mixed
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): mixed
    {
        $module = $this->model->findOrFail($id);
        $module->update($data);
        return $module;
    }

    public function delete(int $id): bool
    {
        return (bool) $this->model->destroy($id);
    }

    // public function getByPanels(array $panelIds): mixed
    // {
    //     return $this->model
    //         ->with([
    //             'panel:id,name',
    //             'permissions:id,module_id,keywords'
    //         ])
    //         ->whereIn('panel_id', $panelIds)
    //         ->select('id', 'panel_id', 'name')
    //         ->get()
    //         ->groupBy('panel_id');
    // }

    public function getByPanels(array $panelIds): mixed
    {
        return $this->model
            ->with([
                'panel:id,name',
                'permissions:id,attribute,keywords'
            ])
            ->whereIn('panel_id', $panelIds)
            ->select('id', 'panel_id', 'name', 'slug')
            ->get()
            ->groupBy('panel_id');
    }

    public function getByPanelId(int $panelId): mixed
    {
        return $this->model
            ->where('panel_id', $panelId)
            ->select('id', 'name', 'panel_id')
            ->get();
    }

    public function getGroupedByPanel(): mixed
    {
        return $this->model
            ->with('panel:id,name')
            ->get()
            ->groupBy('panel_id');
    }
}