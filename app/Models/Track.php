<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ExamQuestion;

class Track extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'student_track')->withPivot('created_at', 'updated_at', 'status', 'score');
    }
    public function examQuestions(){
        return $this->BelongsToMany(ExamQuestion::class);
    }
}
