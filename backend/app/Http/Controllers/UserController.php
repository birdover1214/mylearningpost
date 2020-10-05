<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Skill;
use App\Http\Requests\EditUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return view('mypage/mypage', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();

        //選択済みのskill_idをcheckboxに初期設定する為配列として取得
        $selected_ids = [];

        for($i = 0; $i < count($user->skills); $i++) {
            $selected_ids[$i] = $user->skills[$i]->pivot->skill_id;
        }

        $skills = Skill::all();

        return view('mypage/edit', compact('user','selected_ids', 'skills'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request)
    {
        $user = Auth::user();

        //プロフィール画像が更新されている場合は以下の画像の処理を行う
        if($request->user_image) {
            //リクエストされたファイル名から拡張子を取り除く
            $fileNameWithExt = $request->user_image->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //拡張子のみを取得
            $ext = $request->user_image->getClientOriginalExtension();
            //ファイル名と拡張子の間に現在時刻を挿入
            $newImage = $fileName.'_'.time().'.'.$ext;

            //更新したプロフィール画像をpublic/storage/user_imagesへ移動
            $request->user_image->storeAs('public/user_images', $newImage);
            //更新前の画像がデフォルト画像でなければ削除する
            if($user->user_image != 'no_picture.png') {
                Storage::delete('public/user_images/'.$user->user_image);
            }
        }

        //更新処理
        try {
            //ユーザーデータの更新
            $user->name = $request->name;
            $user->introduction = $request->introduction;
            $user->email = $request->email;
            
            //プロフィール画像が変更されていればuser_imageも更新
            if($request->user_image) {
                $user->user_image = $newImage;
            }
            //新しいパスワードが入力されていた場合passwordも更新
            if($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            //スキルの更新
            $user->skills()->sync($request->skills);
        }catch(\Exception $e) {
            //エラー処理
            return redirect()->back()->with('flash_message', 'プロフィールの更新に失敗しました');
        }

        return redirect('/mypage')->with('flash_message', 'プロフィールを更新しました');
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
