<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Skill;
use App\Models\Post;
use App\Http\Requests\EditUserRequest;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        //学習時間の多い順にスキルをソートする
        //ユーザーの投稿からスキル名と学習時間を合計したコレクションを取得
        $datas = Post::where('user_id', $user->id)->join('skills', 'posts.skill_id', '=', 'skills.id')->get()
        ->groupBy(function($row) {
            return $row->skill_name;
        })->map(function($skill) {
            return $skill->sum('time');
        });
        //昇順に並び替え
        $data = $datas->sort();
        //コレクションから連想配列にする
        $array = $data->all();
        //配列を降順にする
        $sort = array_reverse($array);
        //キー(スキル名)の配列と値(合計学習時間)の配列に分ける
        $skills = array_keys($sort);
        $times = array_values($sort);

        return view('mypage/mypage', compact('user', 'skills', 'times'));
    }

    public function getData(Request $request)
    {
        //$request->countがセットされていなければ0を設定
        if($request->count == null) {
            $request->count = 0;
            $request->week = '1week';
        }

        //取得するデータの範囲を変数に代入する
        $week = '';
        if($request->week === '1week') {
            $week = 7;
        }else {
            $week = 14;
        }

        //グラフ描画の為のデータを挿入する変数の初期化
        $datas = [];
        //データ取得開始日を計算する
        $startDay = new Carbon('today');
        $startDay->subDay($week * $request->count + $week);
        //データ取得終了日を計算する
        $endDay = new Carbon('today');
        $endDay->subDay($week * $request->count + $week -1);
        //$datasはkeyを日付、valueを学習時間として渡す為、日付を挿入する為の変数を作成し計算
        $setDay = new Carbon('today');
        $setDay->subDay($week * $request->count + $week);


        for($i = 0; $i < $week; $i++) {
            $times = Post::select('time')->where('user_id', $request->id)->where('created_at', '>=', $startDay->addDay(1))
            ->where('created_at', '<', $endDay->addDay(1))->get();
            $time = $times->sum('time');
            $setDay->addDay(1);
            $day = $setDay->format('m/d');
            $datas[$day] = $time;
        }
        
        return response(compact('datas'));
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

        return view('mypage/edit', compact('user','selected_ids', 'skills'));
    }

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
                'user_image' => $request->user_image,
            ]);
            
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

        return redirect('/mypage')->with('flash_message', 'プロフィールを更新しました');
    }

    public function delete()
    {
        $user = Auth::user();

        User::findOrfail($user->id)->delete();

        //ユーザープロフィール画像の削除
        Storage::delete('public/user_images/'.$user->user_image);

        return redirect(route('home'))->with('flash_message', '登録を解除しました');
    }

    public function other($id)
    {
        $user = User::find($id);

        if($user) {
            //学習時間の多い順にスキルをソートする
            //ユーザーの投稿からスキル名と学習時間を合計したコレクションを取得
            $datas = Post::where('user_id', $user->id)->join('skills', 'posts.skill_id', '=', 'skills.id')->get()
            ->groupBy(function($row) {
                return $row->skill_name;
            })->map(function($skill) {
                return $skill->sum('time');
            });
            //昇順に並び替え
            $data = $datas->sort();
            //コレクションから連想配列にする
            $array = $data->all();
            //配列を降順にする
            $sort = array_reverse($array);
            //キー(スキル名)の配列と値(合計学習時間)の配列に分ける
            $skills = array_keys($sort);
            $times = array_values($sort);
        }else {
            return redirect('/');
        }

        return view('mypage/otherpage', compact('user', 'skills', 'times'));
    }
}
