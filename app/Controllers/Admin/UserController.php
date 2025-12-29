<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userModel = new \App\Models\UserModel();

        $search = $this->request->getGet('search');
        $role   = $this->request->getGet('role');
        $date   = $this->request->getGet('date');

        if ($search) {
            $userModel
                ->groupStart()
                ->like('name', $search)
                ->orLike('email', $search)
                ->groupEnd();
        }

        if ($role) {
            $userModel->where('role', $role);
        }

        if ($date) {
            $userModel->where('DATE(created_at)', $date);
        }

        // ✅ هنا الفرق
        $data['users'] = $userModel
            ->orderBy('id', 'ASC')
            ->find();

        return view('admin/users/index', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');

        $data = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'role'  => $this->request->getPost('role'),
        ];

        $this->userModel->update($id, $data);

        return redirect()->back()
            ->with('success', 'تم تحديث بيانات المستخدم بنجاح');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if ($user['role'] === 'admin') {
            return redirect()->back()
                ->with('error', 'لا يمكن حذف الأدمن');
        }

        $this->userModel->delete($id);

        return redirect()->back()
            ->with('success', 'تم حذف المستخدم بنجاح');
    }
}
