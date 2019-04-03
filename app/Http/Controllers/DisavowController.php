<?php

namespace App\Http\Controllers;

use App\Domain;

class DisavowController extends Controller
{

    public function index()
    {


        return view('disavow.index');
    }


    public function update()
    {

        $ahrefs_links = $this->getContentFromRequest('ahrefs_list');
        $google_links = $this->getContentFromRequest('google_list');

        $array = array_merge($ahrefs_links, $google_links);
        $array = array_unique($array);

        $domains = Domain::pluck('domain')->toArray();

        $diff = array_diff($array, $domains);
        asort($diff);

        $url = $this->saveResults($diff);

        return view('disavow.update', compact('url'));

    }


    protected function getContentFromRequest($fileName)
    {

        $upload = storage_path('tmp_file_' . $fileName . 'csv');

        $results = move_uploaded_file($_FILES[$fileName]['tmp_name'], $upload);

        $content = [];

        if ( ! $results) {
            return [];
        }
        $f = fopen($upload, 'r');

        while ( ! feof($f)) {
            if ($c = fgetcsv($f)) {
                $content[] = $c[0];
            }
        }
        unset($content[0]);

        return $content;

    }


    protected function saveResults($results)
    {
        try {
            $date = date('Y_m_d');

            $filename = 'disavow_' . $date . '.csv';

            $path = public_path($filename);

            $f = fopen($path, 'w');
            foreach ($results as $result) {
                fputcsv($f, [$result]);
            }

            $url = url($filename);
        } catch (\Exception $e) {
            $url = false;
        }

        return $url;
    }
}
