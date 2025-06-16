<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Filament\Mahasiswa\Resources\PendaftaranUjianResource\Pages;
use App\Filament\Mahasiswa\Resources\PendaftaranUjianResource\RelationManagers;
use App\Models\BerkasUjian;
use App\Models\Skripsi;
use App\Models\UjianSkripsi;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Card;


class PendaftaranUjianResource extends Resource
{
    protected static ?string $model = UjianSkripsi::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Pendaftaran Ujian';
    protected static ?string $pluralLabel = 'Pendaftaran Ujian';
    protected static ?string $title = 'Pendaftaran Ujian';
    protected static ?string $slug = 'pendaftaran-ujian';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('skripsi_id')
                    ->default(function () {
                        $user = auth()->user();
                        return $user->skripsi()->where('status', 'Disetujui')->value('id');
                    }),
                Select::make('jenis_ujian')
                    ->label('Jenis Ujian')
                    ->options(function () {
                        $user = auth()->user();
                        $skripsi = $user->skripsi()->where('status', 'Disetujui')->first();

                        if (! $skripsi) {
                            return [];
                        }

                        $ujianTerverifikasi = \App\Models\UjianSkripsi::where('skripsi_id', $skripsi->id)
                            ->where('status', 'Terverifikasi')
                            ->pluck('jenis_ujian')
                            ->toArray();

                        // Validasi urutan
                        if (! in_array('Seminar Proposal', $ujianTerverifikasi) && $skripsi->is_approved_for_sempro) {
                            return ['Seminar Proposal' => 'Seminar Proposal'];
                        }

                        if (! in_array('Seminar Hasil', $ujianTerverifikasi) && $skripsi->is_approved_for_semhas) {
                            return ['Seminar Hasil' => 'Seminar Hasil'];
                        }

                        if (! in_array('Sidang Skripsi', $ujianTerverifikasi) && $skripsi->is_approved_for_sidang) {
                            return ['Sidang Skripsi' => 'Sidang Skripsi'];
                        }

                        return [];
                    })
                    ->required()
                    ->reactive()
                    ->columnSpanFull(),


                Group::make([
                    FileUpload::make('berkas_proposal')
                        ->label('Proposal Skripsi Bertanda Tangan')
                        ->directory('berkas-ujian')
                        ->required()
                        ->placeholder('PDF maksimal 5MB')
                        ->maxSize(5120)
                        ->visible(fn(Get $get) => $get('jenis_ujian') === 'Seminar Proposal')
                        ->acceptedFileTypes(['application/pdf']),

                    FileUpload::make('berkas_surat_pernyataan_bermaterai')
                        ->label('Surat Pertanyaan Bermaterai')
                        ->directory('berkas-ujian')
                        ->required()
                        ->placeholder('PDF maksimal 5MB')
                        ->maxSize(5120)
                        ->visible(fn(Get $get) => $get('jenis_ujian') === 'Seminar Proposal')
                        ->acceptedFileTypes(['application/pdf']),

                    FileUpload::make('berkas_surat_riset')
                        ->label('Surat Riset')
                        ->directory('berkas-ujian')
                        ->required()
                        ->placeholder('PDF maksimal 5MB')
                        ->maxSize(5120)
                        ->visible(fn(Get $get) => $get('jenis_ujian') === 'Seminar Proposal')
                        ->acceptedFileTypes(['application/pdf']),


                    FileUpload::make('berkas_soft_cover')
                        ->label('Soft Cover Draft Skripsi yang sudah ditandatangani oleh pembimbing (2eks)')
                        ->directory('berkas-ujian')
                        ->required()
                        ->visible(fn(Get $get) => in_array($get('jenis_ujian'), ['Seminar Hasil', 'Sidang Skripsi']))
                        ->acceptedFileTypes(['application/pdf']),
                    // FileUpload::make('berkas_sheet_bimbingan')
                    //     ->label('Fotocopy review sheet bimbingan skripsi')
                    //     ->directory('berkas-ujian')
                    //     ->required()
                    //     ->visible(fn(Get $get) => $get('jenis_ujian') === 'Seminar Hasil'),
                    FileUpload::make('berkas_transkrip_nilai')
                        ->label('Transkrip nilai yang sudah lengkap')
                        ->directory('berkas-ujian')
                        ->required()
                        ->visible(fn(Get $get) => $get('jenis_ujian') === 'Seminar Hasil')
                        ->acceptedFileTypes(['application/pdf']),
                    FileUpload::make('berkas_lembar_persetujuan_bimbingan')
                        ->label('Lembar persetujuan bimbingan dari surat tugas')
                        ->directory('berkas-ujian')
                        ->required()
                        ->visible(fn(Get $get) => $get('jenis_ujian') === 'Seminar Hasil')
                        ->acceptedFileTypes(['application/pdf']),
                    FileUpload::make('berkas_bukti_pembayaran')
                        ->label('Bukti pembayaran SPP dan SKS')
                        ->directory('berkas-ujian')
                        ->required()
                        ->visible(fn(Get $get) => $get('jenis_ujian') === 'Seminar Hasil')
                        ->acceptedFileTypes(['application/pdf']),
                    FileUpload::make('berkas_surat_pernyataan_menyelesaikan_skripsi')
                        ->label('Surat pernyataan untuk menyelesaikan skripsi')
                        ->directory('berkas-ujian')
                        ->required()
                        ->visible(fn(Get $get) => $get('jenis_ujian') === 'Seminar Hasil')
                        ->acceptedFileTypes(['application/pdf']),
                    FileUpload::make('berkas_frs')
                        ->label('FRS semester akhir dari SIAKSES (matakuliah skripsi)')
                        ->directory('berkas-ujian')
                        ->required()
                        ->visible(fn(Get $get) => $get('jenis_ujian') === 'Seminar Hasil')
                        ->acceptedFileTypes(['application/pdf']),
                    FileUpload::make('berkas_surat_pernyataan_tidak_menjiplak')
                        ->label('Surat pernyataan tidak menjiplak skripsi')
                        ->directory('berkas-ujian')
                        ->required()
                        ->visible(fn(Get $get) => $get('jenis_ujian') === 'Seminar Hasil')
                        ->acceptedFileTypes(['application/pdf']),


                    FileUpload::make('berkas_sertifikat_keahlian_bnsp')
                        ->label('Fotocopy sertifikat keahlian BNSP')
                        ->directory('berkas-ujian')
                        ->required()
                        ->visible(fn(Get $get) => $get('jenis_ujian') === 'Sidang Skripsi')
                        ->acceptedFileTypes(['application/pdf']),
                    FileUpload::make('berkas_soft_cover_jurnal')
                        ->label('Soft cover berwarna gading draft jurnal ilmiah yang sudah di TTD pembimbing')
                        ->directory('berkas-ujian')
                        ->required()
                        ->visible(fn(Get $get) => $get('jenis_ujian') === 'Sidang Skripsi')
                        ->acceptedFileTypes(['application/pdf']),
                    FileUpload::make('berkas_sk_magangkerja')
                        ->label('Surat keterangan selesai magang/kerja')
                        ->directory('berkas-ujian')
                        ->required()
                        ->visible(fn(Get $get) => $get('jenis_ujian') === 'Sidang Skripsi')
                        ->acceptedFileTypes(['application/pdf']),
                    FileUpload::make('berkas_bukti_kegiatan_magang')
                        ->label('Bukti kegiatan magang (bagi yang magang)')
                        ->directory('berkas-ujian')
                        ->required()
                        ->visible(fn(Get $get) => $get('jenis_ujian') === 'Sidang Skripsi')
                        ->acceptedFileTypes(['application/pdf']),
                    // FileUpload::make('berkas_stopmap')
                    //     ->label('Stopmap warna biru (2 buah)')
                    //     ->directory('berkas-ujian')
                    //     ->required()
                    //     ->visible(fn(Get $get) => $get('jenis_ujian') === 'Sidang Skripsi'),
                    FileUpload::make('berkas_turnitin_jurnal')
                        ->label('Surat keterangan turnitin jurnal dari perpustakaan')
                        ->directory('berkas-ujian')
                        ->required()
                        ->visible(fn(Get $get) => in_array($get('jenis_ujian'), ['Seminar Proposal', 'Sidang Skripsi']))
                        ->acceptedFileTypes(['application/pdf']),
                ])->columnSpanFull(),
            ]);
    }


    public static function table(Table $table): Table
    {
        $skripsiMilik = Skripsi::where('mahasiswa_id', auth()->user()->id)
            ->where('status', 'Disetujui')
            ->first();

        $query = UjianSkripsi::query();

        if ($skripsiMilik) {
            $query->where('skripsi_id', $skripsiMilik->id);
        } else {
            // Kasih query yang tidak akan mengembalikan hasil
            $query->whereNull('id');
        }
        return $table
            ->query($query)
            ->columns([
                TextColumn::make('index')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('jenis_ujian')
                    ->label('Jenis Ujian'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Menunggu Verifikasi' => 'gray',
                        'Terverifikasi' => 'success',
                        'Ditolak' => 'danger',
                    }),
                TextColumn::make('tanggal_seminar')
                    ->label('Tanggal Ujian')
                    ->date()
                    ->formatStateUsing(
                        fn($state, $record) =>
                        $record->is_schedule_approved_by_prodi && $state
                            ? \Carbon\Carbon::parse($state)->format('d-m-Y')
                            : 'Belum ditentukan'
                    ),
                TextColumn::make('waktu_seminar')
                    ->label('Waktu Ujian')
                    ->time()
                    ->formatStateUsing(
                        fn($state, $record) =>
                        $record->is_schedule_approved_by_prodi && $state
                            ? \Carbon\Carbon::parse($state)->format('H:i')
                            : 'Belum ditentukan'
                    ),
                TextColumn::make('ruangan')
                    ->label('Ruangan')
                    ->formatStateUsing(
                        fn($state, $record) =>
                        $record->is_schedule_approved_by_prodi && filled($state)
                            ? $state
                            : 'Belum ditentukan'
                    ),
            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePendaftaranUjians::route('/'),
        ];
    }
}
