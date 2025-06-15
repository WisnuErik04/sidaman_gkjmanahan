<?php

namespace App\Livewire\Admin\Pendapatans;

use Livewire\Component;
use App\Models\Pendapatan;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;


#[Title('Tambah Pendapatan | Sidaman')]
class AddPendapatan extends Component
{
    public $menuName = 'Pendapatan';
    public $name = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        Pendapatan::create([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Pendapatan added successfully!');

        return redirect()->to(route('pendapatan.index'));
    }

    public function render()
    {
        return view('livewire.admin.pendapatans.add-pendapatan');
    }
}
