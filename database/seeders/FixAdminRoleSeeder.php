<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class FixAdminRoleSeeder extends Seeder
{
    public function run()
    {
        // Ensure roles exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $panitiaRole = Role::firstOrCreate(['name' => 'panitia']);
        $siswaRole = Role::firstOrCreate(['name' => 'siswa']);

        // Find User ID 1 and assign admin role
        $user = User::find(1);
        if ($user) {
            $user->assignRole($adminRole);
            $this->command->info("Role 'admin' assigned to user ID 1 ({$user->name}).");
        } else {
            $this->command->error("User ID 1 not found.");
        }
    }
}
