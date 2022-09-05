<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\GroupUse;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name'
    ];

    public function groupuser(){
        return $this->hasMany(GroupUser::class);
    }

    public function memo(){
        return $this->hasMany(Memo::class);
    }

}
