<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'group_id',
        'before_reading_content',
        'reading_content',
        'after_reading_content',
        'actionlist1_content',
        'actionlist2_content',
        'actionlist3_content',
        'feedback1_content',
        'feedback2_content',
        'feedback3_content',
        'is_viewed'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function group(){
        return $this->belongsTo(Group::class);
    }
}
