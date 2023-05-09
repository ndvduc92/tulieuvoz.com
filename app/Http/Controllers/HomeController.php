<?php

namespace App\Http\Controllers;

use App\Link;
use App\User;
use Validator;
use App\Comment;
use App\Favourite;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

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
            'link' => 'bail|required|url'
        ]);

        if ($validator->fails()) {
            return back();
        }
        $exist = Link::where('link', $request->link)->first();
        if ($exist) {
            return redirect('/link/'.$exist->id)->with('success', 'Link đã tồn tại !');
        }
        $link = new Link;
        $link->name = $request->name;
        $link->link = $request->link;
        $link->description = $request->description;
        if (\Auth::check()) {
            $link->user_id = \Auth::user()->id;
        }
        $link->save();
        return redirect('/link/'.$link->id);
    }

    public function postComment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required'
        ]);

        if ($validator->fails()) {
            return back();
        }

        $comment = new Comment;
        $comment->link_id = $id;
        $comment->name = $request->name;
        $comment->comment = $request->comment;
        $comment->save();
        return redirect('/link/'.$id)->with('success', 'Đã bình luận !');
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
            $links = $sort == 'view' ? Link::orderBy('viewed', 'desc')->paginate(20) : Link::orderBy('vote', 'desc')->paginate(20);
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
            if ($like) $isLike = true;
        }
        $src = $link->link;
        $iframe = strpos($src, 'spankbang') !== false;
        return view('show', ['link' => $link, 'iframe' => $iframe, 'isLike' => $isLike]);
    }

    public function addLike($id)
    {
        $like = Favourite::where('user_id', \Auth::user()->id)->where('link_id', $id)->first();
        if ($like) {
            $like->delete();
            return redirect('/link/'.$id)->with('success', 'Đã bỏ yêu thích !');
        } else {
            $re = new Favourite;
            $re->link_id = $id;
            $re->user_id = \Auth::user()->id;
            $re->save();
            return redirect('/link/'.$id)->with('success', 'Đã thêm vào yêu thích !');
        }

    }


    public function voteLink($id)
    {
        $type = request()->type;
        $link = Link::find($id);
        if ($type == "dislike") {
            $link->increment('dislike');
        } else {
            $link->increment('vote');
        }
        return redirect('/link/'.$id)->with('success', 'Đã vote !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function iframe()
    {
        $src = request()->src;
        $link = null;

        if (strpos($src, 'spankbang') !== false) {
            $link = $this->spk($src);
            return $link;
        }


    }

    public function spk($src) {
        $client = new Client();
        $arrs = explode('/', $src);
        $arr = $arrs[3];
        $client = new Client();
        $spkUrl = 'https://spankbang.com/'.$arr.'/video';
        $arrs = [
            'https://spkts7.herokuapp.com',
            'https://spkts10.herokuapp.com',
            'https://spkts14.herokuapp.com',
        ];
        $host = $arrs[array_rand($arrs)];
        $url = $host.'/api/info?url='.$spkUrl;
        $url = explode(' ', $url);
        $url = implode("+", $url);
        $response = $client->get($url);
        if ($response->getStatusCode() == 200) {
            $res = (string) $response->getBody();
            $res = json_decode($res);
            $link = $res->info->url;
            return view('spk', ['link' => $link]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
