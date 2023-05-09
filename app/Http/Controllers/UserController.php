<?php

namespace App\Http\Controllers;

use App\Favourite;
use App\Link;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $links = Link::where('user_id', \Auth::user()->id)->paginate(20);
        if (\Auth::user()->role == 1) {
            $links = Link::paginate(20);
        }
        return view('manage.dashboard', ['links' => $links]);
    }

    public function likes()
    {
        $items = Favourite::where('user_id', \Auth::user()->id)->pluck('link_id');
        $links = Link::whereIn('id', $items)->paginate(20);
        return view('manage.likes', ['links' => $links]);
    }

    public function edit($id)
    {
        if (\Auth::user()->role == 2) {
            $link = Link::where("user_id", \Auth::user()->id)->findOrFail($id);
        } else {
            $link = Link::findOrFail($id);
        }

        return view('manage.edit', ['link' => $link]);
    }

    public function update($id)
    {
        if (\Auth::user()->role == 2) {
            $link = Link::where("user_id", \Auth::user()->id)->findOrFail($id);
        } else {
            $link = Link::find($id);
        }
        $link->name = request()->name;
        $link->link = request()->link;
        $link->save();
        return redirect('/manage');
    }

    public function delete($id)
    {
        if (\Auth::user()->role == 2) {
            $link = Link::where("user_id", \Auth::user()->id)->findOrFail($id);
        } else {
            $link = Link::find($id);
        }
        $link->delete();
        return redirect('/manage');
    }
}
