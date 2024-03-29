<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Summary of index
     * @return \App\Http\Resources\ArticleCollection
     */
    public function index(): ArticleCollection
    {
        return ArticleCollection::make(Article::all());
    }


    /**
     * Summary of show
     * @param \App\Models\Article $article
     * @return \App\Http\Resources\ArticleResource
     */
    public function show(Article $article): ArticleResource
    {
        return ArticleResource::make($article);
    }

    public function store(Request $request): ArticleResource
    {
        $request->validate([
            'data.attributes.title' => ['required'],
            'data.attributes.slug' => ['required'],
            'data.attributes.content' => ['required'],
        ]);

        $article = Article::create([
            'title' => $request->input('data.attributes.title'),
            'slug' => $request->input('data.attributes.slug'),
            'content' => $request->input('data.attributes.content'),
        ]);

        return ArticleResource::make($article);
    }
}
