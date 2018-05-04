<?php

namespace App\Models\Tools;

use Illuminate\Database\Eloquent\Model;

class Subcategories extends Model
{
    protected $fillable = ['airport_id', 'subcategory_name'];

    protected $guarded = ['airport_id'];

    public $timestamps = true;

    // public function airports()
    // {
    //     return $this->hasMany(Airports::class, 'airport_id', 'id');
    // }
}
