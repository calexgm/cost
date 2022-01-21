<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductWare extends Model
{
    use SoftDeletes;

    protected $table ="product_warehouse";

    protected $fillable = [
        'name', 'description','code_bar','product_category_id', 'price', 'stock', 'status',
        
    ];

    public function category()
    {
        return $this->belongsTo('App\ProductCategory', 'product_category_id')->withTrashed();
    }

    public function solds()
    {
        return $this->hasMany('App\SoldProduct');
    }

    public function receiveds()
    {
        return $this->hasMany('App\ReceivedProduct');
    }
}
