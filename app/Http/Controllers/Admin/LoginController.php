<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Org\Captcha;

class LoginController extends Controller
{
    //后台登录页
    public function login()
    {
        return view('admin/login');
    }

    //验证码
    public function captcha()
    {
        $captcha = new Captcha;
        return $captcha->verify();
    }
}
