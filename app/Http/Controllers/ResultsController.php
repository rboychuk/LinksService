<?php

namespace App\Http\Controllers;

use App\Services\ResultsService;
use App\Site;
use Illuminate\Http\Request;

class ResultsController extends Controller
{

    protected $results_service;

    const FILE_GOALS = 'file_goals.csv';


    public function __construct()
    {

        $this->middleware('auth');

    }


    public function index()
    {

        $sites = Site::all();

        return view('results', compact('sites'));
    }


    public function getResults(Request $request)
    {

        $data = $request->all();

        $results_service = new ResultsService($data['site_id'], $data['meta']);

        $sites = Site::all();
        $dates = $results_service->getDates();
        $users = $results_service->getSortedUsers();
        $goals = $results_service->getSortedGoals();

        //$all   = $results_service->getAllReports();

        return view('results', compact('results_service', 'users', 'all', 'dates', 'sites', 'goals'));

    }


    public function addGoals(Request $request)
    {

        $uploadfile = storage_path(self::FILE_GOALS);

        move_uploaded_file($_FILES['file_goals']['tmp_name'], $uploadfile);

        return redirect(route('results'));

    }
}
