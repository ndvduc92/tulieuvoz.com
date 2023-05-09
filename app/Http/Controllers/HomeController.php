<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Favourite;
use App\Link;
use App\User;
use Illuminate\Http\Request;
use Validator;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function postLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required',
            'link' => 'bail|required|url',
        ]);

        if ($validator->fails()) {
            return back();
        }
        $exist = Link::where('link', $request->link)->first();
        if ($exist) {
            return redirect('/link/' . $exist->id)->with('success', 'Link đã tồn tại !');
        }
        $link = new Link;
        $link->name = $request->name;
        $link->link = $request->link;
        $link->description = $request->description;
        if (\Auth::check()) {
            $link->user_id = \Auth::user()->id;
        }
        $link->save();
        return redirect('/link/' . $link->id);
    }

    public function postComment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            return back();
        }

        $comment = new Comment;
        $comment->link_id = $id;
        $comment->name = $request->name;
        $comment->comment = $request->comment;
        $comment->save();
        return redirect('/link/' . $id)->with('success', 'Đã bình luận !');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function getLinks()
    {
        $links = Link::with('user')->orderBy('created_at', 'desc')->paginate(20);
        $sort = request()->sort;
        if ($sort) {
            $links = $sort == 'view' ? Link::orderBy('viewed', 'desc')->paginate(20) : Link::orderBy('like', 'desc')->paginate(20);
        }
        return view('links', ['links' => $links]);
    }

    public function getUser($id)
    {
        $links = Link::where('user_id', $id)->orderBy('created_at', 'desc')->paginate(20);
        return view('links', ['links' => $links, 'user' => User::find($id)]);
    }

    public function getUsers()
    {
        $collection = User::orderBy('name')->get();

        $grouped = $collection->groupBy(function ($item, $key) {
            return substr($item->name, 0, 1);
        })->all();
        return view('users', ['data' => $grouped]);
    }

    public function dashboard()
    {
        $links = Link::where('user_id', \Auth::user()->id)->paginate(20);
        return view('dashboard', ['links' => $links]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getLink($id)
    {
        $link = Link::with(['comments' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);
        $link->increment('viewed');
        $isLike = false;
        if (\Auth::check()) {
            $like = Favourite::where('user_id', \Auth::user()->id)->where('link_id', $id)->first();
            if ($like) {
                $isLike = true;
            }

        }
        return view('show', ['link' => $link, 'isLike' => $isLike]);
    }

    public function addLike($id)
    {
        $like = Favourite::where('user_id', \Auth::user()->id)->where('link_id', $id)->first();
        if ($like) {
            $like->delete();
            return redirect('/link/' . $id)->with('success', 'Đã bỏ yêu thích !');
        } else {
            $re = new Favourite;
            $re->link_id = $id;
            $re->user_id = \Auth::user()->id;
            $re->save();
            return redirect('/link/' . $id)->with('success', 'Đã thêm vào yêu thích !');
        }

    }

    public function voteLink($id)
    {
        $type = request()->type;
        $link = Link::find($id);
        if ($type == "dislike") {
            $link->increment('dislike');
        } else {
            $link->increment('like');
        }
        return redirect('/link/' . $id)->with('success', 'Đã vote !');
    }
}
