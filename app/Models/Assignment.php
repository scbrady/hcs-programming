<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Assignment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'due', 'lockout'
    ];
    protected $casts = [
        'due' => 'date',
    ];

    public function uploads()
    {
        return $this->hasMany('App\Models\Upload');
    }

    public function upload()
    {
        return $this->hasOne('App\Models\Upload')->where('user_id', '=', Auth::user()->id);
    }
}
