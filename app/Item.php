<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;
    public function item_category()
    {
        return $this->belongsTo(ItemCategory::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
