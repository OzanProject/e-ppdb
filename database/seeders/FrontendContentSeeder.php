<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\User;
use App\Models\Post;
use App\Models\Faq;
use App\Models\PpdbSchedule;

class FrontendContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        
        $school = School::first();
        if (!$school) {
             \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
            $this->command->error('No school found. PLease run PpdbSeeder first.');
            return;
        }

        $admin = User::where('role', 'admin')->first();
        // Fallback to ANY user if admin is missing, ensuring valid FK
        $validUser = $admin ?? User::first();
        if (!$validUser) {
             // If NO users exist at all, we can't create posts with author.
             // But PpdbSeeder creates users. So this is edge case.
             // We'll create a dummy user just in case.
             $validUser = User::create([
                 'name' => 'Admin Vendor',
                 'email' => 'admin@vendor.com',
                 'password' => \Illuminate\Support\Facades\Hash::make('password'),
                 'role' => 'admin',
             ]);
        }
        $authorId = $validUser->id;

        // --- 1. SEED FAQS ---
        Faq::query()->delete();
        $faqs = [
            [
                'question' => 'Apa saja syarat dokumen yang harus disiapkan?',
                'answer' => "Dokumen wajib:\n1. Kartu Keluarga (KK) Asli/Fotocopy legalisir.\n2. Akta Kelahiran.\n3. Ijazah/Surat Keterangan Lulus (SKL) SD/MI.\n4. Pas Foto berwarna ukuran 3x4 (Background Merah/Biru).\n5. KIP/PKH (Jika ada, untuk jalur Afirmasi).",
                'order_index' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana cara mendaftar secara online?',
                'answer' => "1. Klik tombol 'Daftar Sekarang' di halaman utama.\n2. Isi formulir pembuatan akun siswa.\n3. Login menggunakan email dan password yang dibuat.\n4. Lengkapi biodata, nilai rapor, dan unggah dokumen.\n5. Pilih jalur pendaftaran dan kunci data (Finalisasi).",
                'order_index' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah ada biaya pendaftaran?',
                'answer' => 'Tidak ada. Seluruh proses pendaftaran PPDB di SMPN 4 Kota Demo GRATIS tidak dipungut biaya apapun.',
                'order_index' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana jika saya lupa password akun?',
                'answer' => 'Silakan hubungi Panitia PPDB melalui WhatsApp yang tertera di menu Bantuan, atau datang langsung ke sekretariat sekolah untuk reset password.',
                'order_index' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'Kapan pengumuman hasil seleksi?',
                'answer' => 'Pengumuman akan dipublikasikan secara online di website ini pada tanggal 5 Juli 2026. Siswa juga dapat melihat status kelulusan di dashboard masing-masing.',
                'order_index' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $f) {
            Faq::create($f);
        }
        $this->command->info('FAQs seeded successfully.');

        // --- 2. SEED SCHEDULES ---
        PpdbSchedule::query()->delete();
        $schedules = [
            [
                'activity' => 'Sosialisasi & Publikasi PPDB',
                'start_date' => '2026-05-01',
                'end_date' => '2026-05-31',
                'is_active' => true,
            ],
            [
                'activity' => 'Pendaftaran Jalur Afirmasi & Prestasi',
                'start_date' => '2026-06-15',
                'end_date' => '2026-06-18',
                'is_active' => true,
            ],
            [
                'activity' => 'Pendaftaran Jalur Zonasi & Perpindahan Tugas',
                'start_date' => '2026-06-22',
                'end_date' => '2026-06-26',
                'is_active' => true,
            ],
            [
                'activity' => 'Verifikasi Berkas oleh Panitia',
                'start_date' => '2026-06-22',
                'end_date' => '2026-06-30',
                'is_active' => true,
            ],
            [
                'activity' => 'Pengumuman Penetapan Peserta Didik Baru',
                'start_date' => '2026-07-05',
                'end_date' => '2026-07-05',
                'is_active' => true,
            ],
            [
                'activity' => 'Daftar Ulang',
                'start_date' => '2026-07-06',
                'end_date' => '2026-07-08',
                'is_active' => true,
            ],
            [
                'activity' => 'Masa Pengenalan Lingkungan Sekolah (MPLS)',
                'start_date' => '2026-07-13',
                'end_date' => '2026-07-15',
                'is_active' => true,
            ],
        ];

        foreach ($schedules as $s) {
            PpdbSchedule::create(array_merge($s, ['school_id' => $school->id]));
        }
        $this->command->info('Schedules seeded successfully.');

        // --- 3. SEED POSTS ---
        Post::query()->delete();
        $posts = [
            [
                'title' => 'Panduan Teknis Pendaftaran PPDB Online Tahun 2026',
                'slug' => 'panduan-teknis-ppdb-2026',
                'content' => "Penerimaan Peserta Didik Baru (PPDB) tahun ini dilaksanakan sepenuhnya secara daring (online). Berikut adalah langkah-langkah yang harus diperhatikan oleh calon peserta didik:\n\n1. Persiapkan berkas dalam format digital (JPG/PDF).\n2. Pastikan NISN aktif.\n3. Pantau jadwal pendaftaran agar tidak terlewat.\n\nSimak video tutorial lengkap di channel YouTube sekolah kami.",
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'author_id' => $authorId,
                'image' => null, // Placeholder will be used
            ],
            [
                'title' => 'Prestasi Membanggakan: Tim Futsal Raih Juara 1 Tingkat Kabupaten',
                'slug' => 'prestasi-futsal-juara-1',
                'content' => "Tim Futsal kebanggaan sekolah kembali menorehkan prestasi gemilang dengan menjuarai Turnamen Pelajar Cup 2025 yang diadakan di GOR Kabupaten pekan lalu. Kemenangan ini menjadi motivasi bagi seluruh siswa untuk terus mengembangkan bakat non-akademik.",
                'is_published' => true,
                'published_at' => now()->subWeeks(1),
                'author_id' => $authorId,
                'image' => null,
            ],
            [
                'title' => 'Fasilitas Baru: Laboratorium Komputer Multimedia',
                'slug' => 'fasilitas-baru-lab-komputer',
                'content' => "Untuk menunjang pembelajaran berbasis digital, sekolah telah meresmikan Laboratorium Komputer baru yang dilengkapi dengan 40 unit PC spesifikasi tinggi dan jaringan internet optik berkecepatan tinggi. Fasilitas ini siap digunakan untuk ANBK dan pembelajaran TIK.",
                'is_published' => true,
                'published_at' => now()->subWeeks(2),
                'author_id' => $authorId,
                'image' => null,
            ],
        ];

        foreach ($posts as $p) {
            Post::create($p);
        }
        $this->command->info('Posts seeded successfully.');
        
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
    }
}
