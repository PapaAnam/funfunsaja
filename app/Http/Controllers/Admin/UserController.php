<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Admin;

class UserController extends Controller
{
	public function api()
	{
		$admins = Admin::all();
		return [
			'admin'			=> $admins->where('role', 'admin')->values(),
			'moderators'	=> $admins->where('role', 'moderator')->values(),
			'members' 		=> User::with(['bio'=>function($q){
				$q->where('status','1');
			}])->get()
		];
	}

	public function store(Request $r)
	{
		$r->validate([
			'username'	=> 'required|min:4|unique:admins',
			'password'	=> 'required|min:6|max:12',
			'role'		=> 'required',
		]);
		Admin::create($r->only('username','role')+[
			'password' => bcrypt($r->password)
		]);
		return response('User baru berhasil ditambahkan');
	}

	public function update($id, Request $r)
	{
		User::find($id)->update([
			'status' => $r->status
		]);
		if($r->status == '1')
			return 'User berhasil diverifikasi';
		return 'User berhasil dibanned';
	}

	public function delete(Admin $admin)
	{
		$admin->delete();
		return response('User berhasil dihapus');
	}
}
