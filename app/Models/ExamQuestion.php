<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Answer;
use App\Models\Track;

class ExamQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'question',
        'grade',
    ];

    public function tracks()
    {
        return $this->belongsToMany(Track::class)->withPivot('created_at','updated_at');
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    
}
