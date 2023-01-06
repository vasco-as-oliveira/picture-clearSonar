<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
       'teacher_id',
       'student_id',
    ];
}
