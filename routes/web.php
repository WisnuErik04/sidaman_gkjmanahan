<?php

use App\Livewire\Auth\Login;
use App\Livewire\Actions\Logout;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Admin\Bloks\AddBlok;
use App\Livewire\Admin\Hobis\AddHobi;
use App\Livewire\Admin\Users\AddUser;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\Bloks\EditBlok;
use App\Livewire\Admin\Bloks\ListBlok;
use App\Livewire\Admin\Hobis\EditHobi;
use App\Livewire\Admin\Hobis\ListHobi;
use App\Livewire\Admin\Users\EditUser;
use App\Livewire\Admin\Users\UserList;
use App\Livewire\Warga\Anggotas\Anggota;
use App\Livewire\Admin\Ijazahs\AddIjazah;
use App\Livewire\Teacher\Grades\AddGrade;
use App\Http\Controllers\ExportController;
use App\Livewire\Admin\Ijazahs\EditIjazah;
use App\Livewire\Admin\Ijazahs\ListIjazah;
use App\Livewire\Teacher\Grades\EditGrade;
use App\Livewire\Teacher\Grades\GradeList;
use App\Livewire\Warga\Keluargas\Keluarga;
use App\Livewire\Admin\Anggotas\AddAnggota;
use App\Livewire\Admin\Anggotas\AnggotaList;
use App\Livewire\Admin\Anggotas\EditAnggota;
use App\Livewire\Admin\Anggotas\ViewAnggota;
use App\Livewire\Warga\Anggotas\AnggotaView;
use App\Livewire\Admin\GolDarahs\AddGolDarah;
use App\Livewire\Admin\Keluargas\AddKeluarga;
use App\Livewire\Admin\Penyakits\AddPenyakit;
use App\Livewire\Teacher\Students\AddStudent;
use App\Livewire\Admin\Anggotas\ImportAnggota;
use App\Livewire\Admin\GolDarahs\EditGolDarah;
use App\Livewire\Admin\GolDarahs\ListGolDarah;
use App\Livewire\Admin\Keluargas\EditKeluarga;
use App\Livewire\Admin\Keluargas\KeluargaList;
use App\Livewire\Admin\Keluargas\ViewKeluarga;
use App\Livewire\Admin\Penyakits\EditPenyakit;
use App\Livewire\Admin\Penyakits\ListPenyakit;
use App\Livewire\Teacher\Students\EditStudent;
use App\Livewire\Teacher\Students\StudentList;
use App\Livewire\Warga\Keluargas\KeluargaView;
use App\Livewire\Admin\Pekerjaans\AddPekerjaan;
use App\Livewire\Admin\Keluargas\ImportKeluarga;
use App\Livewire\Admin\Pekerjaans\EditPekerjaan;
use App\Livewire\Admin\Pekerjaans\ListPekerjaan;
use App\Livewire\Admin\ExportAnggota\ListAnggota;
use App\Livewire\Admin\JarakRumahs\AddJarakRumah;
use App\Livewire\Admin\Pendapatans\AddPendapatan;
use App\Livewire\Admin\Perkawinans\AddPerkawinan;
use App\Livewire\Admin\TempatSidis\AddTempatSidi;
use App\Livewire\Admin\JarakRumahs\EditJarakRumah;
use App\Livewire\Admin\JarakRumahs\ListJarakRumah;
use App\Livewire\Admin\Pendapatans\EditPendapatan;
use App\Livewire\Admin\Pendapatans\ListPendapatan;
use App\Livewire\Admin\Perkawinans\EditPerkawinan;
use App\Livewire\Admin\Perkawinans\ListPerkawinan;
use App\Livewire\Admin\TempatSidis\EditTempatSidi;
use App\Livewire\Admin\TempatSidis\ListTempatSidi;
use App\Livewire\Admin\ExportKeluarga\ListKeluarga;
use App\Livewire\Teacher\Attendance\AttendancePage;
use App\Livewire\Admin\TempatBabtises\AddTempatBabtis;
use App\Livewire\Admin\TempatBabtises\EditTempatBabtis;
use App\Livewire\Admin\TempatBabtises\ListTempatBabtis;
use App\Livewire\Admin\HubunganKeluargas\AddHubunganKeluarga;
use App\Livewire\Admin\HubunganKeluargas\EditHubunganKeluarga;
use App\Livewire\Admin\HubunganKeluargas\ListHubunganKeluarga;

Route::get('/', Login::class)->name('home');
// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('/logout', Logout::class)->name('logout');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'warga'])
    ->name('warga.dashboard');
// dd(Auth::user());

// Route::middleware(['auth'])->group(function () {
//     //attendances
//     Route::get('/attendance', AttendancePage::class)->name('attendance.page');
// });

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::middleware(['majelis', 'auth'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');

    //keluargas
    Route::get('/keluarga', KeluargaList::class)->name('keluarga.index');
    Route::get('/keluarga/import', ImportKeluarga::class)->name('keluarga.import');
    Route::get('/keluarga/create', AddKeluarga::class)->name('keluarga.create');
    Route::get('/keluarga/edit/{id}', EditKeluarga::class)->name('keluarga.edit');
    Route::get('/keluarga/view/{id}', ViewKeluarga::class)->name('keluarga.view');

    //anggotas
    Route::get('/anggota', AnggotaList::class)->name('anggota.index');
    Route::get('/anggota/import', ImportAnggota::class)->name('anggota.import');
    Route::get('/anggota/create', AddAnggota::class)->name('anggota.create');
    Route::get('/anggota/edit/{id}', EditAnggota::class)->name('anggota.edit');
    Route::get('/anggota/view/{id}', ViewAnggota::class)->name('anggota.view');

    //USER
    Route::get('/user', UserList::class)->name('user.index');
    Route::get('/user/create', AddUser::class)->name('user.create');
    Route::get('/user/edit/{id}', EditUser::class)->name('user.edit');

    // =============== EXPORT ===============
    Route::get('/export_keluarga', ListKeluarga::class)->name('export_keluarga.index');
    Route::get('/export_anggota', ListAnggota::class)->name('export_anggota.index');

    Route::get('/export_keluarga_anggota/{id}', [ExportController::class, 'exportPDF'])->name('export_keluarga_anggota_pdf.index');
    // =============== EXPORT ===============
});

Route::middleware(['admin', 'auth'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');

    //keluargas
    Route::get('/keluarga', KeluargaList::class)->name('keluarga.index');
    Route::get('/keluarga/import', ImportKeluarga::class)->name('keluarga.import');
    Route::get('/keluarga/create', AddKeluarga::class)->name('keluarga.create');
    Route::get('/keluarga/edit/{id}', EditKeluarga::class)->name('keluarga.edit');
    Route::get('/keluarga/view/{id}', ViewKeluarga::class)->name('keluarga.view');

    //anggotas
    Route::get('/anggota', AnggotaList::class)->name('anggota.index');
    Route::get('/anggota/import', ImportAnggota::class)->name('anggota.import');
    Route::get('/anggota/create', AddAnggota::class)->name('anggota.create');
    Route::get('/anggota/edit/{id}', EditAnggota::class)->name('anggota.edit');
    Route::get('/anggota/view/{id}', ViewAnggota::class)->name('anggota.view');

    //USER
    Route::get('/user', UserList::class)->name('user.index');
    Route::get('/user/create', AddUser::class)->name('user.create');
    Route::get('/user/edit/{id}', EditUser::class)->name('user.edit');

    // =============== EXPORT ===============
    Route::get('/export_keluarga', ListKeluarga::class)->name('export_keluarga.index');
    Route::get('/export_anggota', ListAnggota::class)->name('export_anggota.index');

    Route::get('/export_keluarga_anggota/{id}', [ExportController::class, 'exportPDF'])->name('export_keluarga_anggota_pdf.index');
    // =============== EXPORT ===============

    // =============== MASTER DATA ===============
    //Blok
    Route::get('/blok', ListBlok::class)->name('blok.index');
    Route::get('/blok/create', AddBlok::class)->name('blok.create');
    Route::get('/blok/edit/{id}', EditBlok::class)->name('blok.edit');

    //GolDarah
    Route::get('/gol_darah', ListGolDarah::class)->name('gol_darah.index');
    Route::get('/gol_darah/create', AddGolDarah::class)->name('gol_darah.create');
    Route::get('/gol_darah/edit/{id}', EditGolDarah::class)->name('gol_darah.edit');

    //Hobi
    Route::get('/hobi', ListHobi::class)->name('hobi.index');
    Route::get('/hobi/create', AddHobi::class)->name('hobi.create');
    Route::get('/hobi/edit/{id}', EditHobi::class)->name('hobi.edit');

    //HubunganKeluarga
    Route::get('/hubungan_keluarga', ListHubunganKeluarga::class)->name('hubungan_keluarga.index');
    Route::get('/hubungan_keluarga/create', AddHubunganKeluarga::class)->name('hubungan_keluarga.create');
    Route::get('/hubungan_keluarga/edit/{id}', EditHubunganKeluarga::class)->name('hubungan_keluarga.edit');

    //Ijazah
    Route::get('/ijazah', ListIjazah::class)->name('ijazah.index');
    Route::get('/ijazah/create', AddIjazah::class)->name('ijazah.create');
    Route::get('/ijazah/edit/{id}', EditIjazah::class)->name('ijazah.edit');

    //JarakRumah
    Route::get('/jarak_rumah', ListJarakRumah::class)->name('jarak_rumah.index');
    Route::get('/jarak_rumah/create', AddJarakRumah::class)->name('jarak_rumah.create');
    Route::get('/jarak_rumah/edit/{id}', EditJarakRumah::class)->name('jarak_rumah.edit');

    //Pekerjaan
    Route::get('/pekerjaan', ListPekerjaan::class)->name('pekerjaan.index');
    Route::get('/pekerjaan/create', AddPekerjaan::class)->name('pekerjaan.create');
    Route::get('/pekerjaan/edit/{id}', EditPekerjaan::class)->name('pekerjaan.edit');

    //Pendapatan
    Route::get('/pendapatan', ListPendapatan::class)->name('pendapatan.index');
    Route::get('/pendapatan/create', AddPendapatan::class)->name('pendapatan.create');
    Route::get('/pendapatan/edit/{id}', EditPendapatan::class)->name('pendapatan.edit');

    //Penyakit
    Route::get('/penyakit', ListPenyakit::class)->name('penyakit.index');
    Route::get('/penyakit/create', AddPenyakit::class)->name('penyakit.create');
    Route::get('/penyakit/edit/{id}', EditPenyakit::class)->name('penyakit.edit');

    //Perkawinan
    Route::get('/perkawinan', ListPerkawinan::class)->name('perkawinan.index');
    Route::get('/perkawinan/create', AddPerkawinan::class)->name('perkawinan.create');
    Route::get('/perkawinan/edit/{id}', EditPerkawinan::class)->name('perkawinan.edit');

    //Tempat babtis
    Route::get('/tempat_babtis', ListTempatBabtis::class)->name('tempat_babtis.index');
    Route::get('/tempat_babtis/create', AddTempatBabtis::class)->name('tempat_babtis.create');
    Route::get('/tempat_babtis/edit/{id}', EditTempatBabtis::class)->name('tempat_babtis.edit');

    //Tempat sidi
    Route::get('/tempat_sidi', ListTempatSidi::class)->name('tempat_sidi.index');
    Route::get('/tempat_sidi/create', AddTempatSidi::class)->name('tempat_sidi.create');
    Route::get('/tempat_sidi/edit/{id}', EditTempatSidi::class)->name('tempat_sidi.edit');
    // =============== MASTER DATA ===============
});

Route::middleware(['warga', 'auth'])->group(function () {
    //keluargas
    Route::get('/warga/keluarga', Keluarga::class)->name('warga_keluarga.index');
    Route::get('/warga/keluarga/view', KeluargaView::class)->name('warga_keluarga.view');

    //anggotas
    Route::get('/warga/anggota', Anggota::class)->name('warga_anggota.index');
    Route::get('/warga/anggota/view', AnggotaView::class)->name('warga_anggota.view');
});

require __DIR__ . '/auth.php';
