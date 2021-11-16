<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;


class Ad extends Model
{

    protected $fillable = [
		'type',
		'title',
		'description',
		'category_id',
		'advertiser',
    ];

    public $timestamps = false;


    public function getCanEditAttribute()
    {
        return Gate::check('edit ads');
    }

    public function getCanDeleteAttribute()
    {
        return Gate::check('delete ads');
    }

    // Relations
	public function category()
	{
		return $this->belongsTo(Category::class, 'category_id');
	}


    public function ad_tags()
    {
        return $this->belongsToMany(Tag::class);
    }

}
