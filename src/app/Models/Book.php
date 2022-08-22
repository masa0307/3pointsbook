<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'genre_id',
        'title',
        'author',
        'image_path',
        'state'
    ];

    public function book(){
        return $this->hasMany(Book::class);
    }
}
