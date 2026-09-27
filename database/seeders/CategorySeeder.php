<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Laptop', 'type' => 'perangkat'],
            ['name' => 'Komputer (PC)', 'type' => 'perangkat'],
            ['name' => 'Printer', 'type' => 'perangkat'],
            ['name' => 'Router', 'type' => 'perangkat'],
            ['name' => 'Switch', 'type' => 'perangkat'],
            ['name' => 'Server', 'type' => 'perangkat'],
            ['name' => 'Dokumen Jaringan', 'type' => 'berkas'],
            ['name' => 'Lisensi Software', 'type' => 'berkas'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
