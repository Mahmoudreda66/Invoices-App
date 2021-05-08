<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoicesAttachments extends Model
{
    protected $guarded = [];

    public function userInfo ()
    {
        return $this->belongsTo('App\User', 'user');
    }
}
