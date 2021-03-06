<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Talk;

class TalkController extends Controller
{
    public function index($id)
    {
        $user = Auth::user();
        $post = Post::find($id);
        $talks = Post::find($id)->talks()->paginate(10);

        return view('user.posts.post', compact('user', 'post', 'talks'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        //DBへ登録
        $talk = new Talk();

        try {
            $talk->post_id = $request->id;
            $talk->user_id = $user->id;
            $talk->comment = $request->comment;

            $talk->save();
        }catch(\Exception $e) {
            report($e);
            return response(compact('e'));
        }

        //ページを再描画する為該当するpost_idのtalkデータを取得
        $talks = Post::find($request->id)->talks()->latest()->paginate(5);
        
        return response(compact('talks'));
    }

    public function delete($id)
    {
        Talk::destroy($id);

        return redirect()->back()->with('flash_message', 'コメントを削除しました');
    }
}
