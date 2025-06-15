<?php

namespace App\Livewire\Admin\ModalAnggotas;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use App\Models\KeluargaAnggota;
use Illuminate\Support\Facades\Hash;

class AnggotaList extends Component
{
    public $keluarga_id, $idToDelete;

    public function confirmDelete(int $id): void
    {
        $this->idToDelete = $id;
        $this->dispatch('show-delete-modal');
    }
    public function deleteConfirmed(): void
    {
        if ($this->idToDelete) {
            $anggota_details = KeluargaAnggota::find($this->idToDelete);
            if ($anggota_details->user_id) {
                User::findOrFail($anggota_details->user_id)->delete();
            }
            KeluargaAnggota::findOrFail($this->idToDelete)->delete();
            $this->idToDelete = null;
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

    public function mount($keluarga_id)
    {
        Carbon::setLocale('id');
        $this->keluarga_id = $keluarga_id;
    }

    public function edit($id, $keluarga_id){
        $this->dispatch('livewire.admin.modal-anggotas.edit-anggota', $id, $keluarga_id);
    }

    public function pindahKepala($id, $keluarga_id){
        $this->dispatch('livewire.admin.modal-anggotas.pindah-anggota', $id, $keluarga_id);
    }

    public function wafat($id, $keluarga_id){
        $this->dispatch('livewire.admin.modal-anggotas.wafat-anggota', $id, $keluarga_id);
    }

    public function render()
    {
        $anggotas = KeluargaAnggota::where('keluarga_id', $this->keluarga_id)
            ->orderBy('hubungan_keluarga_id')->orderBy('tgl_lahir')->get();
        return view('livewire.admin.modal-anggotas.anggota-list', compact('anggotas'));
    }
}
