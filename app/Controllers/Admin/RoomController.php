<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoomModel;

class RoomController extends BaseController
{
    protected $roomModel;

    public function __construct()
    {
        $this->roomModel = new RoomModel();
    }

    /* ===============================
       عرض نموذج إضافة غرفة
    =============================== */
    public function create()
    {
        return view('admin/rooms/create', [
            'title' => 'إضافة غرفة'
        ]);
    }

    /* ===============================
       حفظ الغرفة
    =============================== */
    public function store()
    {
        $roomNumber = $this->request->getPost('room_number');
        // 3 أرقام فقط
        if (!preg_match('/^[0-9]{3}$/', $roomNumber)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'رقم الغرفة يجب أن يتكون من 3 أرقام فقط');
        }

        // ✅ تحقق: رقم الغرفة يبدأ من 100
        if ($roomNumber < 100) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'رقم الغرفة يجب أن يبدأ من 100');
        }

        // ✅ تحقق: منع تكرار رقم الغرفة
        if ($this->roomModel->where('room_number', $roomNumber)->first()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'رقم الغرفة موجود مسبقًا');
        }

        // ===== رفع الصورة =====
        $image = $this->request->getFile('image');
        $imageName = null;

        if ($image && $image->isValid()) {
            $imageName = $image->getRandomName();
            $image->move('uploads', $imageName);
        }

        // ===== حفظ الغرفة =====
        $this->roomModel->insert([
            'room_number' => $roomNumber,
            'type'        => $this->request->getPost('type'),
            'price'       => $this->request->getPost('price'),
            'status'      => $this->request->getPost('status'),
            'image'       => $imageName
        ]);

        return redirect()->to(base_url('admin/rooms'))
            ->with('success', 'تمت إضافة الغرفة بنجاح');
    }

    public function index()
    {
        $status = $this->request->getGet('status');

        $rooms = $this->roomModel->getRoomsByFilter($status);

        return view('admin/rooms/index', [
            'rooms' => $rooms
        ]);
    }


    public function edit($id)
    {
        $room = $this->roomModel->find($id);

        if (!$room) {
            return redirect()->to('admin/rooms');
        }

        return view('admin/rooms/edit', [
            'room'  => $room,
            'title' => 'تعديل الغرفة'
        ]);
    }
    public function update()
    {
        $id = $this->request->getPost('id');
        $room = $this->roomModel->find($id);

        if (!$room) {
            return redirect()->to('admin/rooms');
        }

        $roomNumber = $this->request->getPost('room_number');

        // تحقق 3 أرقام
        if (!preg_match('/^[0-9]{3}$/', $roomNumber)) {
            return redirect()->back()->with('error', 'رقم الغرفة يجب أن يكون 3 أرقام');
        }

        // منع التكرار (مع استثناء نفس الغرفة)
        $exists = $this->roomModel
            ->where('room_number', $roomNumber)
            ->where('id !=', $id)
            ->first();

        if ($exists) {
            return redirect()->back()->with('error', 'رقم الغرفة موجود مسبقًا');
        }

        // ===== الصورة =====
        $image = $this->request->getFile('image');
        $imageName = $room['image'];

        if ($image && $image->isValid()) {

            // حذف الصورة القديمة
            if ($room['image'] && file_exists('uploads/' . $room['image'])) {
                unlink('uploads/' . $room['image']);
            }

            $imageName = $image->getRandomName();
            $image->move('uploads', $imageName);
        }

        $this->roomModel->update($id, [
            'room_number' => $roomNumber,
            'type'        => $this->request->getPost('type'),
            'price'       => $this->request->getPost('price'),
            'status'      => $this->request->getPost('status'),
            'image'       => $imageName
        ]);

        return redirect()->to('admin/rooms')
            ->with('success', 'تم تعديل بيانات الغرفة بنجاح');
    }
    public function delete($id)
    {
        $room = $this->roomModel->find($id);

        if ($room) {
            if ($room['image'] && file_exists('uploads/' . $room['image'])) {
                unlink('uploads/' . $room['image']);
            }

            $this->roomModel->delete($id);
        }

        return redirect()->back()
            ->with('success', 'تم حذف الغرفة بنجاح');
    }
}
