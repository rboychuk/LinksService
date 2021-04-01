<?php

namespace App\Http\Controllers;

use App\Disavow;
use App\GrayDomain;
use App\Domain;
use App\Site;
use Illuminate\Http\Request;

class DisavowController extends Controller
{

    public function index()
    {

        $sites = Site::all();

        return view('disavow.index', compact('sites'));
    }


    public function update(Request $request)
    {
        $site_id = $request->get('site_id');

        $ahrefs_links  = $this->getContentFromRequest('ahrefs_list');
        $google_links  = $this->getContentFromRequest('google_list');

        $disavow_links = $this->checkDisavowLinks($this->getContentFromRequest('disavow_list'));


        $array = array_merge($ahrefs_links, $google_links);
        $count_merged = count($array);
        $array = array_unique($array);
        $count_not_unique = $count_merged-count($array);

        $domains         = Domain::where('site_id', $site_id)->pluck('domain')->toArray();
        $disavow_domains = GrayDomain::pluck('domain')->toArray();

        $disavow_ddd = Disavow::pluck('domain')->toArray();

        $this->saveResults($disavow_ddd, $site_id,'disavow_from_db');

        $diff = array_diff($array, $disavow_links, $domains, $disavow_domains);

        $diff = array_unique($diff);

        asort($diff);

        $url = $this->saveResults($diff, $site_id);

        return view('disavow.update',
            compact('url', 'ahrefs_links', 'google_links', 'disavow_links', 'domains', 'disavow_domains', 'diff','count_not_unique'));

    }


    protected function getContentFromRequest($fileName)
    {

        $upload = storage_path('tmp_file_' . $fileName . '.csv');

        if (file_exists($upload)) {
            unlink($upload);
        }

        $results = move_uploaded_file($_FILES[$fileName]['tmp_name'], $upload);

        $content = [];

        if ( ! $results) {
            return [];
        }
        $f = fopen($upload, 'r');

        $key = 0;

        while ( ! feof($f)) {
            if ($c = fgetcsv($f)) {
                if (isset($c[$key])) {
                    $string    = $c[$key];
                    $string    = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $string);
                    $content[] = trim(str_replace('"', '', $string), " ");
                }
            }
        }

        fclose($f);
        unset($content[0]);

        return $content;

    }


    protected function saveResults($results, $site_id=null,$site_name=null)
    {
        try {
            $site_name = $site_id?str_replace('.', '_', Site::find($site_id)->name):$site_name;

            $date = date('Y_m_d');

            $filename = $site_name . '_disavow_' . $date . '.csv';

            $path = public_path($filename);

            $f = fopen($path, 'w');
            foreach ($results as $result) {
                fputcsv($f, [$result]);
            }
            fclose($f);

            $url = url($filename);
        } catch (\Exception $e) {
            $url = false;
        }

        return $url;
    }


    public function checkDisavowLinks($list)
    {

        $pattern = '/^(https?:\/\/)?([\da-z\.-]+\.[a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        $new_list = [];

        foreach ($list as $url) {
            $url = str_replace('domain:', '', $url);
            $url = str_replace('www.', '', $url);
            preg_match($pattern, $url, $matches);
            if (count($matches) > 2) {
                $new_list[] = $matches[2];
            }
        }

        return $new_list;

    }

    public function extractDomains(Request $request){

        $results = [];

        $file = $request->file('extract_domain')->openFile('r');

        while ( ! $file->eof()) {
            $results[] = $file->fgetcsv()[0];
        }

        $results = $this->checkDisavowLinks($results);

        asort($results);

        $url =$this->saveResults($results,null,"extract");

        return redirect(secure_url('disavow'))->with('extractDomains', $url);

    }

    public function updateGrayDomains(Request $request)
    {

        $results = [];

        $file = $request->file('gray_domain')->openFile('r');

        while ( ! $file->eof()) {
            $results[] = $file->fgetcsv()[0];
        }

        $results = array_unique($results);

        GrayDomain::unguard();

        $counter = 0;

        foreach ($results as $domain) {
            if ($domain) {
                $res     = GrayDomain::updateOrCreate(
                    ['domain' => $domain]
                );
                $counter += $res->wasRecentlyCreated;
            }
        }

        return redirect(secure_url('disavow'))->with('uploaded_domains', $counter);

    }

}
