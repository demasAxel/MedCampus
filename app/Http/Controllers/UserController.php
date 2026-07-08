<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->whereNull('deleted_at')->get();
        return view('admin-users', compact('users'));
    }

    public function create()
    {
        return view('admin-user-add');
    }

    public function store(Request $request)
    {
        $prefix = $request->role === 'Doctor' ? 'MC' : ($request->role === 'Admin' ? 'ADM' : 'ST');
        $newId = $prefix . '-' . rand(100000, 999999);

        $roleId = 1;
        if ($request->role === 'Doctor') $roleId = 2;
        if ($request->role === 'Admin') $roleId = 3;

        $request->validate([
            'email' => 'required|email|unique:users,user_email',
        ], [
            'email.unique' => 'Alamat surel ini sudah terdaftar di sistem, termasuk pada akun yang telah diarsipkan.'
        ]);

        DB::table('users')->insert([
            'id_user'     => $newId,
            'user_name'   => $request->name,
            'user_email'  => $request->email,
            'user_phone'  => $request->phone,
            'id_role'     => $roleId,
            'user_dept'  => $request->department ?? '-',
            'user_status' => 'active',
            'password'    => Hash::make($request->password),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect('/admin/users')->with('success', 'User berhasil didaftarkan!');
    }

    public function destroy($id)
    {
        DB::table('users')->where('id_user', $id)->update([
            'deleted_at'  => now(),
            'user_status' => 'suspended',
            'updated_at'  => now()
        ]);

        return redirect('/admin/users')->with('success', 'Pengguna berhasil dihapus secara aman dari sistem!');
    }

    public function edit(Request $request)
    {
        $id = $request->query('id');
        $user = DB::table('users')->where('id_user', $id)->first();

        if (!$user) {
            return redirect('/admin/users')->with('error', 'User tidak ditemukan!');
        }

        return view('admin-user-edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $roleId = 1;
        if ($request->role === 'Doctor') $roleId = 2;
        if ($request->role === 'Admin') $roleId = 3;

        DB::table('users')->where('id_user', $id)->update([
            'user_name'   => $request->name,
            'user_email'  => $request->email,
            'user_phone'  => $request->phone,
            'id_role'     => $roleId,
            'user_dept'   => $request->department ?? '-',
            'user_status' => $request->status,
            'updated_at'  => now(),
        ]);

        return redirect('/admin/users')->with('success', 'Profile berhasil diupdate!');
    }
}