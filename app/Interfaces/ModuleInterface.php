<?php

namespace App\Interfaces;

interface ModuleInterface
{
    public function all(): mixed;
    public function find(int $id): mixed;
    public function create(array $data): mixed;
    public function update(int $id, array $data): mixed;
    public function delete(int $id): bool;

    public function getByPanels(array $panelIds): mixed;
    public function getByPanelId(int $panelId): mixed;
    public function getGroupedByPanel(): mixed;
}