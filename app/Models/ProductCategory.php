<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductCategory extends Model
{
    protected $table = "product_category";

    protected $fillable = ['name'];

    public function products() {
        return $this->hasMany(Product::class, 'category_id');
    }
}
