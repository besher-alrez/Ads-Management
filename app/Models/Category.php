<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

class Category extends Model
{
    protected $fillable = [
		'name',
    ];

    public $timestamps = false;


    // Attributes
    public function getCanEditAttribute()
    {
        return Gate::check('edit categories');
    }

    public function getCanDeleteAttribute()
    {
        return Gate::check('delete categories');
    }

    // Relations

    // Scopes

    // Methods
}
