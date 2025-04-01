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
        'track_id'
    ];

    public function track()
    {
        return $this->belongsTo(Track::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    
}
