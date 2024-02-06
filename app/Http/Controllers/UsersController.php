<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    /*
     * auth login
     * token을 부여받기 위해 login 로직 구현
     * 회원가입 단계 없이 가상데이터의 값으로 로그인 하기위해 password 통일
     */
    /**
     * @throws ValidationException
     */
    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = Users::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([config('constants.message.not_auth')]);
        }

        // token return
        $user->save();
        $data = [
            'token' => $user->createToken('apiToken')->plainTextToken
        ];

        return $this->result($data);
//        return $user->createToken('apiToken')->plainTextToken;
    }
}
