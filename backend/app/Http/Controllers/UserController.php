<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Skill;
use App\Http\Requests\EditUserRequest;
use App\Services\SkillSortService;
use App\Services\GetDataService;

class UserController extends Controller
{
    public function index()
    {
        $auth = Auth::user();
        $user = User::find($auth->id);

        //SkillSortServiceにて学習時間の多い順にソートし、スキルと時間を取得
        list($skills, $times) = SkillSortService::sort($user);

        return view('user.mypage.userpage', compact('auth', 'user', 'skills', 'times'));
    }

    public function other($id)
    {
        $auth = Auth::user();
        $user = User::find($id);

        if($user) {
            //SkillSortServiceにて学習時間の多い順にソートし、スキルと時間を取得
            list($skills, $times) = SkillSortService::sort($user);
        }else {
            return redirect('/');
        }

        return view('user.mypage.userpage', compact('auth', 'user', 'skills', 'times'));
    }

    public function getData(Request $request)
    {
        //GetDataServiceにてグラフ描画の為のデータを取得
        $data = GetDataService::getData($request);
        
        return response(compact('data'));
    }

    public function edit()
    {
        $user = Auth::user();

        //選択済みのskill_idをcheckboxに初期設定する為配列として取得
        $selected_ids = [];

        for($i = 0; $i < count($user->skills); $i++) {
            $selected_ids[$i] = $user->skills[$i]->pivot->skill_id;
        }

        $skills = Skill::all();

        return view('user.mypage.edit', compact('user','selected_ids', 'skills'));
    }

    public function update(EditUserRequest $request)
    {
        $user = Auth::user();

        $newImage = '';

        //プロフィール画像が更新されている場合は以下の画像の処理を行う
        if(!is_null($request->user_image)) {
            //リクエストされたファイル名から拡張子を取り除く
            $fileNameWithExt = $request->user_image->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //拡張子のみを取得
            $ext = $request->user_image->getClientOriginalExtension();
            //ファイル名と拡張子の間に現在時刻を挿入
            $newImage = $fileName.'_'.time().'.'.$ext;

            //更新したプロフィール画像をpublic/storage/user_imagesへ移動
            $request->user_image->storeAs('public/user_images', $newImage);
            //画像の削除
            Storage::delete('public/user_images/'.$user->user_image);
        }

        //更新処理
        try {
            //ユーザーデータの更新
            $user->fill([
                'name' => $request->name,
                'email' => $request->email,
                'introduction' => $request->introduction,
            ]);

            //プロフィール画像が変更されていた場合更新
            if($newImage) {
                $user->fill([
                    'user_image' => $newImage,
                ]);
            }
            
            //新しいパスワードが入力されていた場合passwordも更新
            if($request->password) {
                $user->fill(['password' => Hash::make($request->password)]);
            }
            
            $user->save();

            //スキルの更新
            $user->skills()->sync($request->skills);
        }catch(\Exception $e) {
            report($e);
            //エラー処理
            dd($e);
            return redirect()->back()->with('flash_message', 'プロフィールの更新に失敗しました');
        }

        return redirect('user/mypage')->with('flash_message', 'プロフィールを更新しました');
    }

    public function delete()
    {
        $user = Auth::user();

        User::findOrfail($user->id)->delete();

        //ユーザープロフィール画像の削除
        Storage::delete('public/user_images/'.$user->user_image);

        return redirect(route('home'))->with('flash_message', '登録を解除しました');
    }
}
