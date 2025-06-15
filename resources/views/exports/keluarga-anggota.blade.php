<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Anggota Rumah Tangga</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12pt;
            color: #000;
        }

        .page-break { page-break-after: always; }
        .cover {
            text-align: center;
            margin-bottom: 40px;
        }
        .cover h1 {
            font-size: 24px;
            margin: 10px;
        }
        .cover h2 {
            font-size: 18px;
            margin: 10px;
        }

        .title {
            font-size: 12pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
            background-color: #dfdfdf;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        thead {
            background-color: #eee;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 4px 6px;
            text-align: left;
            vertical-align: top;
        }

        .bg-wafat {
            background-color: #fdecea;
        }
    </style>
</head>

<body>

    <div class="cover">

        <h1>GKJ Manahan Surakarta</h1>
        <h2>Formulir Sensus Jemaat</h2>
    </div>

    {{-- <div class="title">Keterangan Tempat</div> --}}

    <table>
        <tbody>
            <tr>
                <td colspan="3" class="title">I. Keterangan Tempat</td>
            </tr>
            <tr>
                <td style="  width: 3%;">1</td>
                <td style="  width: 25%;">Blok / Pepanthan</td>
                <td>{{ $keluarga->blok->name }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Nama Kepala Keluarga</td>
                <td>{{ $keluarga->name }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Alamat Lengkap <br> (Tuliskan Nama Jalan, Gang, Kampung,No Rumah Tanpa Rt, Rw)</td>
                <td>{{ $keluarga->alamat_detail }}</td>
            </tr>
            <tr>
                <td>4</td>
                <td>RT / RW</td>
                <td>{{ $keluarga->alamat_rt . " / ". $keluarga->alamat_rw }}</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Desa/ Kelurahan</td>
                <td>{{ $keluarga->desaKelurahan->name }}</td>
            </tr>
            <tr>
                <td>6</td>
                <td>Kecamatan</td>
                <td>{{ $keluarga->kecamatan->name }}</td>
            </tr>
            <tr>
                <td>7</td>
                <td>Kabupaten/ Kota</td>
                <td>{{ $keluarga->kabKota->name }}</td>
            </tr>
            <tr>
                <td>8</td>
                <td>Provinsi</td>
                <td>{{ $keluarga->provinsi->name }}</td>
            </tr>
            <tr>
                <td>9</td>
                <td>Jarak Dari Rumah Ke Tempat Ibadah</td>
                <td>{{ $keluarga->jarakRumah->name }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <td colspan="11" class="title">II. Keterangan Pokok Anggota Rumah Tangga</td>
            </tr>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Nomor Induk Gereja</th>
                <th>Hubungan Keluarga</th>
                <th>Status Perkawinan</th>
                <th>Tanggal Lahir</th>
                <th>Golongan Darah</th>
                <th>Ijazah Terakhir</th>
                <th>Kegiatan / Pekerjaan</th>
                <th>Pendapatan / Bulan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($anggotas as $key => $anggota)
                <tr @if ($anggota->is_wafat == '1') class="bg-wafat" @endif>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $anggota->name }}</td>
                    <td>{{ $anggota->jns_kelamin }}</td>
                    <td>{{ $anggota->nomor_induk_gereja }}</td>
                    <td>{{ $anggota->hubunganKeluarga->name ?? '-' }}</td>
                    <td>{{ $anggota->perkawinan->name ?? '-' }}</td>
                    <td>{{ $anggota->tgl_lahir }}</td>
                    <td>{{ $anggota->golDarah->name ?? '-' }}</td>
                    <td>{{ $anggota->ijazah->name ?? '-' }}</td>
                    <td>{{ $anggota->pekerjaan->name ?? '-' }}</td>
                    <td>{{ $anggota->pendapatan->name ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" style="text-align: center">Data Kosong</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <td colspan="11" class="title">III. Keterangan Lanjutan Anggota Rumah Tangga</td>
            </tr>
            <tr>
                <th>No</th>
                <th>Tempat Baptis Anak</th>
                <th>Tanggal Baptis Anak</th>
                <th>Tempat Sidi</th>
                <th>Tanggal Sidi</th>
                <th>Talenta / Hobi</th>
                <th>Aktivitas Pelayanan</th>
                <th>Memiliki BPJS / Asuransi</th>
                <th>Penyakit Kronis</th>
                <th>Domisili di Alamat</th>
                <th>Nomor WA</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($anggotas as $key => $anggota)
                <tr @if ($anggota->is_wafat == '1') class="bg-wafat" @endif>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $anggota->tempatBabtis->name ?? '-' }}</td>
                    <td>{{ $anggota->tgl_babtis ?? '-' }}</td>
                    <td>{{ $anggota->tempatSidi->name ?? '-' }}</td>
                    <td>{{ $anggota->tgl_sidi ?? '-' }}</td>
                    <td>{{ $anggota->hobi->name ?? '-' }}</td>
                    <td>{{ $anggota->aktifitas_pelayanan ?? '-' }}</td>
                    <td>{{ $anggota->memiliki_bpjs_asuransi == '1' ? 'Ya' : 'Tidak' }}</td>
                    <td>{{ $anggota->penyakit->name ?? '-' }}</td>
                    <td>{{ $anggota->domisili_alamat == '1' ? 'Ya' : 'Tidak' }}</td>
                    <td>{{ $anggota->nomor_wa }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" style="text-align: center">Data Kosong</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
