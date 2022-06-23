<?php
namespace App\Filters\Shared;

use Illuminate\Support\Arr;
use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class SortFilter extends FilterAbstract
{
    /**
     * Table to validate column
     *
     * @var String
     */
    public $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    /**
     * Set if the filter need all request query
     *
     * @return void
     */
    public function useFullQuery()
    {
        return true;
    }

    /**
     * Apply filter to data
     *
     * @param Builder $builder
     * @param string $value
     * @return $builder
     */
    public function filter(Builder $builder, $value)
    {
        if (!Schema::hasColumn($this->table, Arr::get($value,'sort'))) {
            return $builder;  
        }

        return $builder->orderBy(
            Arr::get($value,'sort'), 
            $this->setDirection(Arr::get($value,'direction'))
        );
    }

    /**
     * Set the availabale directions
     *
     * @param string $direction
     * @return string
     */
    public function setDirection($direction)
    {
        if(!in_array($direction, ['asc', 'desc'])){
            return 'desc';
        }

        return $direction;
    }
}