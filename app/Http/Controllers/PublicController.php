<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class publicController extends Controller
{
    /**
     * Show the application homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $limit = 10)
    {
        $data = Article::latest()->published()->paginate($limit);

        return view("public.articles.index", compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * $limit);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $article = Article::with('comments')->published()->findOrFail($id);

        return view("public.articles.show", compact('article'));
    }

}
