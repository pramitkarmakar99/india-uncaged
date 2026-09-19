<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EnquiryController extends Controller
{
    public function index(): View
    {
        return view('admin.enquiries.index', ['enquiries' => Enquiry::with(['tour','tourDate'])->latest()->get()]);
    }
    public function edit(Enquiry $enquiry): View
    {
        $enquiry->load(['tour','tourDate']);
        return view('admin.enquiries.edit', compact('enquiry'));
    }
    public function update(Request $request, Enquiry $enquiry): RedirectResponse
    {
        $data=$request->validate(['status'=>['required','in:new,contacted,quoted,confirmed,completed,closed'],'admin_notes'=>['nullable','string','max:10000']]);
        $enquiry->update($data);
        return redirect()->route('admin.enquiries.edit',$enquiry)->with('success','Enquiry updated.');
    }
}
