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

    public function genre(){
        return $this->belongsTo(Genre::class);
    }

    public function memo(){
        return $this->hasMany(Memo::class);
    }
}
