<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\GroupUse;

class MemoGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name'
    ];

    public function user(){
        return $this->belongsToMany(User::class, 'group_users', 'group_id', 'user_id')->withPivot('is_owner', 'participation_status');

    }

    public function memo(){
        return $this->hasMany(Memo::class, 'group_id');
    }

}
