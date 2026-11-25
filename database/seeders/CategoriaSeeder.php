<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    // Crea las categorías de las peticiones (sin Faker, así también funciona en Docker)
    public function run(): void
    {
        $categorias = ['Sanidad', 'Educación', 'Medio ambiente', 'Animales', 'Justicia', 'Vivienda'];

        foreach ($categorias as $nombre) {
            Categoria::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
