<?php

namespace AdityaDarma\LaravelServiceRepository\Traits;

use Illuminate\Database\Eloquent\Builder;

trait GeneralFunctionRepository
{
    public function findById($id)
    {
        return $this->model
            ->find($id);
    }

    public function findByIdWith($id, $relations)
    {
        return $this->model
            ->with($relations)
            ->find($id);
    }

    public function findByIdWithAndWhereInRelations($id, $relationsWithConditions)
    {
        $query = $this->model;

        foreach ($relationsWithConditions as $relation => $relationConditions) {
            $query->with([$relation => function (Builder $query) use ($relationConditions) {
                foreach ($relationConditions as $condition) {
                    $query->where($condition['column'], $condition['operator'], $condition['value']);
                }
            }]);
        }

        return $query->find($id);
    }

    public function getAll()
    {
        return $this->model
            ->get();
    }

    public function getAllWhere($whereConditions)
    {
        return $this->model
            ->where(function (Builder $query) use($whereConditions) {
                foreach ($whereConditions as $condition) {
                    $query->where($condition['column'], $condition['operator'], $condition['value']);
                }
            })
            ->get();
    }

    public function getAllWithAndWhereInRelations($relationsWithConditions, $whereConditions = [])
    {
        $query = $this->model;

        foreach ($relationsWithConditions as $relation => $relationConditions) {
            $query->with([$relation => function (Builder $query) use ($relationConditions) {
                foreach ($relationConditions as $condition) {
                    $query->where($condition['column'], $condition['operator'], $condition['value']);
                }
            }]);
        }

        return $query->where($whereConditions)->get();
    }

    public function getAllWithWhereHasAndWhereInRelations($relationsWithConditions, $whereConditions = [])
    {
        $query = $this->model;

        foreach ($relationsWithConditions as $relation => $relationConditions) {
            $query->withWhereHas([$relation => function (Builder $query) use ($relationConditions) {
                foreach ($relationConditions as $condition) {
                    $query->where($condition['column'], $condition['operator'], $condition['value']);
                }
            }]);
        }

        return $query->where($whereConditions)->get();
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function update($model, array $data)
    {
        return tap($model)->update($data);
    }

    public function delete($model)
    {
        return $model->delete();
    }

    public function deleteWhereIds(array $id)
    {
        return $this->model->whereIn('id', $id)->delete();
    }
}