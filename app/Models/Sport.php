<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    //
     protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public function equipment()
{
    return $this->belongsToMany(
        Equipment::class,
        'equipment_sport',
        'sport_id',
        'equipment_id'
    )->withTimestamps();
}
}
