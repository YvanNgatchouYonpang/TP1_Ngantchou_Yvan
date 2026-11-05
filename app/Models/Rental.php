<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    //
       protected $table = 'rentals';

    protected $fillable = [
        'startDate',
        'endDate',
        'totalPrice',
        'userId',
        'equipmentId',
    ];

    public $timestamps = false;

    public function user()
{
    return $this->belongsTo(User::class, 'userId');
}

public function equipment()
{
    return $this->belongsTo(Equipment::class, 'equipmentId');
}

public function reviews()
{
    return $this->hasMany(Review::class, 'rentalId');
}


}
