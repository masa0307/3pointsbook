<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKeyTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class GroupUser extends Model
{
    use HasFactory;
    use HasCompositePrimaryKeyTrait;

    protected $fillable = [
        'group_id',
        'user_id',
        'is_owner',
        'participation_status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function memogroup(){
        return $this->belongsTo(MemoGroup::class, 'group_id');
    }

    protected $primaryKey = ['group_id', 'user_id'];
    public $incrementing = false;
    protected $table = 'group_users';
}
