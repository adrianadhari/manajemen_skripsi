<?php

namespace App\Filament\Mahasiswa\Resources\PendaftaranUjianResource\Pages;

use App\Filament\Mahasiswa\Resources\PendaftaranUjianResource;
use App\Models\BerkasUjian;
use App\Models\Bimbingan;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePendaftaranUjians extends ManageRecords
{
    protected static string $resource = PendaftaranUjianResource::class;

    public array $uploadedFiles = [];


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Daftar Ujian')
                ->modalHeading('Form Pendaftaran Ujian')
                ->modalSubmitActionLabel('Kirim')
                ->modalCancelAction(false)
                ->createAnother(false)
                ->visible(function () {
                    $user = auth()->user();
                    $skripsi = $user->skripsi()->where('status', 'Disetujui')->first();

                    if (! $skripsi) return false;

                    // Ambil semua ujian yang pernah diajukan oleh mahasiswa ini
                    $ujianMahasiswa = \App\Models\UjianSkripsi::where('skripsi_id', $skripsi->id)->get();

                    $terverifikasi = $ujianMahasiswa->where('status', 'Terverifikasi')->pluck('jenis_ujian')->toArray();
                    $menunggu = $ujianMahasiswa->where('status', 'Menunggu Verifikasi')->pluck('jenis_ujian')->toArray();
                    $ditolak = $ujianMahasiswa->where('status', 'Ditolak')->pluck('jenis_ujian')->toArray();

                    // === SEMINAR PROPOSAL ===
                    if (!in_array('Seminar Proposal', $terverifikasi)) {
                        if (in_array('Seminar Proposal', $menunggu)) return false;
                        return $skripsi->is_approved_for_sempro;
                    }

                    // === SEMINAR HASIL ===
                    if (!in_array('Seminar Hasil', $terverifikasi)) {
                        if (in_array('Seminar Hasil', $menunggu)) return false;
                        return $skripsi->is_approved_for_semhas;
                    }

                    // === SIDANG SKRIPSI ===
                    if (!in_array('Sidang Skripsi', $terverifikasi)) {
                        if (in_array('Sidang Skripsi', $menunggu)) return false;
                        return $skripsi->is_approved_for_sidang;
                    }

                    return false;
                })
                ->mutateFormDataUsing(function (array $data) {

                    $this->uploadedFiles = [
                        'Proposal Skripsi Bertanda Tangan' => $data['berkas_proposal'] ?? null,
                        'Surat Pernyataan Bermaterai' => $data['berkas_surat_pernyataan_bermaterai'] ?? null,
                        'Surat Riset' => $data['berkas_surat_riset'] ?? null,
                        'Soft Cover Draft Skripsi yang sudah ditandatangani oleh pembimbing (2eks)' => $data['berkas_soft_cover'] ?? null,
                        'Fotocopy review sheet bimbingan skripsi' => $data['berkas_sheet_bimbingan'] ?? null,
                        'Transkrip nilai yang sudah lengkap' => $data['berkas_transkrip_nilai'] ?? null,
                        'Lembar persetujuan bimbingan dari surat tugas' => $data['berkas_lembar_persetujuan_bimbingan'] ?? null,
                        'Bukti pembayaran SPP dan SKS' => $data['berkas_bukti_pembayaran'] ?? null,
                        'Surat pernyataan untuk menyelesaikan skripsi' => $data['berkas_surat_pernyataan_menyelesaikan_skripsi'] ?? null,
                        'FRS semester akhir dari SIAKSES (matakuliah skripsi)' => $data['berkas_frs'] ?? null,
                        'Surat pernyataan tidak menjiplak skripsi' => $data['berkas_surat_pernyataan_tidak_menjiplak'] ?? null,
                        'Fotocopy sertifikat keahlian BNSP' => $data['berkas_sertifikat_keahlian_bnsp'] ?? null,
                        'Soft cover berwarna gading draft jurnal ilmiah yang sudah di TTD pembimbing' => $data['berkas_soft_cover_jurnal'] ?? null,
                        'Surat keterangan selesai magang/kerja' => $data['berkas_sk_magangkerja'] ?? null,
                        'Bukti kegiatan magang (bagi yang magang)' => $data['berkas_bukti_kegiatan_magang'] ?? null,
                        'Stopmap warna biru (2 buah)' => $data['berkas_stopmap'] ?? null,
                        'Surat keterangan turnitin jurnal dari perpustakaan' => $data['berkas_turnitin_jurnal'] ?? null,
                    ];

                    // Hapus dari data utama sebelum simpan ke ujian_skripsi
                    unset($data['berkas_proposal'], $data['berkas_soft_cover'], $data['berkas_sheet_bimbingan'], $data['berkas_transkrip_nilai'], $data['berkas_lembar_persetujuan_bimbingan'], $data['berkas_bukti_pembayaran'], $data['berkas_surat_pernyataan_menyelesaikan_skripsi'], $data['berkas_frs'], $data['berkas_surat_pernyataan_tidak_menjiplak'], $data['berkas_sertifikat_keahlian_bnsp'], $data['berkas_soft_cover_jurnal'], $data['berkas_sk_magangkerja'], $data['berkas_bukti_kegiatan_magang'], $data['berkas_stopmap'], $data['berkas_turnitin_jurnal'], $data['berkas_surat_pernyataan_bermaterai'], $data['berkas_surat_riset']);

                    return $data;
                })
                ->after(fn($record, array $data) => $this->handleUploadedFiles($record)),
        ];
    }

    protected function handleUploadedFiles($record): void
    {
        foreach ($this->uploadedFiles as $namaBerkas => $filePath) {
            if ($filePath) {
                BerkasUjian::create([
                    'ujian_skripsi_id' => $record->id,
                    'nama_berkas' => $namaBerkas,
                    'file_path' => $filePath,
                ]);
            }
        }
    }
}
