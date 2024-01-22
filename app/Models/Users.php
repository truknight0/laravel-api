<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Users extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $primaryKey = 'idx';

//    public function writes() {
//        return $this->hasMany(QnaBoard::class);
//    }
//
//    public function writeReplies() {
//        return $this->hasMany(QnaBoardReply::class);
//    }
}
