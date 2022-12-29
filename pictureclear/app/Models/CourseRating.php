<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseRating extends Model
{
    use HasFactory;
    
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'course_id',
        'rating',
    ];
}
