<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * ユーザー情報を編集画面表示
     * @param User $user 
     * @return view
     */
    public function editUser(User $user)
    {
        $user = User::where('id', Auth::id())->first();
        return view('users.edit', compact('user'));
    }
    /**
     * ユーザー情報の更新処理
     * @param UserRequest $request
     * @param User $user
     * @return void
     */
    public function updateUser(UserRequest $request, User $user)
    {
        $password = $request->password;
        $password2 = $request->password_confirmation;
        if (is_null($password) && is_null($password2)) {
            //パスワードが入力されていない時は名前とメールアドレスのみ更新する 
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $user->password;
            $user->save();
            return redirect(route('users.edit'))->with('flash_message', 'ユーザー情報を変更しました');
        } else {
            //パスワードが入力されていた場合は、ハッシュ化して全てのデータを更新する(パスワードの一致はUserRequestで確認済)
            $password = $request->input('password'); // 生のパスワード
            $hashed_password = Hash::make($password);
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password=$hashed_password;
            $user->save();
            return redirect(route('users.edit'))->with('flash_message', 'ユーザー情報を変更しました');
        }
    }
}