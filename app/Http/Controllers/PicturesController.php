<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class PicturesController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Pictures');
    }

    public function getImages(Request $request)
    {
        $width = $request->get('width');
        $height = $request->get('height');
        $url = "https://picsum.photos/$width/$height/";

        $picture = null;
        $response = Http::acceptJson()->get($url);

        if($response->successful()) {
            $picture = [
              'url' => $url,
              'width' => $width,
              'height' => $height,
            ];
        }

        return response()->json([
            'picture' => $picture,
        ]);

        //return response()->streamDownload(function () {
        //    echo GitHub::api('repo')
        //        ->contents()
        //        ->readme('laravel', 'laravel')['contents'];
        //}, 'laravel-readme.md');
    }
}
