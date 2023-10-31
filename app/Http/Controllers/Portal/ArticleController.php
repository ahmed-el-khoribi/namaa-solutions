<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:articles_view|articles_create|articles_edit|articles_delete', ['only' => ['index','show']]);
        $this->middleware('permission:articles_create', ['only' => ['create','store']]);
        $this->middleware('permission:articles_edit', ['only' => ['edit','update']]);
        $this->middleware('permission:articles_delete', ['only' => ['destroy']]);
        $this->middleware('permission:articles_publish', ['only' => ['publish']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $limit = 5)
    {
        if($request->filled('search')){
            $data = Article::search($request->search)->paginate($limit);
        }else{
            $data = Article::latest()->paginate($limit);
        }

        return view("{$this->adminViewPrefix}.articles.index",compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * $limit);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::pluck('name', 'id');

        return view("{$this->adminViewPrefix}.articles.create")->with('users', $users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'author_id' => 'required|exists:users,id',
            'title' => 'required|min:3|max:191',
            'content' => 'brief',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $article = Article::create($request->all());
        //fileable
        $article->file()->create(['file' => $request->image]);

        return redirect()->route("{$this->adminViewPrefix}.articles.index")
                        ->with('success','Article created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view("{$this->adminViewPrefix}.articles.show", compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $users = User::pluck('name', 'id');

        return view("{$this->adminViewPrefix}.articles.edit")->with('article', $article)->with('users', $users);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $this->validate($request, [
            'author_id' => 'required|exists:users,id',
            'title' => 'required',
            'content' => 'required',
            'brief' => 'required'
        ]);

        $article->update($request->all());

        //fileable
        if($request->image)
        {
            $article->file()->delete();

            $article->file()->create(['file' => $request->image]);
        }

        return redirect()->route("{$this->adminViewPrefix}.articles.index")
                        ->with('success','Article updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route("{$this->adminViewPrefix}.articles.index")
                        ->with('success','Article deleted successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function publish(Request $request, Article $article)
    {
        $article->approver_id = auth()->user()->id;
        $article->status = 'PUBLISHED';
        $article->published_at = now();
        $article->save();

        return redirect()->route("{$this->adminViewPrefix}.articles.index")
                        ->with('success','Article Published successfully');
    }
}
