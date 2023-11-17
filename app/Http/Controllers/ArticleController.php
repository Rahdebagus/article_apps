<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $articles = Article::all();
        } else {

            $articles = Article::where('show', 'true')->get();
        }
        $userArticle = Article::Where('user_id', Auth::user()->id)->get();
        return view("home", compact([
            "articles", "userArticle"
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("article.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|string",
            "description" => "required|string",
            "image" => "nullable|image|mimes:jpg,png,jpeg|max:2048"

        ]);
        if ($request->image) {
            $file = $request->file("image");
            $fileName = time() . "." . $file->getClientOriginalExtension();
            $file->storeAs("articles", $fileName, 'public');
        }
        Article::create([
            "title" => $request->title,
            "description" => $request->description,
            "image" => $fileName ?? null,
            "user_id" => Auth::user()->id,
        ]);

        session()->flash('successMessage', 'Article Berhasil di buat');

        return response()->json([
            "message" => "article Create succes"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $article = Article::find($id);
        $user = Auth::user();
        if (!$article) {
            abort(404);
        }

        if (!$article->show) {
            if (!($article->user_id == $user->id || $user->role == 'admin')) {
                abort(404);
            }
        }

        return view("article.show", compact("article"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::find($id);
        if (!($article->user_id != Auth::user()->id || Auth::user()->role != 'admin')) {
            abort(403);
        }
        return view("article.edit", compact("article"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        $request->validate([
            "title" => "required|string",
            "description" => "required|string",
            "image" => "nullable|image|mimes:jpg,png,jpeg|max:2048"
        ]);

        $article = Article::find($id);

        if (!($article->user_id != Auth::user()->id || Auth::user()->role != 'admin')) {
            return response()->json([
                'status' => 'fail',
                'message' => "kamu tidak berhak mengedit ini"
            ], 403);
        }


        $fileName = $article->image;

        if ($request->hasFile("image")) {
            $file = $request->file("image");
            $fileName = time() . "." . $file->getClientOriginalExtension();
            $file->storeAs("articles", $fileName, 'public');
        }

        $article->update([
            "title" => $request->title,
            "description" => $request->description,
            "image" => $fileName,
        ]);

        session()->flash('successMessage', 'Article Berhasil di edit');

        return  response()->json([
            "message" => "has been update",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::find($id);
        if (!($article->user_id != Auth::user()->id || Auth::user()->role != 'admin')) {
            return response()->json([
                'status' => 'fail',
                'messager' => "anda tidak memiliki akses",
            ], 403);
        }

        $article->delete();
        session()->flash('successMessage', 'Article Berhasil di delete ');
        return response()->json([
            "message" => "Article has delete",
        ], 200);
    }



    //   public function showVisibility(string $id)
    // {
    //     $article = Article::find($id);
    //     $visibility = $article->show ? 'private' : 'public';
    //     return view("article.edit", compact("article", "visibility"));
    // }
    public function changeVisibility(Request $request)
    {

        $request->validate([
            "id" => "required|string",

        ]);

        $article = Article::find($request->id);

        if (!($article->user_id != Auth::user()->id || Auth::user()->role != 'admin')) {
            return response()->json([
                'status' => 'fail',
                'message' => "kamu tidak berhak melakukan ini"
            ], 403);
        }
        $article->update([
            'show' => !$article->show
        ]);

        session(['article_show_status' => $article->show]);

        $visibility = $article->show ? 'private' : 'public';

        return response()->json([
            'message' => " $visibility"
        ], 200);
    }
}
