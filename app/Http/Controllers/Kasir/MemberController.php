<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{

    public function index()
    {
        $members = Member::latest()->get(); // Fetch all members, latest first
        return view('cashier.members.index', compact('members'));
    }

    public function create()
    {
        return view('cashier.members.create'); // Show the registration form
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'nama_member' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email|unique:users,email',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'password' => 'required|min:6',
        ],
        [
            'nama_member.required' => 'Nama member wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'no_telp.required' => 'Nomor telepon wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        // Create member
        $member = Member::create([
            'nama_member' => $request->nama_member,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
        ]);

        // Also create a user if needed
        User::create([
            'name' => $request->nama_member,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member', // Make sure you have a 'role' column in the users table
        ]);

        return redirect()->route('members.index')->with('success', 'Member registered successfully!');
    }

    public function edit(Member $member)
    {
        return view('cashier.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'nama_member' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $member->id,
            'no_telp' => 'required|string|max:20',
        ],
        [
            'nama_member.required' => 'Nama member wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'no_telp.required' => 'Nomor telepon wajib diisi',
        ]);

        $member->update($request->all());

        return redirect()->route('members.index')->with('success', 'Member updated successfully!');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member deleted successfully!');
    }
}
