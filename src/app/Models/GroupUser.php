<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'user_id',
        'is_owner',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function memogroup(){
        return $this->belongsTo(MemoGroup::class);
    }
}
