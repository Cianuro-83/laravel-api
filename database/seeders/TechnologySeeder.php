<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Technology;
use Illuminate\Support\Str;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $technologies=['CSS', 'JavaScript', 'PHP', 'VUE', 'SQL', 'LARAVEL', 'BOOTSTRAP', 'TAILWIND', 'SASS'];

        foreach ($technologies as $technology_name) {
            
            $new_technology = new Technology;
            $new_technology->name = $technology_name;
            $new_technology->slug = Str::slug($technology_name);

            $new_technology->save();
        }
    }
}