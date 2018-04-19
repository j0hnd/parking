<?php

namespace App\Models\Tools;

use Illuminate\Database\Eloquent\Model;

class Subcategories extends Model
{
    protected $fillable = ['airport_id', 'subcategory_id'];

    protected $guarded = ['airport_id', 'subcategory_id'];

    public $timestamps = true;
}
