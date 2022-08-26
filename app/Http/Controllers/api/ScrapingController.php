<?php

namespace App\Http\Controllers\api;

use Goutte\Client;
use App\Http\Controllers\ApiResponseController;
use App\Http\Controllers\Controller\api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScrapingController extends ApiResponseController
{
    /**
     * Activate the specified resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $client = new Client();

        $crawler = $client->request('GET', 'https://www.cnnchile.com/opinion/');

        $result = $crawler->filter('.main-content__left > inner-list > inner-list__item inner-item > inner-item__content > inner-item__title')->each(function ($node) {
            return $node->text();
        });

        for($i = 0; $i < count($result); $i++) {
            $text = str_replace("$", "", $result[$i]);
            $text = str_replace(" ", "", $text);
            $text = str_replace("%", "", $text);
            $text = str_replace("R.I. ", "", $text);

            $result[$i] = $text;
        }
    }
}