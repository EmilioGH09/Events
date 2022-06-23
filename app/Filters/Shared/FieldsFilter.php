<?php
namespace App\Filters\Shared;

use Illuminate\Support\Arr;
use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class FieldsFilter extends FilterAbstract
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
     * Apply filter to data
     *
     * @param Builder $builder
     * @param string $value
     * @return $builder
     */
    public function filter(Builder $builder, $value)
    {
        $values = explode(',', $value);

        foreach ($values as $value) {
            if (!Schema::hasColumn($this->table, $value)) {
                return $builder;  
            }
        }

        return $builder->select($values);
    }
    
}