<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\School;
use App\Models\PpdbTrack;
use App\Models\StudentProfile;
use App\Models\PpdbRegistration;
use App\Models\StudentDocument;
use Illuminate\Support\Facades\Hash;

class PpdbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create School if not exists (Modified to update if exists for testing)
        $school = School::first();
        if (!$school) {
             $school = School::create([
                'name' => 'SMP Negeri 4 Kota Demo',
                'jenjang' => 'smp',
                'alamat' => 'Jl. Merdeka No. 45, Kota Demo',
                'phone' => '(021) 555-5555',
                'email' => 'admin@smpn4demo.sch.id',
                'website' => 'smpn4demo.sch.id',
                'headmaster_name' => 'Drs. H. Amanah, M.Pd.',
                'headmaster_nip' => '19800101 200501 1 005',
                'tahun_ajaran' => date('Y') . '/' . (date('Y') + 1),
                'is_active' => true,
            ]);
        } else {
            // Update existing school for print test
            $school->update([
                'phone' => '(021) 555-5555',
                'email' => 'admin@smpn4demo.sch.id',
                'website' => 'smpn4demo.sch.id',
                'headmaster_name' => 'Drs. H. Amanah, M.Pd.',
                'headmaster_nip' => '19800101 200501 1 005',
            ]);
            $this->command->info('Updated existing school with detailed info.');
        }

        // Ensure tracks exist
        if ($school->ppdbTracks()->count() == 0) {
            $track = PpdbTrack::create([
                'school_id' => $school->id,
                'name' => 'Zonasi',
                'quota' => 100,
                'description' => 'Jalur berdasarkan jarak tempat tinggal.',
                'is_active' => true,
            ]);
        } else {
            $track = $school->ppdbTracks()->first();
        }

        // Create 10 dummy student applicants
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => 'Siswa ' . $i,
                'email' => 'siswa' . $i . '@test.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'is_active' => true,
            ]);

            StudentProfile::create([
                'user_id' => $user->id,
                'nisn' => '00' . rand(10000000, 99999999),
                'gender' => $i % 2 == 0 ? 'L' : 'P',
                'birth_place' => 'Jakarta',
                'birth_date' => now()->subYears(12)->subDays(rand(1, 365)),
                'phone' => '0812' . rand(10000000, 99999999),
                'address' => 'Jl. Contoh No. ' . $i,
                'school_origin' => 'SD Negeri ' . rand(1, 5),
            ]);

            $reg = PpdbRegistration::create([
                'user_id' => $user->id,
                'school_id' => $school->id,
                'ppdb_track_id' => $track->id,
                'registration_code' => 'REG-' . date('Y') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'status' => ['new', 'verified', 'rejected'][rand(0, 2)],
                'notes' => null,
                'score' => rand(7000, 9900) / 100, // 70.00 - 99.00
                'distance' => rand(100, 5000), // 100m - 5000m
            ]);

            // Create Dummy Documents
            $docs = ['kk', 'akta', 'ijazah', 'foto'];
            foreach ($docs as $type) {
                StudentDocument::create([
                    'ppdb_registration_id' => $reg->id,
                    'type' => $type,
                    'file_path' => 'documents/dummy.pdf', // Placeholder
                    'status' => 'pending',
                    'feedback' => null,
                ]);
            }
        }
    }
}
