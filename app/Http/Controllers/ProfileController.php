<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
   
    // عرض صفحة تعديل الملف الشخصي
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    // تحديث الملف الشخصي
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // التحقق من صحة البيانات
        $request->user()->fill($request->validated());

        // معالجة الصورة الشخصية
        // وكذلك حذف الصورة القديمة
        if ($request->hasFile('avatar')) {
            if ($request->user()->avatar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($request->user()->avatar);
            }
            $request->user()->avatar = $request->file('avatar')->store('avatars', 'public');
        } elseif ($request->boolean('delete_avatar')) {
            if ($request->user()->avatar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($request->user()->avatar);
            }
            $request->user()->avatar = null;
        }

        // التحقق من صحة البريد الإلكتروني
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // حفظ التعديلات
        $request->user()->save();

        // إعادة توجيه المستخدم إلى صفحة الملف الشخصي
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // حذف الحساب
    public function destroy(Request $request): RedirectResponse
    {
        // التحقق من صحة كلمة المرور
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // الحصول على المستخدم
        $user = $request->user();

        // تسجيل الخروج
        Auth::logout();

        // حذف الحساب
        $user->delete();

        // تدمير الجلسة
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // إعادة توجيه المستخدم إلى الصفحة الرئيسية
        return Redirect::to('/');
    }
}
