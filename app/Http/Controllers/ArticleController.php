<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddFavouriteArticleRequest;
use App\Models\Article;
use App\Models\FavouriteArticle;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Requests\StoreArticleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use BaoPham\DynamoDb\Facades\DynamoDb;

class ArticleController extends Controller
{

    const RECORD_PER_PAGE = 11;
    const RECORD_PER_CATEGORY = 20;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $myArticle = new Article();
//        $result = $myArticle->find(['article_id' => 201906142, 'category' => 'Bank Functions']);\
//        $result = $myArticle->where('category', 'Banking Technology')->get();

//        $result = $myArticle->all();

        $limit = self::RECORD_PER_PAGE;
        $page = 1;
        $result = $myArticle->limit($limit)->all();
        $firstkey = [];
        $lastkey = [];
        if ($result->first()) {
            $firstkey = $result->first()->getKeys();
            $lastkey = $result->lastKey();
        }

        $fromcount = $page == 1 ? 1 : ($page - 1) * $limit;
        $tocount = $page * $limit;
        $totalcount = $myArticle->all()->count();


        Log::info('First Key JSON - ' . json_encode($firstkey));
        Log::info('Last Key JSON - ' . json_encode($lastkey));


        return response()->json([
            'status' => true,
            'articles' => $result,
            'firstkey' => $firstkey,
            'lastkey' => $lastkey,
            'limit' => $limit,
            'fromcount' => $fromcount,
            'tocount' => $tocount,
            'totalcount' => $totalcount
        ], 200
        );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        //
        $newArticle = new Article();
        $newArticle->article_id = (int)(date('YmdHis') . rand(10, 99));
        $newArticle->category = $request->category;
        $newArticle->title = $request->title;
        $newArticle->author = $request->author;
        $newArticle->date = $request->date;
        $newArticle->image = $request->image ? $request->image : '';
        $newArticle->brief = $request->brief ? $request->brief : '';
        $newArticle->url = $request->url ? $request->url : '';
        $newArticle->content = $request->contents ? $request->contents : '';
        $newArticle->keywords = $request->keywords ? $request->keywords : '';
        $newArticle->docsbrief = $request->docsbrief ? $request->docsbrief : '';
        $newArticle->docslist = $request->docslist ? $request->docslist : '';
        $newArticle->documents = $request->documents ? $request->documents : '';

        $newArticle->processjson = $request->processjson ? $request->processjson : '';
        $newArticle->drawio = $request->drawio ? $request->drawio : '';
        $newArticle->timeline = $request->timeline ? $request->timeline : '';
        $newArticle->save();


        return response()->json([
            'status' => true,
            'message' => 'Article created successfully.',
            'article_id' => $newArticle->article_id
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
        $myArticle = Article::where('article_id', (int)$id)->first();

        return response()->json([
            'status' => true,
            'articles' => $myArticle
        ], 200
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreArticleRequest $request, $id)
    {

        Log::info('ArticleController@update - ' . $id);

        //
        $myArticle = Article::where('article_id', (int)$id)->first();

        if ($myArticle->title) {

            //Prepare the list of attributes to be updated
            $myArticle->category = $request->category;
            $myArticle->title = $request->title;
            $myArticle->author = $request->author;
            $myArticle->date = $request->date;
            $myArticle->image = $request->image ? $request->image : '';
            $myArticle->brief = $request->brief ? $request->brief : '';
            $myArticle->url = $request->url ? $request->url : '';
            $myArticle->content = $request->contents ? $request->contents : '';
            $myArticle->keywords = $request->keywords ? $request->keywords : '';
            $myArticle->docsbrief = $request->docsbrief ? $request->docsbrief : '';
            $myArticle->docslist = $request->docslist ? $request->docslist : '';
            $myArticle->documents = $request->documents ? $request->documents : '';

            $myArticle->processjson = $request->processjson ? $request->processjson : '';
            $myArticle->drawio = $request->drawio ? $request->drawio : '';
            $myArticle->timeline = $request->timeline ? $request->timeline : '';

            if ($myArticle->save()) {

                $updatedArticle = Article::where('article_id', (int)$request->id)->first();

                return response()->json([
                    'status' => true,
                    'articles' => $updatedArticle
                ], 200
                );
            }

        }


        //Default return
        return response()->json([
            'status' => false
        ], 200
        );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getallarticles(Request $request)
    {

        Log::info('ArticleController@getallarticles');

        $myArticle = new Article();
        $totalcount = $myArticle->all()->count();
        $result = $myArticle->all();

        $firstkey = [];
        $lastkey = [];
        if ($result->first()) {
            $firstkey = $result->first()->getKeys();
            $lastkey = $result->lastKey();
        }

        Log::info('First Key  - ' . json_encode($firstkey));
        Log::info('Last Key  - ' . json_encode($lastkey));


        return response()->json([
            'status' => true,
            'articles' => $result,
            'firstkey' => $firstkey,
            'lastkey' => $lastkey,
            'totalcount' => $totalcount
        ], 200
        );

    }

    public function getarticles(Request $request)
    {

        $request->validate([
            'page' => 'required',
        ]);

        $myArticle = new Article();
        $limit = self::RECORD_PER_PAGE;
        $fromcount = $request->page == 1 ? 1 : ($request->page - 1) * $limit;
        $tocount = $request->page * $limit;
        $totalcount = $myArticle->all()->count();

        Log::info('');
        Log::info('>>> Action - ' . json_encode($request->action));
        Log::info('Key Used - ' . json_encode($request->lastkey));

        if ($request->page == 1)
            $result = $myArticle->limit($limit)->all();
        else
            $result = $myArticle->afterKey($request->keyafter)->limit($limit)->all();

        $firstkey = $result->first()->getKeys();
        $lastkey = $result->lastKey();

        Log::info('New First Key  - ' . json_encode($firstkey));
        Log::info('New Last Key  - ' . json_encode($lastkey));


        return response()->json([
            'status' => true,
            'articles' => $result,
            'firstkey' => $firstkey,
            'lastkey' => $lastkey,
            'limit' => $limit,
            'fromcount' => $fromcount,
            'tocount' => $tocount,
            'totalcount' => $totalcount
        ], 200
        );

    }

    public function getArtcilesByCategory($category)
    {
        Log::info('getArtcilesByCategory  - ' . $category);

        //
        if ($category === 'Processes')
            $myArticle = Article::where('category', $category)->all();
        else
            $myArticle = Article::where('category', $category)->take(self::RECORD_PER_CATEGORY)->get();
        $totalcount = count($myArticle);

        return response()->json([
            'status' => true,
            'articles' => $myArticle,
            'totalcount' => $totalcount
        ], 200
        );
    }

    public function search(Request $request)
    {

        Log::info('ArticleController@search  - ' . $request->q);

        $request->validate([
            'q' => 'required',
        ]);

        $myArticles = Article::where('title', 'contains', $request->q)->get();;
        $totalcount = count($myArticles);

        Log::info('ArticleController@search total found - ' . $totalcount);

        return response()->json([
            'status' => true,
            'articles' => $myArticles,
            'totalcount' => $totalcount
        ], 200
        );
    }

    public function setup($bucketno)
    {

        Log::info('ArticleController@uploadArticles');


        //Setup Articles
        return $this->setupArticles($bucketno);
    }

    public function setupArticles($bucketno)
    {

        //Read all the article files
        $files = Storage::files('\public\upload\articles\\'.$bucketno);

        $msg = '';
        foreach ($files as $file) {

            Log::info('File Name  - ' . $file);

            //Get the article by ID
            $article = Storage::get($file);

            if ($article) {

                //Decode the json string into array
                $article_array = json_decode($article, true);

                Log::info('Article ID  - ' . $article_array['title']);

                //
                $newArticle = new Article();
                $newArticle->article_id = (int)(date('YmdHis') . rand(10, 99));
                $newArticle->category = $article_array['category'];
                $newArticle->title = $article_array['title'];
                $newArticle->author = $article_array['author'];
                $newArticle->date = $article_array['date'];
                $newArticle->image = $article_array['image'];
                $newArticle->brief = $article_array['brief'];
                $newArticle->url = $article_array['url'];
                $newArticle->content = isset($article_array['content']) ? $article_array['content'] : '';
                $newArticle->docsbrief = isset($article_array['docsbrief']) ? $article_array['docsbrief'] : '';
                $newArticle->docslist = isset($article_array['docslist']) ? $article_array['docslist'] : '';
                $newArticle->documents = isset($article_array['documents']) ? $article_array['documents'] : '';
                $newArticle->keywords = isset($article_array['keywords']) ? $article_array['keywords'] : '';
                $newArticle->processjson = isset($article_array['processjson']) ? $article_array['processjson'] : '';
                $newArticle->drawio = isset($article_array['drawio']) ? $article_array['drawio'] : '';
                $newArticle->timeline = isset($article_array['timeline']) ? $article_array['timeline'] : '';

                if ($newArticle->save())
                    $msg .= '<br/>Uploaded Article ID  - ' . $article_array['title'];
            }

        }
        return $msg;
    }

    public function setupPages()
    {

        //Read all the article files
        $files = Storage::files('\public\upload\pages');

        $msg = '';
        foreach ($files as $file) {

            Log::info('File Name  - ' . $file);

            //Get the article by ID
            $page = Storage::get($file);

            if ($page) {

                //Decode the json string into array
                $page_array = json_decode($page, true);

                Log::info('Page ID  - ' . $page_array['pagename']);

                //
                $newPage = new Page();
                $newPage->pagename = isset($page_array['pagename']) ? $page_array['pagename'] : '';
                $newPage->title = isset($page_array['title']) ? $page_array['title'] : '';
                $newPage->subtitle = isset($page_array['subtitle']) ? $page_array['subtitle'] : '';
                $newPage->textlines = isset($page_array['textlines']) ? $page_array['textlines'] : '';
                $newPage->textsections = isset($page_array['textsections']) ? $page_array['textsections'] : '';
                $newPage->fieldlabels = isset($page_array['fieldlabels']) ? $page_array['fieldlabels'] : '';
                $newPage->photos = isset($page_array['photos']) ? $page_array['photos'] : '';
                $newPage->itemList1 = isset($page_array['itemList1']) ? $page_array['itemList1'] : '';
                $newPage->itemList2 = isset($page_array['itemList2']) ? $page_array['itemList2'] : '';
                $newPage->itemList3 = isset($page_array['itemList3']) ? $page_array['itemList3'] : '';

                if ($newPage->save())
                    $msg .= '<br/>Uploaded Page ID  - ' . $page_array['pagename'];
            }

        }
        return $msg;
    }

    public function addFavourite(AddFavouriteArticleRequest $request)
    {

        Log::info('ArticleController@addFavourite');
        Log::info('UserID  - ' . $request->user_id);
        Log::info('ArticleID  - ' . $request->article_id);

        $myFavArticle = new FavouriteArticle();
        $myFavArticle->user_id = $request->user_id;
        $myFavArticle->article_id = $request->article_id;
        $myFavArticle->category = $request->category;
        $myFavArticle->save();


        return response()->json([
            'status' => true,
            'message' => "Article added as your favourite."
        ], 200
        );

    }

    public function deleteFavourite(AddFavouriteArticleRequest $request)
    {

        Log::info('ArticleController@deleteFavourite');
        Log::info('UserID  - ' . $request->user_id);
        Log::info('ArticleID  - ' . $request->article_id);

        $myFavArticles = FavouriteArticle::where('user_id', $request->user_id)
            ->where('article_id', $request->article_id)
            ->get();

        //Delete the fav articles one by one
        foreach ($myFavArticles as $myFavArticle)
            $myFavArticle->delete();

        return response()->json([
            'status' => true,
            'message' => "Article removed from your favourites."
        ], 200
        );

    }

    public function getUserFavourites(Request $request)
    {

        Log::info('ArticleController@getUserFavourites');
        $articleObj = new Article();
        $myFavArticles = FavouriteArticle::where('user_id', $request->user_id)->get();

        $myFavArticleIDs = [];
        foreach ($myFavArticles as $favArticle) {
            $searchArray['article_id'] = (int)$favArticle->article_id;
            $searchArray['category'] = $favArticle->category;
            $myFavArticleIDs[] = $searchArray;
        }

        Log::info('Article IDs  - ' . json_encode($myFavArticleIDs));
        //find all the articles at one shoot
        $articles = $articleObj->findMany($myFavArticleIDs);
//            $articles = $articleObj->findMany([['article_id' => 2022120209054219, 'category' => 'Banking Technology'],['article_id' => 2022120209054437, 'category' => 'Banking Technology']]);


        return response()->json([
            'status' => true,
            'articles' => $articles
        ], 200
        );
    }

    public function getArticleWithFav(Request $request)
    {
        Log::info('ArticleController@getArticleWithFav');

        //User ID to take in part of request
        $userID = $request->user_id;
        $articleID = $request->article_id;
        Log::info('User ID - ' . $userID);
        Log::info('Article ID - ' . $articleID);

        //
        $myArticles = Article::where('article_id', (int)$articleID)->get();
        $myArticle = $myArticles[0]; //get the first one

        //Only do this query when user has logged in
        $isArticleFav = false;
//        if($userID > 0) {
//            $myFavArticles = FavouriteArticle::where('user_id', $userID)
//                ->get();
//
//            foreach ($myFavArticles as $favArticle) {
//                if(isset($favArticle->article_id)) {//make sure article is valid
//                    if($favArticle->article_id == $myArticle->article_id) {
//                        $isArticleFav = true;
//                        break;
//                    }
//                } else {//only one record is expected so should stop the loop
//                    break;
//                }
//            }
//        }

        return response()->json([
            'status' => true,
            'articles' => $myArticle,
            'isfav' => $isArticleFav
        ], 200
        );
    }
}
