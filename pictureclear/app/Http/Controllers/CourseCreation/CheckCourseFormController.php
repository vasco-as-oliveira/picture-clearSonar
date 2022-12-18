<?php

namespace App\Http\Controllers\CourseCreation;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;




class CheckCourseFormController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function checkCourse(Request $request) {
        $find = $request['findCourse'];
        $courses = DB::select('select * from courses where UPPER(title) LIKE UPPER(\'%'.$find.'%\')');
        $user = DB::select('select * from users where id = '.$courses[0]->owner_id.'');

        return view('checkCourse', ['checkCourse' => $courses, 'checkUser' => $user])->with('success', '!');
    }

    public function viewCourse(Request $request) {
         $find = $request['selectCourse'];
         $course = DB::select('select * from courses where id = '.$find.'');
         $user = DB::select('select * from users where id = '.$course[0]->owner_id.'');
        return view('checkCourse', ['checkCourse' => $course, 'checkUser' => $user])->with('success', '!');
    }
}
