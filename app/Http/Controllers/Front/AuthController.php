<?php

namespace App\Http\Controllers\Front;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Отобразить форму регистрации
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registerForm()
    {
        return view('front.register');
    }

    /**
     * Зарегестрировать пользователя
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
        $user = User::add($request->all());
        $user->generatePassword($request->get('password'));

        return redirect('/login');
    }

    /**
     * Отобразить форму входа
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loginForm()
    {
        //dd(Auth::check());
        return view('front.login');
    }

    /**
     * Войти
     * @param Request $request
     */
    public function login(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //Попытаться на основе полей залоигинить пользователя
       if(Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),

       ]))
       {
           return redirect('/');
       }
       return redirect()->back()->with('status', 'Неправильный логин или пароль');
    }

    /**
     * Выйти
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
