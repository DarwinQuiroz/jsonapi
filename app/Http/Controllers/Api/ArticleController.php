<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;

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
}
