<?php

namespace App\Http\Controllers;

// use App\Models\Article;
use App\Models\ArticleComments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function create(Request $request, string $id)
    {
        $request->validate([
            "comment" => "required|string",

        ]);

        ArticleComments::create([
            "comment" => $request->comment,
            "user_id" => Auth::user()->id,
            "article_id" => $id,

        ]);
        return response()->json([
            'status' => 'success',
            'mesaage' => 'berhasil komentar',
        ]);
    }
}
