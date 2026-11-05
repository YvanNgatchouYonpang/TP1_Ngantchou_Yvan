<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    //
     protected $table = 'equipment';

    protected $fillable = [
        'name',
        'description',
        'dailyPrice',
        'categoryId',
    ];

    public $timestamps = false;

    public function category()
{
    return $this->belongsTo(Category::class, 'categoryId');
}

public function sports()
{
    return $this->belongsToMany(
        Sport::class,
        'equipment_sport',
        'equipment_id',
        'sport_id'
    )->withTimestamps();
}

public function rentals()
{
    return $this->hasMany(Rental::class, 'equipmentId');
}


}
