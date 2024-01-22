<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class QnaBoard extends Model
{
    use HasFactory, HasApiTokens;

    public $timestamps = false;

    protected $table = 'qna_board';

    protected $relations = 'qna_board_reply';

    protected $primaryKey = 'idx';


    public function boards() {
        return $this->belongsTo(QnaBoard::class);
    }

    public function replies() {
        return $this->hasMany(QnaBoardReply::class, 'choice_status');
    }

    public function qnaList(int $start, int $count = 6) {
        $qnaList = DB::table('qna_board')
            ->select('qna_board.idx',
                'qna_board.title',
                DB::raw("IF(CHAR_LENGTH(qna_board.contents) > 20, CONCAT(left(qna_board.contents, 20), '...'), qna_board.contents) as contents"),
                'qna_board.user_idx',
                DB::raw('count(qna_board_reply.idx) as reply_count'))
            ->leftJoin('qna_board_reply', 'qna_board.idx', '=', 'qna_board_reply.rel_board_idx')
            ->whereNull('qna_board_reply.deleted_at')
            ->groupBy('qna_board.idx')
            ->offset($start)
            ->limit($count)
            ->get();

        return $qnaList;
    }

    public function view(int $idx) {
        $qnaView = DB::table('qna_board')
            ->where('idx', $idx)
            ->get();

        return $qnaView;
    }
}
