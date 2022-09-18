<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'genre_name',
        'user_id'
    ];

    public function book(){
        return $this->hasMany(Book::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
