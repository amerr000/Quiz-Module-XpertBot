<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Answer;
use app\Models\Track;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticable;

class Student extends Authenticable
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $fillable = [
        'full_name',
        'email',
        'password',
    ];
    public function answers(){
        return $this->belongsToMany(Answer::class);
    }
    public function tracks(){
        return $this->belongsToMany(Track::class);
    }
    //the $this here refers to the object that is calling the method
}
