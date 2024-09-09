<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UserController extends AdminBaseController
{
    // Отображение списка пользователей
    public function index()
    {
        $users = User::with('roles')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    // Форма создания нового пользователя
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    // Сохранение нового пользователя
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('user');

        foreach ($request->roles as $role) {
            $user->assignRole($role);
        }

        return redirect()->route('admin_users_index')->with('success', 'User created successfully.');
    }

    // Форма редактирования пользователя
    public function edit(int $id)
    {
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
    }

    // Обновление пользователя
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        $user->assignRole('user');

        foreach ($request->roles as $role) {
            $user->assignRole($role);
        }

        return redirect()->route('admin_users_index')->with('success', 'User updated successfully.');
    }

    public function destroy(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::findOrFail($user_id);

        // Проверяем, есть ли у пользователя волонтер
        if ($user->volunteer) {
            // Удаляем волонтера, связанного с пользователем
            $user->volunteer->delete();
        }

        // Удаляем самого пользователя
        $user->delete();

        // Перенаправляем с сообщением об успешном удалении
        return redirect()->route('admin_users_index')->with('success', 'User and associated volunteer deleted successfully.');
    }


    public function show($id)
    {
        $user = User::with('volunteer')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }
}
