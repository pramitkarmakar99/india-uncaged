<?php
namespace App\\Http\\Controllers\\Admin;
use App\\Http\\Controllers\\Controller;
use App\\Models\\User;
use Illuminate\\Http\\RedirectResponse;
use Illuminate\\Http\\Request;
use Illuminate\\Support\\Facades\\Hash;
use Illuminate\\View\\View;
class UserController extends Controller {
 public function index(): View { abort_unless(auth()->user()->isOwner(),403); return view('admin.users.index',['users'=>User::orderBy('role')->orderBy('name')->get()]); }
 public function store(Request $request): RedirectResponse {
  abort_unless(auth()->user()->isOwner(),403);
  $data=$request->validate(['name'=>['required','string','max:255'],'email'=>['required','email','max:255','unique:users,email'],'password'=>['required','string','min:12','confirmed']]);
  User::create(['name'=>$data['name'],'email'=>$data['email'],'password'=>$data['password'],'role'=>'admin']);
  return back()->with('success','Admin user created.');
 }
 public function update(Request $request, User $user): RedirectResponse {
  abort_unless(auth()->user()->isOwner(),403);
  if($user->isOwner()) abort(403,'The owner account cannot be changed here.');
  $data=$request->validate(['name'=>['required','string','max:255'],'email'=>['required','email','max:255','unique:users,email,'.$user->id],'password'=>['nullable','string','min:12','confirmed'],'role'=>['required','in:admin']]);
  $user->name=$data['name']; $user->email=$data['email']; $user->role='admin'; if(!empty($data['password'])) $user->password=$data['password']; $user->save();
  return back()->with('success','Admin user updated.');
 }
 public function destroy(User $user): RedirectResponse {
  abort_unless(auth()->user()->isOwner(),403);
  if($user->isOwner() || $user->id===auth()->id()) abort(403,'The owner account cannot be removed.');
  $user->delete();
  return back()->with('success','Admin access revoked.');
 }
}