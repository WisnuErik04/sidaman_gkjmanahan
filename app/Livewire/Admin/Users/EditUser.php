<?php

namespace App\Livewire\Admin\Users;

use App\Models\Blok;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

#[Title('Edit Akun Pengguna | Sidaman')]
class EditUser extends Component
{
    public $menuName = 'Akun Pengguna';
    public $showPassword = 'n';
    public $name, $email, $password, $password_confirmation, $role, $blok_id;
    public $user_details;

    public function mount($id){        
        $this->loadEdit($id);
    }

    public function loadEdit($id){
        $this->user_details = User::find($id);
        $this->fill([
            'blok_id' => $this->user_details->blok_id,
            'name' => $this->user_details->name,
            'email' => $this->user_details->email,
            'role' => $this->user_details->role
        ]);
    }
    public function save()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $this->user_details->id],
            'email' => ['required', 'string', 'max:255', 'unique:users,email,' . $this->user_details->id],
            'role' => ['required', 'in:admin,majelis,warga'],
        ];

        if ($this->role === 'majelis') {
            $rules['blok_id'] = ['required', 'exists:bloks,id'];
        }

        $validated = $this->validate($rules);

        $this->user_details->update($validated);

        $this->reset();

        Toaster::success('Pengguna edited successfully!');

        return redirect()->to(route('user.index'));
    }

    public function render()
    {
        $bloks = Blok::all(); // Sesuaikan dengan model dan kolom
        $this->dispatch('reinit-hsselect'); // 🔥 Dispatch event ke JS

        return view('livewire.admin.users.edit-user', compact('bloks'));
    }
}
