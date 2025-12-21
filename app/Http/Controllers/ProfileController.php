<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name'    => ['required', 'string', 'max:255'],
        'email'   => ['required', 'email', 'max:255', Rule::unique('user', 'email')->ignore($user->user_id, 'user_id')],
        'phone'   => ['nullable', 'string', 'max:20', 'regex:/^([0-9\s\-\+\(\)]*$)/', Rule::unique('user', 'phone')->ignore($user->user_id, 'user_id')],
        'address' => ['nullable', 'string', 'max:500'],
    ], [
        'email.unique' => 'Email này đã được sử dụng.',
        'phone.unique' => 'Số điện thoại này đã được đăng ký.',
        'phone.regex'  => 'Số điện thoại không hợp lệ.',
    ]);

    $user->name    = $request->name;
    $user->email   = $request->email;
    $user->phone   = $request->phone;
    $user->address = $request->address;

    if ($user->isDirty('email')) {
        $user->email_verified_at = null; 
    }

    $user->save();


    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công!',
            'user'    => $user->only(['name', 'email', 'phone', 'address'])
        ]);
    }


    return back()->with('status', 'profile-updated');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

}
