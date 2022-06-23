<?php
namespace App\Filters\Shared;

use Illuminate\Support\Arr;
use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class ExtendFilter extends FilterAbstract
{
    /**
     * Available extends of the model
     *
     * @var array
     */
    private $availableExtends = [];

    public function __construct(array $extends)
    {
        $this->availableExtends = $extends;
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

        return $builder->with(array_intersect($this->availableExtends, $values));
    }
}
