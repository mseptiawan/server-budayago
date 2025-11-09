<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use \Illuminate\Database\Console\Seeds\WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil UsersTableSeeder
        $this->call([
            UsersTableSeeder::class,
        ]);

        // Jika mau, bisa tambah seeder lain, misal CultureSeeder
        // $this->call([
        //     UsersTableSeeder::class,
        //     CulturesTableSeeder::class,
        // ]);
    }
}
