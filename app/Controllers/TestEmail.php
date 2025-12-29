<?php

namespace App\Controllers;

class TestEmail extends BaseController
{
    public function index()
    {
        $email = \Config\Services::email();

        $email->setTo('nour02alhuda@gmail.com'); // 🔴 حطي إيميلك الشخصي هنا
        $email->setSubject('اختبار الإيميل - AN Hotel');
        $email->setMessage('
            <h3>مرحبًا 👋</h3>
            <p>لو وصلتك هذه الرسالة، فالإيميل شغال تمام ✅</p>
        ');

        if ($email->send()) {
            return "✅ الإيميل تم إرساله بنجاح، شيكي الإيميل متاعك.";
        } else {
            // لو فشل
            return $email->printDebugger(['headers']);
        }
    }
}
