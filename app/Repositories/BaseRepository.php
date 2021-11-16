<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return Builder
     */
    public function query()
    {
        return $this->model->newQuery();
    }

    public function select(array $columns = ['*']): Builder
    {
        return $this->query()->select($columns);
    }

    public function make(array $attributes = []): Model
    {
        return $this->query()->make($attributes);
    }

    protected function fillTranslatables(Model &$model,array $input = [], $force=false): void
    {
        foreach ($this->translatables as $translatable) {
            $model->fillTranslations($translatable, $input[$translatable], $force);
        }
    }
}
