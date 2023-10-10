<?php
/**
 * Created by PhpStorm.
 * User: beaver
 * Date: 1/15/19
 * Time: 12:04 PM
 */

namespace App\Services;

use App\Link;
use App\Site;
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
        'produa98@gmail.com',
        'mega.putilovaa@gmail.com ',
        'nataliiapanchenko23@gmail.com',
        'anastasiapysneva@gmail.com',

    ];

    protected $site_name;

    protected $meta_name;

    protected $goals;

    const YEAR = 2018;


    public function __construct($site_id = false, $meta = false)
    {

        $query = Link::where('creator','!=','');

        if ($site_id) {
            $query = $query->where('site_id', $site_id);
        }
        if ($meta) {
            $query = $query->where('meta', $meta);
        }

        $this->links = $query->orderBy('created_at')->get();

        $this->site_name = $site_id ? Site::find($site_id) : false;

        $this->meta_name = $meta ? $meta : false;

        $this->goals = $this->getGoals();

        $this->year = date('Y')-2;

    }


    public function getDates()
    {

        $dates = $this->links->map(function ($link) {
            return date('Y-M', strtotime($link->created_at));
        })->unique(function ($link) {
            return $link;
        })->filter(function($date){
            $y = explode('-',$date);
            return $y[0]>=$this->year;
        });

        return $dates;

    }


    public function getSortedUsers()
    {

        $users = $this->links->unique(function ($link) {
            return $link->creator;
        })->map(function ($link) {
            return $link->creator;
        });

        $users = User::whereIn('email', $users)->get();

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


    public function getSortedGoals()
    {

        if ($this->goals) {
            $dates = $this->getDates();

            if ($this->meta_name && array_key_exists($this->meta_name, $this->goals)) {

                $goals = $this->goals[$this->meta_name];

                $results = [];

                foreach ($dates as $date) {
                    $results[$date] = array_key_exists($date, $goals) ? $goals[$date] : false;
                }

                return $results;
            }

        }

        return false;

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


    public function getSiteName()
    {
        return $this->site_name;
    }


    public function getMetaName()
    {
        return $this->meta_name;
    }


    public function getGoals()
    {

        $path = storage_path('file_goals.csv');

        if (file_exists($path)) {

            $results = [];
            $table   = [];
            $f       = fopen($path, 'r');

            while ( ! feof($f)) {
                $table[] = fgetcsv($f);
            }

            $dates = array_shift($table);

            foreach ($table as $key) {
                $k = $key[0];
                if ($k) {
                    $results[$k] = [];
                    foreach ($dates as $num => $date) {
                        $d               = $this->year . '-' . $dates[$num];
                        $results[$k][$d] = $key[$num];
                    }
                    array_shift($results[$k]);
                }

            }

            return $results;

        } else {
            return false;
        }

    }

}