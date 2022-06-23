<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Filterable;
use App\Models\Traits\Uidable;


class Ticket extends Model
{
    use HasFactory, Uidable, SoftDeletes, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'uid',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Return the filters that should be use by default
     *
     * @return array
     */
    public function filters(): array
    { 
        return  [
            
        ];
    }

    /**
     * Get the comments for the blog post.
     */
    public function event()
    {
        return $this->hasOne(Event::class, 'id', 'event_id');
    }

    /**
     * Get the comments for the blog post.
     */
    public function purchase()
    {
        return $this->hasOne(Purchase::class, 'id', 'purchase_id');
    }
}
