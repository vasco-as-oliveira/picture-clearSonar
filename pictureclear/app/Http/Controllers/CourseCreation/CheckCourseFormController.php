<?php

namespace App\Http\Controllers\CourseCreation;

use App\Models\Course;
use App\Models\CourseRating;
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

    public function viewCourse(Request $request) {
        
        $user = null;
        $find = $request['selectCourse'];
        $course = DB::select('select * from courses where id = '.$find.'');
        if($course){
            $user = DB::select('select * from users where id = '.$course[0]->owner_id.'');
            $rating = DB::select('select * from course_ratings where user_id=? and course_id =? ', [Auth::id(), $course[0]->id]);
            $lessons = DB::select('select * from lessons where course_id = ?', [$course[0]->id]);
            $subscribed_users = DB::select('select user_id from sales where tier_id IN(select id from tiers where course_id=' . $course[0]->id . ') and user_id=' . Auth::user()->id . '');
            $ratesCount = DB::select('select count(*) as contagem from course_ratings where course_id = ?', [$course[0]->id]);
            $chat = DB::select('select * from chats where teacher_id = ? AND student_id = ?', [$course[0]->owner_id, Auth::user()->id ]);
            $chatTeacher = DB::select('select * from chats where teacher_id = ?', [Auth::user()->id]);
            $schedule = DB::select('select * from schedules where user_id = ? AND course_id = ?', [$course[0]->owner_id, $course[0]->id]);

            if(!$chat) $chat[0] = 0;
            if(!$chatTeacher) $chatTeacher[0] = 0;
            if(!$schedule) $schedule[0] = 0;

            if($course[0]->owner_id == Auth::id()){
                return view('coursePageOwner', [
                    'checkCourse' => $course[0],
                     'checkUser' => $user[0], 
                     'checkRating' => $rating,
                     'checkLesson' => $lessons,
                     'checkSubbedUsers' => $subscribed_users,
                     'checkRatesCount'=> $ratesCount,
                     'chat' => $chatTeacher[0],
                     'schedule' => $schedule[0],
                    ]);
            } else if($course[0]->public) {
                return view('checkCourse', [
                    'checkCourse' => $course[0],
                    'checkUser' => $user[0],
                    'checkRating' => $rating,
                    'checkLesson' => $lessons,
                    'checkSubbedUsers' => $subscribed_users,
                    'checkRatesCount'=> $ratesCount,
                    'chat' => $chat[0],
                    'schedule' => $schedule[0],
                    ]);
            }
        }
        return redirect('/home');
    }

    public function finishSetup(Request $request, $id)
    {
      

        if(!empty($request->input('description'))){
            $request->validate([
                'description' => ['string', 'max:150'],
            ]);
            DB::update("update courses set description=? where id=?", [$request->description, $id]);
        }

        if($request->file('inputImage') != null){
            $request->validate([
                'inputImage' => ['image','mimes:png,jpg,jpeg'],
            ]);
            $request->file('inputImage')->store('public/images');
            DB::update("update courses set image =? where id=?", [$request->file('inputImage')->hashName(), $id]);
        }
        return back();
    }

    public function publishRating (Request $request, $id)
    {
        //$rating = $request->input('rate');

        //$request->validate(['rating'=>'required|integer|between:1,5']);
        //return redirect("https://youtu.be/-GGixCs0290");
        
        CourseRating::insert([
            ['user_id' => Auth::user()->id, 'course_id' => $id, 'rating' => $request->input('rating')]
        ]);
        
        $getCourse = DB::select('select * from courses where id = ?', [$id]);
        $selAvgCourseRating = DB::select('select AVG(rating) as media from course_ratings where course_id = ?', [$id]);
        
        DB::update('update courses set rating = ? where id = ?', [$selAvgCourseRating[0]->media, $id]);

        $selAvgUserRating = DB::select('select AVG(rating) as media from course_ratings where course_id IN (select id from courses where owner_id= ? )', [$getCourse[0]->owner_id]);
        DB::update('update users set rating = ? where id = ?', [$selAvgUserRating[0]->media, $getCourse[0]->owner_id]);
        
        return back();
    }
    public function launchCourse(Request $request, $id)
    {
        DB::update("update courses set public = NOT public where id=?", [$id]);
        return back();
    }
}
