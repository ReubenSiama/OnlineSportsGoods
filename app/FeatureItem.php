<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeatureItem extends Model
{
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
