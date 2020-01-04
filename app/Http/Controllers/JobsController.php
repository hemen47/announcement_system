<?php

namespace App\Http\Controllers;

use App\Job;
use App\User;
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
            return response("شما قبلا درخواست خود را ارسال کرده اید", 400);
        } else


            $job->update(['available' => $job->available - 1]);
            $user->update(['job' => $request->id]);

        return response()->json([
            'remainder' => $job->available, 201
        ]);

    }

}
