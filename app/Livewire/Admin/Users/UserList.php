<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Hash;

#[Title('Data Akun Pengguna | Sidaman')]
class UserList extends Component
{
    public ?int $idToDelete = null;
    public function confirmDelete(int $id): void
    {
        $this->idToDelete = $id;
        $this->dispatch('show-delete-modal');
    }
    public function deleteConfirmed(): void
    {
        if ($this->idToDelete) {
            User::findOrFail($this->idToDelete)->delete();
            Toaster::success('Data deleted successfully!');
            $this->dispatch('close-delete-modal');
        }
    }

    public ?int $idToReset = null;
    public function resetPassword(int $id): void
    {
        $this->idToReset = $id;
        $this->dispatch('show-reset-modal');
    }
    public function resetConfirmed(): void
    {
        if ($this->idToReset) {
            $password = Hash::make('12345678');
            User::find($this->idToReset)->update([
                'password' => $password
            ]);
            Toaster::success('Password reset successfully!');
            $this->dispatch('close-reset-modal');
        }
    }


    use WithPagination;
    public $menuName = "Akun Pengguna";

    public $searchName = '';
    public $searchEmail = '';
    public $searchRole = '';

    public $perPage = 10;
    public $sortDirection1 = 'asc';    // Default arah sorting
    public $sortDirection2 = 'asc';    // Default arah sorting
    public $sortField1 = 'role'; // Default kolom sorting
    public $sortField2 = 'name'; // Default kolom sorting

    public function render()
    {
        $users = $this->loadUsers();
        return view('livewire.admin.users.user-list', compact('users'));
    }

    public function loadUsers()
    {
        $query = User::query();

        // Filter
        if ($this->searchName) {
            $query->where('name', 'like', '%' . $this->searchName . '%');
        }
        if ($this->searchEmail) {
            $query->where('email', 'like', '%' . $this->searchEmail . '%');
        }
        if ($this->searchRole) {
            $query->whereIn('role', $this->searchRole);
        }

        // Sorting
        if ($this->sortField1 === 'role') {
            $query->orderBy('role', $this->sortDirection1);
        }
        if ($this->sortField2 === 'name') {
            $query->orderBy('name', $this->sortDirection2);
        }

        // Trigger frontend reactivity
        $this->dispatch('reinit-hsselect');

        // Pagination
        return $query->paginate($this->perPage);
    }


    // Filtering
    public function updatingSearchName()
    {
        $this->resetPage();
    }
    public function updatingSearchEmail()
    {
        $this->resetPage();
    }
    public function updatingSearchRole()
    {
        $this->resetPage();
    }

    // Pagination
    public function setPerPage($number)
    {
        $this->perPage = $number;
        $this->resetPage();
    }
    public function sortBy($field)
    {
        if ($this->sortField1 === $field) {
            // Kalau klik field yang sama, toggle arah
            $this->sortDirection1 = $this->sortDirection1 === 'asc' ? 'desc' : 'asc';
        } else if ($this->sortField2 === $field) {
            // Kalau klik field yang sama, toggle arah
            $this->sortDirection2 = $this->sortDirection2 === 'asc' ? 'desc' : 'asc';
        } else {
            // Kalau klik field baru, set field dan arah default asc
            $this->sortField1 = $field;
            $this->sortDirection1 = 'asc';
            $this->sortField2 = $field;
            $this->sortDirection2 = 'asc';
        }

        $this->resetPage(); // reset ke halaman 1 biar hasilnya benar
    }
    public function paginationView()
    {
        return 'vendor.livewire.custom';
    }
}
