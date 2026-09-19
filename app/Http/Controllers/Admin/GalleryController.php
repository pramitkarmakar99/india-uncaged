<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\GalleryImage;
use App\Models\Tour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        return view('admin.gallery.index', [
            'images' => GalleryImage::with(['destination','tour'])->latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery.form', [
            'image' => new GalleryImage(['category'=>'fauna']),
            'destinations' => Destination::whereNull('archived_at')->orderBy('name')->get(),
            'tours' => Tour::whereNull('archived_at')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $image=new GalleryImage();
        $this->save($request,$image);
        return redirect()->route('admin.gallery.edit',$image)->with('success','Gallery image added.');
    }

    public function edit(GalleryImage $gallery): View
    {
        return view('admin.gallery.form', [
            'image'=>$gallery,
            'destinations'=>Destination::whereNull('archived_at')->orderBy('name')->get(),
            'tours'=>Tour::whereNull('archived_at')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, GalleryImage $gallery): RedirectResponse
    {
        $this->save($request,$gallery);
        return redirect()->route('admin.gallery.edit',$gallery)->with('success','Gallery image updated.');
    }

    public function destroy(GalleryImage $gallery): RedirectResponse
    {
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success','Gallery image deleted.');
    }

    private function save(Request $request, GalleryImage $image): void
    {
        $data=$request->validate([
            'image_path'=>['required','string','max:2048'],
            'category'=>['required','in:tour_experiences,bts,fauna,herping,birds,landscapes'],
            'destination_id'=>['nullable','exists:destinations,id'],
            'tour_id'=>['nullable','exists:tours,id'],
            'caption'=>['nullable','string','max:5000'],
            'location'=>['nullable','string','max:255'],
            'taken_on'=>['nullable','date'],
            'photographer'=>['nullable','string','max:255'],
            'width'=>['nullable','integer','min:1'],
            'height'=>['nullable','integer','min:1'],
            'featured'=>['nullable','boolean'],
            'published'=>['nullable','boolean'],
        ]);
        $data['featured']=$request->boolean('featured');
        $data['published']=$request->boolean('published');
        $image->fill($data)->save();
    }
}
