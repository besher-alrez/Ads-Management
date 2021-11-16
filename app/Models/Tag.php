<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

class Tag extends Model
{
    protected $fillable = [
		'name',
    ];

    public $timestamps = false;


    // Attributes
    public function getCanEditAttribute()
    {
        return Gate::check('edit tags');
    }

    public function getCanDeleteAttribute()
    {
        return Gate::check('delete tags');
    }
    // Relations

    // Scopes

    // Methods
}
