<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Skill;
use App\Models\Talk;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditAdminRequest;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //投稿管理

    public function post()
    {
        $posts = Post::latest('updated_at')->paginate(30);

        return view('admin.post', compact('posts'));
    }

    public function postSearch(Request $request)
    {
        $keyword = $request->search;

        //キーワードを元に検索を行う
        if($keyword != null) {
            $posts = Post::whereHas('skill', function($query) use ($keyword) {
                $query->where('skill_name', 'LIKE', "%$keyword%");
            })->orwhereHas('user', function($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");
            })->orwhere('comment', 'LIKE', "%$keyword%")->latest('updated_at')->paginate(30);
        }else {
            $posts = Post::latest('updated_at')->paginate(30);
        }

        return view('admin.post', compact('posts'));
    }

    public function postDelete(Request $request)
    {
        Post::destroy($request->id);

        return redirect()->back();
    }


    //コメント管理

    public function comment()
    {
        $comments = Talk::latest('updated_at')->paginate(30);

        return view('admin.comment', compact('comments'));
    }

    public function commentSearch(Request $request)
    {
        $keyword = $request->search;

        //キーワードを元に検索を行う
        if($keyword != null) {
            $comments = Talk::whereHas('user', function($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");
            })->orwhere('comment', 'LIKE', "%$keyword%")
            ->orwhere('post_id', 'LIKE', "%$keyword%")->latest('updated_at')->paginate(30);
        }else {
            $comments = Talk::latest('updated_at')->paginate(30);
        }

        return view('admin.comment', compact('comments'));
    }

    public function commentDelete(Request $request)
    {
        Talk::destroy($request->id);

        return redirect()->back();
    }


    //ユーザー管理

    public function user()
    {
        $users = User::latest('created_at')->paginate(30);

        return view('admin.user', compact('users'));
    }

    public function userSearch(Request $request)
    {
        $keyword = $request->search;

        //キーワードを元に検索を行う
        if($keyword != null) {
            $users = User::where('id', 'LIKE', "%$keyword%")
            ->orwhere('name', 'LIKE', "%$keyword%")
            ->orwhere('email', 'LIKE', "%$keyword%")
            ->orwhere('introduction', 'LIKE', "%$keyword%")->latest('created_at')->paginate(30);
        }else {
            $users = User::latest('created_at')->paginate(30);
        }

        return view('admin.user', compact('users'));
    }

    public function userDelete(Request $request)
    {
        User::destroy($request->id);

        return redirect()->back();
    }


    //スキル管理

    public function skill()
    {
        $skills = Skill::latest('id')->paginate(30);

        return view('admin.skill', compact('skills'));
    }

    public function skillSearch(Request $request)
    {
        $keyword = $request->search;

        //キーワードを元に検索を行う
        if($keyword != null) {
            $skills = Skill::where('skill_name', 'LIKE', "%$keyword%")->latest('id')->paginate(30);
        }else {
            $skills = Skill::latest('id')->paginate(30);
        }

        return view('admin.skill', compact('skills'));
    }

    public function skillDelete(Request $request)
    {
        Skill::destroy($request->id);

        return redirect()->back();
    }

    public function skillAdd(Request $request)
    {
        //バリデーション定義
        $rules = [
            'skill_name' => 'required|unique:skills,skill_name|max:20',
        ];

        $messages = [
            'skill_name.required' => '※ スキル名を入力してください',
            'skill_name.unique' => '※ 入力されたスキルは既に登録済みです',
            'skill_name.max' => '※ スキル名は20文字以内で入力してください',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        //バリデーションチェック
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $skill = new Skill;
        try {
            $skill->skill_name = $request->skill_name;

            $skill->save();
        }catch(\Exception $e) {
            report($e);
            return redirect()->back()->with('flash_message', '投稿に失敗しました');
        }

        $skills = Skill::latest('id')->paginate(30);

        return view('admin.skill', compact('skills'));
    }


    public function edit()
    {
        $user = Auth::user();

        return view('admin.edit', compact('user'));
    }

    public function update(EditAdminRequest $request)
    {
        $user = Auth::user();

        //更新処理
        try {
            //ユーザーデータの更新
            $user->fill([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            
            //新しいパスワードが入力されていた場合passwordも更新
            if($request->password) {
                $user->fill(['password' => Hash::make($request->password)]);
            }
            
            $user->save();

        }catch(\Exception $e) {
            report($e);
            //エラー処理
            dd($e);
            return redirect()->back()->with('flash_message', '管理者情報の更新に失敗しました');
        }

        return redirect('admin/edit')->with('flash_message', '管理者情報を更新しました');
    }
}
