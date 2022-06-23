<?php

namespace App\Models\Traits;

use App\Filters\Filters;
use Illuminate\Database\Eloquent\Builder;

trait Filterable 
{
    /**
     * Return the filters that should be use by default
     *
     * @return array
     */
    abstract public function filters() : array;

    /**
     * Get Filter Data
     *
     * @param Illuminate\Database\Eloquent\Builder $builder
     * @param array $query
     * @return void
     */
    public function scopeFilter(Builder $builder, array $query)
    {
        return (new Filters($query))
            ->add($this->filters())
            ->filter($builder);
    }
}