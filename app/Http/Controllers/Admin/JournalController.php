<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JournalArticle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class JournalController extends Controller
{
    public function index(): View { return view('admin.journal.index',['articles'=>JournalArticle::latest()->get()]); }
    public function create(): View { return view('admin.journal.form',['article'=>new JournalArticle()]); }
    public function store(Request $request): RedirectResponse { $article=new JournalArticle(); $this->save($request,$article); return redirect()->route('admin.journal.edit',$article)->with('success','Article created.'); }
    public function edit(JournalArticle $journal): View { return view('admin.journal.form',['article'=>$journal]); }
    public function update(Request $request, JournalArticle $journal): RedirectResponse { $this->save($request,$journal); return redirect()->route('admin.journal.edit',$journal)->with('success','Article updated.'); }
    public function destroy(JournalArticle $journal): RedirectResponse { $journal->delete(); return redirect()->route('admin.journal.index')->with('success','Article deleted.'); }

    private function save(Request $request, JournalArticle $article): void
    {
        $data=$request->validate([
            'title'=>['required','string','max:255'],'slug'=>['nullable','string','max:255'],'category'=>['nullable','string','max:100'],
            'excerpt'=>['nullable','string','max:2000'],'cover_image'=>['nullable','string','max:2048','regex:/^(https?:\/\/|\/storage\/)[^\s]+$/i'],'author'=>['nullable','string','max:255'],
            'seo_image'=>['nullable','string','max:2048','regex:/^(https?:\/\/|\/storage\/)[^\s]+$/i'],
            'content'=>['nullable','string'],'seo_title'=>['nullable','string','max:255'],'seo_description'=>['nullable','string'],
            'seo_image'=>['nullable','string','max:2048'],'published'=>['nullable','boolean'],
        ]);
        $slug=Str::slug($data['slug'] ?: $data['title']);
        if(JournalArticle::where('slug',$slug)->whereKeyNot($article->id ?? 0)->exists()) $slug.='-'.Str::lower(Str::random(5));
        $article->fill($data);
        $article->slug=$slug;
        $article->published=$request->boolean('published');
        $article->published_at=$article->published ? ($article->published_at ?: now()) : null;
        $article->content=$data['content'] ? [['type'=>'html','value'=>$data['content']]] : [];
        $article->save();
    }
}
