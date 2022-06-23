<?php
namespace App\Filters;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;

abstract class FilterAbstract
{
	/**
	 * Apply filter to data
	 *
	 * @param Builder $builder
	 * @param [type] $value
	 * @return void
	 */
	abstract public function filter(Builder $builder, $value);

	/**
	  * Set if the filter need all request query
	  *
	  * @return void
	  */
	public function useFullQuery()
	{
		return false;
	}

	/**
	 * filter's value mapper 
	 *
	 * @return void
	 */
    public function mappings()
	{
		return [];
	}

	/**
	 * Resolve the mapping values
	 *
	 * @param string $key
	 * @return string
	 */
	public function resolveFilterValue($key)
	{
		return Arr::get($this->mappings(), $key);
	}
}