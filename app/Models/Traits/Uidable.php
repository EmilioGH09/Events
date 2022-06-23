<?php
namespace App\Models\Traits;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

trait Uidable {
	
	/**
	 * Set uid on creating method
	 *
	 */
    protected static function bootUidable()
	{
		static::creating(function (Model $model) {
			$model->uid = (string) Uuid::uuid4();
		});    
    }
    
    /**
     * Get key that is used in routes
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uid';
    }

    /**
     * Find item whit the given uids
     *
     * @param $query
     * @param array $values
     * @return void
     */
    public function scopeInUids($query, array $values)
    {
        return $query->whereIn('uid', $values);
    }
}