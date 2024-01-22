<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class QnaBoardReply extends Model
{
    use HasFactory, HasApiTokens, SoftDeletes;

    protected $fillable = [
        'idx',
        'contents',
        'choice_status',
        'user_idx',
        'rel_board_idx',
    ];

    protected $table = 'qna_board_reply';

    protected $relations = 'qna_board';

    public function replies() {
        return $this->belongsTo(QnaBoardReply::class, 'choice_status');
    }

    public function replyList(int $relBoardIdx) {
        $list = DB::table('qna_board_reply')
            ->where('rel_board_idx', $relBoardIdx)
            ->whereNull('deleted_at')
            ->get();

        return $list;
    }

    public function replyCount(int $relBoardIdx) {
        return self::replyList($relBoardIdx)->count();
    }
}
