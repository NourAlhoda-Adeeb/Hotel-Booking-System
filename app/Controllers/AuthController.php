<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }


    public function loginProcess()
    {
        $userModel = new UserModel();

        $email    = trim($this->request->getPost('email'));
        $password = trim($this->request->getPost('password'));

        /* ======================
           بيانات الأدمن الثابتة
        ====================== */
        // $adminEmail    = 'admin@hotel.com';
        // $adminPassword = '22222222';

        // // ✅ تحقق الأدمن
        // if ($email === $adminEmail && $password === $adminPassword) {

        //     session()->set([
        //         'user_id'    => 1,
        //         'user_name'  => 'Admin',
        //         'user_email' => 'admin@hotel.com',
        //         'user_role'  => 'admin',
        //     ]);


        //     return redirect()->to('/admin/dashboard')
        //         ->with('auth_success', 'مرحبًا بك في لوحة تحكم الأدمن');
        // }

        /* ======================
           مستخدم عادي
        ====================== */
        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'بيانات الدخول غير صحيحة');
        }

        session()->set([
            'user_id'    => $user['id'],
            'user_name'  => $user['name'],
            'user_email' => $user['email'],
            'user_role'  => $user['role'], // user
        ]);
        // 👇 توجيه حسب الصلاحية
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard');
        }

        return redirect()->to('/')
            ->with('auth_success', 'تم تسجيل دخولك بنجاح');
    }

    public function registerProcess()
    {
        $userModel = new UserModel();

        $name     = trim($this->request->getPost('name'));
        $email    = trim($this->request->getPost('email'));
        $password = trim($this->request->getPost('password'));

        // تحقق من الإيميل
        if ($userModel->where('email', $email)->first()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'البريد الإلكتروني مستخدم مسبقًا');
        }

        $userModel->insert([
            'name'     => $name,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => 'user'
        ]);

        return redirect()->to('/login')
            ->with('auth_success', 'تم إنشاء الحساب بنجاح، يمكنك تسجيل الدخول');
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
