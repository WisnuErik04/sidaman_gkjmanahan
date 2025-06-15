<?php

namespace App\Livewire\Admin\HubunganKeluargas;

use Livewire\Component;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use App\Models\HubunganKeluarga;


#[Title('Tambah Hubungan Keluarga | Sidaman')]
class AddHubunganKeluarga extends Component
{
    public $menuName = 'Hubungan Keluarga';
    public $name = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        HubunganKeluarga::create([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Hubungan Keluarga added successfully!');

        return redirect()->to(route('hubungan_keluarga.index'));
    }

    public function render()
    {
        return view('livewire.admin.hubungan-keluargas.add-hubungan-keluarga');
    }
}
