<?php

namespace App\Http\Controllers;

use App\Services\ResultsService;
use Illuminate\Http\Request;

use App\Http\Requests;

class ResultsController extends Controller
{

    protected $results_service;


    public function __construct()
    {

        $this->results_service = app(ResultsService::class);

    }


    public function index()
    {

        $dates = $this->results_service->getDates();
        $users = $this->results_service->getSortedUsers();
        $all   = $this->results_service->getAllReports();

        return view('_results', compact('users', 'all', 'dates'));
    }
}