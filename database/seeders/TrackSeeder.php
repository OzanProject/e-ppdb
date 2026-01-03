<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\PpdbTrack;

class TrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure at least one school exists
        $school = School::first();
        if (!$school) {
            $school = School::create([
                'name' => 'SMP Negeri Demo',
                'jenjang' => 'smp',
                'alamat' => 'Jl. Pendidikan No. 1',
                'phone' => '021-1234567',
                'email' => 'info@smpndemo.sch.id',
            ]);
        }

        $tracks = [
            [
                'name' => 'Zonasi',
                'description' => 'Jalur pendaftaran bagi calon peserta didik yang berdomisili di dalam wilayah zonasi yang ditetapkan.',
                'quota' => 50, // 50%
                'is_active' => true,
            ],
            [
                'name' => 'Afirmasi',
                'description' => 'Jalur pendaftaran bagi calon peserta didik dari keluarga ekonomi tidak mampu dan penyandang disabilitas.',
                'quota' => 15, // 15%
                'is_active' => true,
            ],
            [
                'name' => 'Prestasi Akademik',
                'description' => 'Jalur pendaftaran berdasarkan nilai rapor dan prestasi akademik lainnya.',
                'quota' => 15, // 15%
                'is_active' => true,
            ],
            [
                'name' => 'Prestasi Non-Akademik',
                'description' => 'Jalur pendaftaran berdasarkan prestasi perlombaan/pertandingan di bidang olahraga, seni, dll.',
                'quota' => 15, // 15%
                'is_active' => true,
            ],
            [
                'name' => 'Perpindahan Tugas Orang Tua/Wali',
                'description' => 'Jalur pendaftaran bagi calon peserta didik yang mengikuti kepindahan tugas orang tua/wali.',
                'quota' => 5, // 5%
                'is_active' => true,
            ],
        ];

        foreach ($tracks as $track) {
            PpdbTrack::updateOrCreate(
                [
                    'school_id' => $school->id,
                    'name' => $track['name'],
                ],
                $track
            );
        }

        $this->command->info('Jalur Penerimaan Siswa Baru (Tracks) berhasil dibuat!');
    }
}
