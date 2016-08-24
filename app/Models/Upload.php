<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'assignment_id', 'user_id', 'name', 'file',
    ];

    public function assignment()
    {
        return $this->belongsTo('App\Models\Assignment');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}