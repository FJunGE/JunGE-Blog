<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            'except' => ['show'],
        ]);
    }

    public function show(Status $status)
    {
        $user = $status->user()->first();
        return view('statuses.show', compact('status','user'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required|max:255',
            'text_content' => 'required|max:255',
        ]);

        Status::create([
            'title'=>$request->title,
            'text_content'=>$request->text_content,
            'user_id'=>Auth::user()->id,
        ]);
        session()->flash('success','发布成功');
        return redirect()->route('users.show',Auth::user()->id);
    }

    public function edit(Status $status){
        $this->authorize('update',$status);
        return view('static_page.home',compact('status'));
    }

    public function update(Request $request, Status $status){
        $this->validate($request,[
           'title' => 'required|max:255',
            'text_content'  => 'required|max:255'
        ]);

        $status->update([
            'title' => $request->title,
            'text_content' => $request->text_content
        ]);
        session()->flash('success','修改成功');
        return redirect()->route('users.show',Auth::user()->id);
    }

    public function destroy(Status $status){
        $this->authorize('destroy',$status);
        $status->delete();
        session()->flash('success','删除成功');
        return redirect()->route('users.show',Auth::user()->id);
    }

}
