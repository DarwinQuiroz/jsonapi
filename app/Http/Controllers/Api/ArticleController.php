<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
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
