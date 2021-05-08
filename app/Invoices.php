<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Invoices extends Model
{
    use SoftDeletes;

    use Notifiable;
    
    protected $table = 'invoices';

    protected $guarded = [];

    public function foreignSection () {
        return $this->belongsTo('App\Sections', 'section');
    }

    public function foreignProduct () {
        return $this->belongsTo('App\Products', 'product');
    }
}
