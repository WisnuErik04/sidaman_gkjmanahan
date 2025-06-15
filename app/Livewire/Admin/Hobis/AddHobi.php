<?php

namespace App\Livewire\Admin\Hobis;

use App\Models\Hobi;
use Livewire\Component;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

#[Title('Tambah Hobi | Sidaman')]
class AddHobi extends Component
{
    public $menuName = 'Hobi';
    public $name = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        Hobi::create([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Hobi added successfully!');

        // return redirect()->route('hobi.index');
        return redirect()->to(route('hobi.index'));
        // return redirect('/hobi-list');
    }

    public function render()
    {
        return view('livewire.admin.hobis.add-hobi');
    }
}
