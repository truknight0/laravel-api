<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function result($data)
    {

        if (!is_array($data) && !is_string($data)) {
            if ($data->isEmpty()) {
                $return = [
                    'message' => '데이터가 없습니다.',
                    'data' => null
                ];
            } else {
                $return = [
                    'message' => config('constants.message.success'),
                    'data' => $data
                ];
            }
        } else {
            if (empty($data)) {
                $return = [
                    'message' => '데이터가 없습니다.',
                    'data' => null
                ];
            } else {
                if (is_string($data)) {
                    $return = [
                        'message' => $data,
                        'data' => null
                    ];
                } else {
                    $return = [
                        'message' => config('constants.message.success'),
                        'data' => $data
                    ];
                }
            }
        }

        return response()->json($return);
    }
}
