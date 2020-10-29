<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Skill;
use App\Http\Requests\PostRequest;
use App\Models\User;

class PostController extends Controller
{
    //メインページ遷移
    public function index()
    {
        //ログインチェック
        if(Auth::check()) {
            $user = Auth::user();
            $posts = Post::latest('updated_at')->paginate(5);
            $skills = Skill::all();

            return view('main', compact('user', 'posts', 'skills'));
        }

        return view('top');
    }

    //新規投稿機能
    public function create(PostRequest $request)
    {
        $user = Auth::user();

        $post = new Post;
        try {
            $post->user_id = $user->id;
            $post->skill_id = $request->skill;
            $post->time = $request->time;
            $post->comment = $request->comment;

            $post->save();
        }catch(\Exception $e) {
            report($e);

        }

        $posts = POST::all();

        return response(compact('posts', 'user'));
    }

    //投稿削除機能
    public function delete(Request $request)
    {
        //削除の実行
        Post::destroy($request->id);

        return redirect()->back()->with('flash_message', '削除しました');
    }

    //投稿編集対象のデータ取得
    public function getid(Request $request)
    {
        $postData = Post::find($request->id);

        return response(compact('postData'));
    }

    //投稿編集機能
    public function edit(PostRequest $request)
    {
        //更新対象のレコードのデータを取得
        $postData = Post::find($request->id);

        //DB内の対象レコード更新処理
        try {
            $postData->fill($request->all())->save();
        }catch(\Exception $e) {
            report($e);
        }

        return response(compact('postData'));
    }

    //いいね機能
    public function attach(Request $request)
    {
        $user = Auth::user();
        $post = Post::find($request->id);

        $post->users()->attach($user->id);

        $count = $post->users()->count();

        return response(compact('count'));
    }

    //いいね解除機能
    public function detach(Request $request)
    {
        $user = Auth::user();
        $post = Post::find($request->id);

        $post->users()->detach($user->id);

        $count = $post->users()->count();

        return response(compact('count'));
    }

    //検索機能
    public function search(Request $request)
    {
        $keyword = $request->search;
        $user = Auth::user();
        $skills = Skill::all();

        //キーワードを元に検索を行う
        if($keyword != null) {
            $posts = Post::whereHas('skill', function($query) use ($keyword) {
                $query->where('skill_name', 'LIKE', "%$keyword%");
            })->orwhereHas('user', function($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");
            })->orwhere('comment', 'LIKE', "%$keyword%")->latest('updated_at')->paginate(5);
        }else {
            $posts = Post::latest('updated_at')->paginate(5);
        }

        return view('main', compact('user', 'posts', 'skills'));
    }

}
