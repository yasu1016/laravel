<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;

class ProfileController extends Controller
{
    //
    public function add()
    {
        return view('admin.profile.create');
    }

    public function create(Request $request)
    {
        $this->validate($request, Profile::$rules);
        $profile = new Profile;
        $form = $request->all();

        unset($form['_token']);
        unset($form['image']);
        
        $profile->fill($form);
        $profile->save();
        
        return redirect('admin/profile/create');
    }
    
    public function edit(Request $request)
    {
        $profile = Profile::find($request->id);
        if (empty($profile)) {
            abort(404);
        }
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }

    public function update()
    {
        $this->validate($request, Profile::$rules);
        $profile = Profile::find($request->id);
        $profile_form = $request->all();
        
        if (isset($profile_form['image'])) {
            $path = $request->file('image')->store('public/image');
            $profile->image_path = basename($path);
            unset($profile_form['image']);
        } elseif (isset($request->remove)) {
            $profile->image_path = null;
            unset($profile_form['remove']);
        }
        
        unset($profile_form['_token']);
        
        $profile->fill($profile_form)->save();
        
        return redirect('admin/profile/edit');
    }

    public function index(Request $request)
    {
        /*$cond_title = $request->cond_title;
        if ($cond_title != '') {
            $posts = News::where('title', $cond_title)->get();
        } else {
            $posts = News::all();
        }*/
        
        return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }
}
