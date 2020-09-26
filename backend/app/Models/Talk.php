<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    protected $fillable = [
        'host_id', 'guest_id', 'comment', 'image'
    ];


    //リレーション作成
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
