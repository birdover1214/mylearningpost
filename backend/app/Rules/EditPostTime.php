<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Post;

class EditPostTime implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

        //本日中に投稿された他の投稿の学習時間を合計して1日の総時間を超えている場合はエラーを返す
        //本日の学習時間を取得
        $todaysPostTime = Post::select('time')->where('user_id', $user->id)->where('created_at', '>=', $today)->get()->sum('time');
        //1日の総時間から学習時間を差し引き、投稿可能な学習時間を取得
        $todaysFreeTime = 24*60 - $todaysPostTime;

        if($todaysFreeTime <= $value) {
            return true;
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
