<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role_or_permission:manage_own_articles|add_comments|Super Admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $limit = 5)
    {
        $data = Article::ownedBy(Auth::id())->paginate($limit);

        return view("{$this->dashboardViewPrefix}.home", compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * $limit);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("{$this->dashboardViewPrefix}.articles.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:191',
            'content' => 'brief',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->all();

        $data['author_id'] = Auth::id();

        $article = Article::create($data);

        //fileable
        $article->file()->create(['file' => $request->image]);

        return redirect()->route("$this->dashboardViewPrefix.home")
                        ->with('success','Article created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $article = Article::whereAuthorId(Auth::id())->findOrFail($id);

        return view("{$this->dashboardViewPrefix}.articles.show", compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $article = Article::whereAuthorId(Auth::id())->findOrFail($id);

        return view("{$this->dashboardViewPrefix}.articles.edit")->with('article', $article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'brief' => 'required'
        ]);

        $article = Article::whereAuthorId(Auth::id())->findOrFail($id);

        $data = $request->only('_token', 'title', 'brief', 'content');

        $article->update($data);

        //fileable
        if($request->image)
        {
            $article->file()->delete();

            $article->file()->create(['file' => $request->image]);
        }

        return redirect()->route("{$this->dashboardViewPrefix}.articles.index")
                        ->with('success','Article updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route("{$this->dashboardViewPrefix}.articles.index")
                        ->with('success','Article deleted successfully');
    }

}
