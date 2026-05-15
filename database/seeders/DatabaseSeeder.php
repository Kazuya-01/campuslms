<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            ClassSeeder::class,
            ContentSeeder::class,
            InteractionSeeder::class,
            AssessmentSeeder::class,
        ]);
    }
}
