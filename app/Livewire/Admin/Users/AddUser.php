<?php

namespace App\Livewire\Admin\Users;

use App\Models\Blok;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

#[Title('Tambah Akun Pengguna | Sidaman')]
class AddUser extends Component
{
    public $menuName = 'Akun Pengguna';
    public $showPassword = 'y';
    public $name, $email, $password, $password_confirmation, $role, $blok_id;

    public function save()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'email' => ['required', 'string', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:admin,majelis,warga'],
        ];

        if ($this->role === 'majelis') {
            $rules['blok_id'] = ['required', 'exists:bloks,id'];
        }

        $validated = $this->validate($rules);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        $this->reset();

        Toaster::success('Pengguna added successfully!');

        // return redirect()->route('user.index');
        return redirect()->to(route('user.index'));
        // return redirect('/user-list');
    }

    public function render()
    {
        $bloks = Blok::all(); // Sesuaikan dengan model dan kolom
        $this->dispatch('reinit-hsselect'); // 🔥 Dispatch event ke JS

        return view('livewire.admin.users.add-user', compact('bloks'));
    }
}
