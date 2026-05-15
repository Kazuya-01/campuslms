<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view dashboard',
            'manage users',
            'manage classes',
            'manage materials',
            'manage assignments',
            'manage quizzes',
            'manage forum',
            'manage attendance',
            'manage announcements',
            'manage grades',
            'manage certificates',
            'manage settings',
            'view audit logs',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $superAdmin = Role::create(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'view dashboard',
            'manage users',
            'manage classes',
            'manage announcements',
            'view audit logs',
        ]);

        $dosen = Role::create(['name' => 'dosen']);
        $dosen->givePermissionTo([
            'view dashboard',
            'manage classes',
            'manage materials',
            'manage assignments',
            'manage quizzes',
            'manage forum',
            'manage attendance',
            'manage grades',
        ]);

        $mahasiswa = Role::create(['name' => 'mahasiswa']);
        $mahasiswa->givePermissionTo([
            'view dashboard',
        ]);

        $superAdminUser = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@campuslms.test',
            'username' => 'superadmin',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);
        $superAdminUser->assignRole('super_admin');

        $dosenUser = User::create([
            'name' => 'Dr. Ahmad Fauzi',
            'email' => 'dosen@campuslms.test',
            'username' => 'ahmadfauzi',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);
        $dosenUser->assignRole('dosen');

        $mahasiswaUser = User::create([
            'name' => 'Budi Santoso',
            'email' => 'mahasiswa@campuslms.test',
            'username' => 'budisantoso',
            'nim' => '2024001',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);
        $mahasiswaUser->assignRole('mahasiswa');

        $mahasiswa2 = User::create([
            'name' => 'Siti Rahmawati',
            'email' => 'siti@campuslms.test',
            'username' => 'sitirahma',
            'nim' => '2024002',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);
        $mahasiswa2->assignRole('mahasiswa');
    }
}
