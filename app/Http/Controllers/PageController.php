<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RoachPHP\Roach;
use App\Spiders\AYABankRatesSpider;
use App\Spiders\ABankRatesSpider;
use App\Spiders\CBBankRatesSpider;
use App\Spiders\YomaBankRatesSpider;

class PageController extends Controller
{

    //Welcome
    public function welcome()
    {

        //get all the articles
        Log::info('PageController@Welcome');

        //Get Pixbayphotos
        $pixbayphotos = $this->getPixbayPhotoInternal('Banking Technology');

//        Log::info('Get Photos - '.json_encode($pixbayphotosJson));
//        return json_encode($pixbayphotosJson);

        //Store into the session
        session(['pixbayphotos' => $pixbayphotos]);

        //Read session
//        $pixbayphotosJson = session('pixbayphotos');
//        return 'Session value read - '.json_encode($pixbayphotosJson);


        // Synchronously
        if (session('pixbayphotos', 'default'))
            Inertia::share('pixbayphotos', $pixbayphotos);

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    //
    public function showarticles($articleid)
    {

        //get all the articles
//        Log::info('Get Article ID - ' . $articleid);

        return Inertia::render('ArticleDetails', [
            'articleid' => $articleid,
        ]);
    }

    public function showarticlesbycat($category)
    {

        //get all the articles
        Log::info('PageController@showarticlesbycat- ' . $category);

        return Inertia::render('Articles', [

            'category_id' => $category,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        Log::info('Hit to PageController@store');

        //
        $newPage = new Page();
        $newPage->pagename = $request->pagename;
        $newPage->title = $request->title;
        $newPage->subtitle = $request->subtitle;
        $newPage->textlines = $request->textlines;
        $newPage->textsections = $request->textsections;
        $newPage->fieldlabels = $request->fieldlabels;
        $newPage->photos = $request->photos;
        $newPage->itemList1 = $request->itemList1;
        $newPage->itemList2 = $request->itemList2;
        $newPage->itemList3 = $request->itemList3;
        $newPage->save();

        Log::info('New Page Created');

        return response()->json([
            'status' => true,
            'message' => 'Page created successfully.',
            'page' => $newPage
        ], 200
        );

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        //
        Log::info('Hit to PageController@show - ' . $id);
        //
        $page = Page::where('pagename', $id)->first();

        return response()->json([
            'status' => true,
            'pagetext' => $page
        ], 200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        Log::info('Hit to PageController@update');

        //
        $page = Page::where('pagename', $id)->first();
        if ($request->title) $page->title = $request->title;
        if ($request->subtitle) $page->subtitle = $request->subtitle;
        if ($request->textlines) $page->textlines = $request->textlines;
        if ($request->textsections) $page->textsections = $request->textsections;
        if ($request->fieldlabels) $page->fieldlabels = $request->fieldlabels;
        if ($request->photos) $page->photos = $request->photos;
        if ($request->itemList1) $page->itemList1 = $request->itemList1;
        if ($request->itemList2) $page->itemList2 = $request->itemList2;
        if ($request->itemList3) $page->itemList3 = $request->itemList3;

        if ($page->save()) {

            $updatedPage = Page::where('pagename', $id)->first();

            return response()->json([
                'status' => true,
                'message' => 'Page updated successfully.',
            ], 200
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Page update failed.',
            'page' => $page
        ], 200
        );
    }

    public function getPixbayPhoto($keyword)
    {

        //get all the articles
        Log::info('Hit to PageController@getPixbayPhoto');
        Log::info('Keyword - ' . $keyword);

        $response = Http::get('https://pixabay.com/api', [
            'key' => '30149580-a520cf939621286836dfa2709',
            'q' => $keyword,
        ]);

        if ($response->successful()) {

            //Read the photos from the responsev
            return response()->json([
                'status' => true,
                'keyword' => $keyword,
                'photos' => $response->json($key = 'hits')
            ], 200
            );

        }

    }

    public function getPixbayPhotoInternal($keyword)
    {

        //get all the articles
        Log::info('Hit to PageController@getPixbayPhoto');
        Log::info('Keyword - ' . $keyword);

        $response = Http::get('https://pixabay.com/api', [
            'key' => '30149580-a520cf939621286836dfa2709',
            'q' => $keyword,
            'per_page' => 200
        ]);

        if ($response->successful()) {

            return $response->json($key = 'hits');

        }

    }

    public function updatesession(Request $request)
    {

        Log::info('Hit to PageController@updatesession');
        Log::info('key - ' . $request->key);
        Log::info('value - ' . $request->value);

        $request->validate([
            'key' => ['required'],
            'value' => ['required']
        ]);

        session([$request->key => $request->value]);
        return response()->json([
            'message' => 'The session is updated.'
        ]);

    }

    public function updaterates()
    {

        Log::error('Hit to PageController@updaterates');

        //Run the bank rates update
        Roach::startSpider(AYABankRatesSpider::class);
        Roach::startSpider(ABankRatesSpider::class);
        Roach::startSpider(CBBankRatesSpider::class);
        Roach::startSpider(YomaBankRatesSpider::class);

        return "Rates update done at - " . date("Y-m-d h:i:sa");
    }

    public function updateExchangeRates()
    {

        //Make HTTP Call and get the rates
        Log::error('Hit to Page Model@update_exchange_rates');

        $response = Http::get('https://api.apilayer.com/exchangerates_data/latest', [
            'apikey' => 'GFoMvWCuGc5LLZwq8XtqIouR9aJkTbSB',
            'base' => 'MMK',
            'symbols' => 'USD,SGD,THB,EUR'
        ]);

        if ($response->successful()) {


            $responseArray = $response->json();
            if (count($responseArray['rates']) > 0) {

//                return json_encode($response->json());
                $exchangeRates = $responseArray['rates'];

                //Update the page
                $page = Page::where('pagename', 'rates')->first();

                $ratearray = [];
                $i = 0;
                foreach ($page->itemList2 as $rateObj) {

                    if (array_key_exists($rateObj['currency'], $exchangeRates)) {

                        //AYA Bank
                        $attributes = [
                            'currency' => $rateObj['currency'],
                            'subicon' => $rateObj['subicon'],
                            'smallValue' => $rateObj['smallValue'],
                            'subtext' => $responseArray['date'],
                            'color' => $rateObj['color'],
                            'icon' => $rateObj['icon'],
                            'title' => $rateObj['title'],
                            'subiconcolor' => $rateObj['subiconcolor'],
                            'value' => round(1/$exchangeRates[$rateObj['currency']])
                        ];

                        Log::error('Attributes - '. json_encode($attributes));

                        //Update the attributes
                        $ratearray[$i] = $attributes;

                    } else {

                        //No changes
                        $ratearray[$i] = $rateObj;
                    }
                    $i++;


                }

                $page->itemList2 = $ratearray;
                $page->save();
            }

        }

        return "Exchange Rates update done at - " . date("Y-m-d h:i:sa");

    }
}
