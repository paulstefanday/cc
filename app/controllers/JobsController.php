<?php

use Carbon\Carbon;

class JobsController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('auth', array('only' => ['store', 'index', 'storeFavorite', 'destroyFavorite'] ));
        $this->beforeFilter('auth.job', array('only' => ['show', 'update', 'destory'] ));
    } 

	public function feed()
	{
		$jobs = Job::all()->toArray();
		return Response::json(['data' => $jobs ], 200);
	}

	public function favorites()
	{
		$jobs = Favorite::where('user_id', 1)->with('Job')->get()->toArray();
		return Response::json(['data' => $jobs ], 200);
	}

	public function storeFavorite()
	{
		$fav = new Favorite;
		$fav->user_id 		= userId();
		$fav->job_id 		= Input::get('job_id');
		$create = $fav->save();
		return Response::json(['data' => $fav ], 200);
	}

	public function destroyFavorite($id)
	{
		$fav = Favorite::find($id);
		$result = $fav->delete();
		return Response::json(['data' => $result ], 200);
	}


	public function index()
	{
		$jobs = Job::where('user_id', userId())->get()->toArray();
		return Response::json(['data' => $jobs ], 200);
	}

	public function store()
	{
		$job = new Job;
		$job->heading 		= Input::get('heading');
		$job->description 	= Input::get('description');
		$job->user_id 		= userId();
		$job->salary_max 	= Input::get('salary_max');
		$job->salary_min 	= Input::get('salary_min');
		$job->start_date 	= Input::get('start_date');
		$job->end_date 		= Input::get('end_date');
		$job->state 		= Input::get('state');
		$job->suburb 		= Input::get('suburb');
		$update = $job->save();
		return Response::json(['data' => $job ], 200);
	}

	public function show($id)
	{
		$job = Job::find( $id );
		return Response::json(['data' => $job ], 200);
	}

	public function update($id)
	{
		$job = Job::find($id);
		$job->heading 		= Input::get('heading');
		$job->description 	= Input::get('description');
		// $job->location 		= Input::get('location');
		$job->salary_max 	= Input::get('salary_max');
		$job->salary_min 	= Input::get('salary_min');
		$job->start_date 	= Input::get('start_date');
		$job->end_date 		= Input::get('end_date');
		$job->state 		= Input::get('state');
		$job->suburb 		= Input::get('suburb');
		$job->save();

		if($job) return Response::json(['data' => $job ], 200);
		return Response::json(['error' => $update ], 500);
	}

	public function destroy($id)
	{
		$job = Job::find($id);
		$result = $job->delete();
		return Response::json(['data' => $result ], 200);
	}

}