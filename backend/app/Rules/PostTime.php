<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Post;

class PostTime implements Rule
{
    protected $day;
    protected $post_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($post_id)
    {
        $this->post_id = $post_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = Auth::user();
        $today = new Carbon('today');

        //新規投稿か編集で分岐
        if($this->post_id) {
            //投稿された日の合計時間を取得する
            $postday = Post::find($this->post_id)->created_at->format('Y-m-d 00:00:00');
            $postNextDay = Post::find($this->post_id)->created_at->format('Y-m-d 23:59:59');
            $postTime = Post::select('time')->where('user_id', $user->id)->where('created_at', '>=', $postday)->where('created_at', '<=', $postNextDay)->get()->sum('time');
            //投稿内容の時間を取得
            $posted_time = Post::select('time')->where('id', $this->post_id)->get()->sum('time');
            //1日の総時間(分)-投稿された日の総学習時間+投稿された学習時間によって残りの投稿可能な学習時間を取得
            $freeTime = 24*60 - $postTime + $posted_time;

            if($freeTime >= $value) {
                return true;
            }
        }else {
            //本日中に投稿された他の投稿の学習時間を合計して1日の総時間を超えている場合はエラーを返す
            //本日の学習時間を取得
            $todaysPostTime = Post::select('time')->where('user_id', $user->id)->where('created_at', '>=', $today)->get()->sum('time');
            //1日の総時間から学習時間を差し引き、投稿可能な学習時間を取得
            $todaysFreeTime = 24*60 - $todaysPostTime;
    
            if($todaysFreeTime >= $value) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '学習時間が1日の合計時間を超えています';
    }
}
