<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Throwable;

abstract class BaseRepository
{
    /**
     * Generic model instance.
     *
     * @var Model
     */
    protected $model;

    /**
     * CoreRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Find all records for a give domain.
     *
     * @return Collection
     */
    public function findAll()
    {
        $query = $this->getQuery();

        return $query->get();
    }

    /**
     * Find model by uuid or fail.
     *
     * @param string $uuid
     *
     * @return Model
     */
    public function findOneByUuIdOrFail(string $uuid)
    {
        return $this->findOneByOrFail(['uuid' => $uuid]);
    }

    /**
     * Creates new model.
     *
     * @param array $attributes
     *
     * @throws Throwable
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        $entity = $this->getModel($attributes);
        $entity->save();

        return $entity;
    }

    /**
     * @param Model $entity
     * @param array $attributes
     *
     * @throws Throwable
     *
     * @return Model
     */
    public function update(Model $entity, array $attributes)
    {
        $entity->fill($attributes);

        $entity->save();

        return $entity->fresh();
    }

    /**
     * Gets current model.
     *
     * @param array $attributes
     *
     * @return Model
     */
    public function getModel(array $attributes = [])
    {
        return $this->model->newInstance($attributes);
    }

    /**
     * Gets query object.
     *
     * @return Builder
     */
    public function getQuery()
    {
        return $this->getModel()->query();
    }
}
