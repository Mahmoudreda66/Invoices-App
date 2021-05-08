<?php

namespace App;

use App\Sections;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';

    protected $fillable = [
    	'product_name',
    	'section_id',
    	'description'
    ];

    public function section()
    {
        return $this->belongsTo(Sections::class);
    }
}
