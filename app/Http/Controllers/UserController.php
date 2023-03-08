<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Tugas MVC';
        $data['q'] = $request->q;
        $data['rows'] = User::where('nama_user', 'like', '%' . $request->q . '%')->get();
        return view('index', $data);
    }

    public function create(Request $request)
    {
        $data['title'] = 'Tambah User';
        $data['levels'] = ['admin' => 'Admin', 'user' => 'User'];
        return view('create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_user' => 'required',
            'email' => 'required|unique:tb_user',
            'password' => 'required',
            'level' => 'required',
        ]);

        $user = new User();
        $user->nama_user = $request->nama_user;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->level = $request->level;
        $user->save();
        return redirect('user')->with('success', 'Tambah Data Berhasil');
    }

    public function show(User $user)
    {

    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect('user')->with('success', 'Hapus Data Berhasil');
    }
}
