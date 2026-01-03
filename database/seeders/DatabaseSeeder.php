<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'ardiansyahdzan@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Panitia PPDB',
            'email' => 'panitia@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'panitia',
        ]);

        User::factory()->create([
            'name' => 'Calon Siswa',
            'email' => 'siswa@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'siswa',
        ]);

        $this->call([
            TrackSeeder::class,
        ]);
    }
}
