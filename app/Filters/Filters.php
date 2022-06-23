<?php
namespace App\Filters;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;

class Filters
{	
	/**
	 * Request quert
	 *
	 * @var array
	 */
	protected $query;
	
	/**
	 * Model available filters
	 *
	 * @var array
	 */
    protected $filters = [];
	
    function __construct(array $query)
	{
		$this->query = $query;
	}
	
	/**
	 * Apply filters to the request
	 *
	 * @param Builder $builder
	 * @return $builder
	 */
    public function filter(Builder $builder)
	{
		foreach ($this->getFilters() as $filter => $value) {
			$filterClass = $this->resolveFilters($filter);

			if($filterClass->useFullQuery()){
				$filterClass->filter($builder, $this->query);
			}else{
				$filterClass->filter($builder, $value);
			}
			
		}
	
    	return $builder;
	}
	
	/**
	 * Add the model's filters
	 *
	 * @param array $filters
	 * @return $this
	 */
    public function add(array $filters)
	{
	
    	$this->filters = array_merge($this->filters, $filters);
		
    	return $this;
	}
	
	/**
	 * The the model's filters
	 *
	 * @return array
	 */
    public function getFilters()
	{
		return $this->filterFilters($this->filters);
	}
	
	/**
	 * Resolve the declared filters
	 *
	 * @param string $filter
	 * @return object
	 */
    public function resolveFilters($filter)
	{
		if(is_object($this->filters[$filter])){
			return $this->filters[$filter];
		}

		return new $this->filters[$filter];
	}
	
	/**
	 * Get only the availabale model's filers
	 *
	 * @param array $filters
	 * @return array
	 */
	public function filterFilters($filters)
	{
		return array_filter(Arr::only($this->query, array_keys($filters)));
	}
}