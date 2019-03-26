<?php

namespace App\Http\Controllers;


use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //

    /**
     *
    //* @return Response
     */
    public function index()
    {
        return view('main');
    }

    /**
     *
     * @param  Request  $request
     */
    public function check(Request $request)
    {
        $url = $request->input('url');

        $client = new Client([
            'http_errors' => false,
            'allow_redirects' => false,
            'timeout'  => 4.0,
        ]);

        try {
            $response = $client->request('GET', $url);

        } catch (\GuzzleHttp\Exception\ConnectException $ex) {
            return response()->json([
                'status' => $ex->getMessage(),
                'title' => '',
                'url' => $url,
            ]);
        } catch (\GuzzleHttp\Exception\RequestException $ex) {
            return response()->json([
                'status' => $ex->getMessage(),
                'title' => '',
                'url' => $url,
            ]);
        }

        $status = $response->getStatusCode();

        $contents = (string)$response->getBody();

        $crawler = new Crawler($contents);

        $title = $crawler->filterXPath('//title')->text();

        return response()->json([
            'status' => $status,
            'title' => $title,
            'url' => $url,
        ]);
    }
}
