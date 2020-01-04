<?php

namespace App\Http\Controllers;

use App\Job;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;

class JobsController extends Controller
{

    public function index()
    {

        $jobs = Job::all();
        return response($jobs, 200);
    }


    public function save(Request $request)
    {

        $job = new Job;
        $job->title = $request->title;
        $job->company = $request->company;
        $job->des = $request->des;
        $job->available = $request->available;
        $job->pic = $request->pic;
        $job->save();

        return response('success', 201);
    }

    public function login(Request $request)
    {
        if ($request->username == "admin") {

            return response("admin", 200);
        } else {

            // if there is no such user in db, register it
            if (!User::where('name', $request->username)->first()) {
                $user = new User;
                $user->name = $request->username;
                $user->job = 0;
                $user->save();
            }

            return response("$request->username", 200);
        }
    }

    public function reserve(Request $request)
    {

        $job = Job::where('id', $request->id)->first();
        $user = User::where('name', $request->username)->first();

        if ($user->job) {
            return response("شما قبلا درخواست خود را ارسال کرده اید", 200);
        } else if ($job->available >= 1) {

            $job->update(['available' => $job->available - 1]);
            $user->update(['job' => $request->id]);
            $user->save();

            return response()->json([
                'msg' => 'ثبت شد',
                'jobId' => $job->id,
                'remainder' => $job->available,
            ], 201);
        } else return response("ظرفیت تمام شده است!", 202);

    }
}
