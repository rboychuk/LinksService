<?php
/**
 * Created by PhpStorm.
 * User: beaver
 * Date: 1/15/19
 * Time: 12:04 PM
 */

namespace App\Services;

use App\Link;
use App\User;

class ResultsService
{

    protected $links;

    protected $results;

    protected $available_emails = [
        'demianenko.kiril@gmail.com',
        'kirilovsts@gmail.com',
        'wrightdylan1991@gmail.com',
        'milton.iris@gmail.com',
        'alex101ki@gmail.com',
    ];


    public function __construct()
    {

        $this->links = Link::whereIn('creator', $this->available_emails)->orderBy('created_at')->get();

    }


    public function getDates()
    {

        $dates = $this->links->map(function ($link) {
            return date('Y-M', strtotime($link->created_at));
        })->unique(function ($link) {
            return $link;
        });

        return $dates;

    }


    public function getSortedUsers()
    {

        $users = User::whereIn('email', $this->available_emails)->get();

        $dates = $this->getDates();

        $results = [];

        foreach ($users as $user) {
            $results[$user->name] = [];
            foreach ($dates as $date) {
                $results[$user->name][$date] = $this->links->filter(function ($link) use ($user, $date) {
                    return $link->creator == $user->email && date('Y-M', strtotime($link->created_at)) == $date;
                });
            }
        }

        $this->results = $results;

        return $results;

    }


    public function getAllReports()
    {

        $results = [];

        foreach ($this->results as $user) {
            foreach ($user as $date => $value) {
                if ( ! isset($results[$date])) {
                    $results[$date] = 0;
                }
                $results[$date] += $value->count();
            }
        }

        return $results;

    }


    protected function getUsers()
    {

        $users = User::all();

        return $users;
    }

}