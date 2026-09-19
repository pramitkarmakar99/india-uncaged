<?php

namespace App\Http\Controllers;

use App\Models\JournalArticle;
use Illuminate\View\View;

class JournalController extends Controller
{
    public function index(): View
    {
        return view('journal.index',['articles'=>JournalArticle::where('published',true)->orderByDesc('published_at')->latest()->get()]);
    }

    public function show(JournalArticle $article): View
    {
        abort_unless($article->published,404);
        $related=JournalArticle::where('published',true)->whereKeyNot($article->id)->where('category',$article->category)->latest('published_at')->limit(3)->get();
        return view('journal.show',compact('article','related'));
    }
}
