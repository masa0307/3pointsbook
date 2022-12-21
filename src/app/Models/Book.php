<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    const STATE_READING = '読書中';
    const STATE_INTERESTING = '気になる';

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

    public function user(){
        return $this->belongsTo(User::class);
    }
}
