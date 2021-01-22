<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function post()
    {
        return $this->belongsTo('App\Post', 'post_id');
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
