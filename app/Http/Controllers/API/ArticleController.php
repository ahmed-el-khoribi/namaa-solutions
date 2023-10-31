<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $limit = 15)
    {
        $data = Article::latest()->paginate($limit);

        return $data;
    }
}
