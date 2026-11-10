<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
     use HasFactory;

      protected $fillable = [
        'rating',
        'comment',
        'userId',
        'rentalId',
    ];

    public $timestamps = false;

    public function user()
{
    return $this->belongsTo(User::class, 'userId');
}

public function rental()
{
    return $this->belongsTo(Rental::class, 'rentalId');
}
}
