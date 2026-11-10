<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rental extends Model
{
        use HasFactory;
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
