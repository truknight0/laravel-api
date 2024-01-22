<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Users;
use App\Models\QnaBoard;
use App\Models\QnaBoardReply;
use Illuminate\Support\Facades\Auth;

class QnaBoardController extends Controller
{
    /*
     * 질문 목록 조회
     */
    public function getLists(int $page) {
        // 페이지 당 기본 6개 게시물 가져오기
        $count = 6;
        $start = $count * ($page - 1);
        $qnaBoard = new QnaBoard;
        $list = $qnaBoard->qnaList($start, $count);
        $totalCount = $qnaBoard->totalCount();

        $data = [
            'total_count' => $totalCount,
            'list' => $list,
        ];

        return $this->result($data);
    }

    /*
     * 질문 본문
     */
    public function show(int $idx) {
        $qnaBoard = new QnaBoard;
        $viewData = $qnaBoard->view($idx);

        $qnaBoardReply = new QnaBoardReply;
        $replyData = $qnaBoardReply->replyList($idx);

        $data = [
            'content' => $viewData,
            'reply' => $replyData
        ];

        return $this->result($data);
    }

    /*
     * 질문 등록
     */
    public function create(Request $request) {
        $this->validate($request, [
            'title' => 'required|string',
            'contents' => 'required|string',
        ]);

        $user = Users::find(Auth::user()->idx);

        $qnaBoard = new QnaBoard;
        $qnaBoard->title = $request->title;
        $qnaBoard->contents = $request->contents;
        $qnaBoard->user_idx = $user->idx;

        $qnaBoard->save();
        return $this->result(config('constants.message.success'));
    }

    /*
     * 답글 등록
     */
    public function replyCreate(Request $request) {
        $this->validate($request, [
            'contents' => 'required|string',
            'rel_board_idx' => 'required|integer',
        ]);

        $user = Users::find(Auth::user()->idx);

        // 멘토 (user_level =2)만 작성 가능
        if ($user->user_level == config('constants.status.user_menti')) {
            return $this->result(config('constants.message.reply_not_create_user_level'));
        }

        $qnaBoardReply = new QnaBoardReply;

        // 원글에 달린 답변이 3개 이상이면 더 이상 작성 불가
        if ($qnaBoardReply->replyCount($request->rel_board_idx) >= 3) {
            return $this->result(config('constants.message.reply_count_over'));
        }

        $qnaBoardReply->contents = $request->contents;
        $qnaBoardReply->user_idx = $user->idx;
        $qnaBoardReply->rel_board_idx = $request->rel_board_idx;

        $qnaBoardReply->save();
        return $this->result(config('constants.message.success'));
    }

    /*
     * 답글 채택/취소
     */
    public function setReplyChoice(Request $request) {
        $this->validate($request, [
            'idx' => 'required|integer',
        ]);

        $reply = QnaBoardReply::where('idx', $request->idx)->first();

        if ($reply->choice_status == config('constants.status.reply_not_choice')) {
            $updateStatus = config('constants.status.reply_choice');
        } else {
            $updateStatus = config('constants.status.reply_not_choice');
        }

        QnaBoardReply::where('idx', $request->idx)->update(['choice_status' => $updateStatus]);
        return $this->result(config('constants.message.success'));
    }

    /*
     * 답글 삭제
     */
    public function replyDelete(int $idx) {

        $user = Users::find(Auth::user()->idx);
        $reply = QnaBoardReply::where('idx', $idx)->first();
        $qna = QnaBoard::where('idx', $reply->rel_board_idx)->first();

        // 답변 작성자 본인 혹은 원글 작성자만 답변 삭제 가능
        if ($user->idx != $reply->user_idx && $user->idx != $qna->user_idx) {
            return $this->result(config('constants.message.reply_user_not_delete'));
        }

        // 이미 채택된 답변이면 삭제 불가
        if ($reply->choice_status === config('constants.status.reply_choice')) {
            return $this->result(config('constants.message.reply_choice_not_delete'));
        }

        QnaBoardReply::where('idx', $idx)->delete();

        return $this->result(config('constants.message.success'));
    }
}
