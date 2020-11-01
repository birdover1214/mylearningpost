<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class FavoriteService {

    public static function favorite($request, $status)
    {
        $user = Auth::user();
        $post = Post::find($request->id);

        if($status === "attach") {
            $post->users()->attach($user->id);
        }else {
            $post->users()->detach($user->id);
        }

        $count = $post->users()->count();

        return $count;
    }
}