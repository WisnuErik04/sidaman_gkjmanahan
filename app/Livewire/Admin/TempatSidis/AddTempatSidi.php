<?php

namespace App\Livewire\Admin\TempatSidis;

use Livewire\Component;
use App\Models\TempatSidi;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

#[Title('Tambah Tempat Sidi | Sidaman')]
class AddTempatSidi extends Component
{
    public $menuName = 'Tempat Sidi';
    public $name = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        TempatSidi::create([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Tempat Sidi added successfully!');

        return redirect()->to(route('tempat_sidi.index'));
    }

    public function render()
    {
        return view('livewire.admin.tempat-sidis.add-tempat-sidi');
    }
}
