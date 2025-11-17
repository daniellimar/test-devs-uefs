<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run()
    {
        $tags = [
            'Tecnologia',
            'Educação',
            'Saúde',
            'Design',
            'Negócios',
        ];

        foreach ($tags as $name) {
            $id = Str::Uuid();;
            Tag::firstOrCreate(['id' => $id, 'name' => $name]);
        }
    }
}
