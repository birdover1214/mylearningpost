<li>
@if($skills[$post->skill_id - 1]->users[$post->user_id - 1]->pivot->skill_rank === 2)
                                                    <i class="fas fa-crown rank2"></i>
                                                @elseif($skills[$post->skill_id - 1]->users[$post->user_id - 1]->pivot->skill_rank === 3)
                                                    <i class="fas fa-crown rank3"></i>
                                                @elseif($skills[$post->skill_id - 1]->users[$post->user_id - 1]->pivot->skill_rank === 4)
                                                    <i class="fas fa-crown rank4"></i>
                                                @endif

</li>