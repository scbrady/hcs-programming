<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Requests\ArticleFormRequest;
use App;

class ReadingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the reading page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::get(['id', 'title', 'slug']);
        return view('reading.list')->withArticles($articles);
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->first();
        if(!$article)
            App::abort(404);

        return view('reading.show')->withArticle($article);
    }

    public function create(Request $request)
    {
        if($request->user()->permissions == 0)
            return view('reading.create');  

        App::abort(404);
    }

    public function store(ArticleFormRequest $request)
    {
        $active = !$request->has('save');

        Article::create([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'slug' => str_slug($request->get('title')),
            'active' => $active,
        ]);

        return redirect('/reading');
    }

    public function edit(Request $request, $slug)
    {
        $article = Article::where('slug', $slug)->first();
        if($article && $request->user()->permissions == 0)
            return view('reading.edit')->withArticle($article);
        
        App::abort(404);
    }

    public function update(Request $request)
    {
        $article_id = $request->input('article_id');
        $article = Article::find($article_id);

        if($article && $request->user()->permissions == 0) {
            $title = $request->input('title');
            $slug = str_slug($title);

            $duplicate = Article::where('slug', $slug)->first();
            if($duplicate)
            {
                if($duplicate->id != $article_id)
                    return redirect('/reading/edit/'.$article->slug)->withErrors('Title already exists.')->withInput();
                else
                    $article->slug = $slug;
            }
            $article->title = $title;
            $article->body = $request->input('body');
            $article->active = !$request->has('save');
            
            $article->save();
                return redirect('/reading');
        }
        
        App::abort(404);
    }

    public function destroy(Request $request, $id)
    {
        $article = Article::find($id);

        if($article && $request->user()->permissions == 0) {
            $article->delete();
            return redirect('/reading');
        }

        App::abort(404);
    }
}
