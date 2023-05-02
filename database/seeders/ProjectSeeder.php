<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $type_ids = Type::all()->pluck('id')->all();
        $technology_ids = Technology::all()->pluck('id')->all();

        for ($i = 0; $i < 10; $i++){
            $project = new Project();
            $project->title = $faker->unique()->sentence($faker->numberBetween(2, 3));
            $project->customer = $faker->name();
            $project->description = $faker->optional()->text(2500);
            $project->url = $faker->optional()->url();
            $project->slug = Str::slug($project->title, '-');
            $project->type_id = $faker->optional()->randomElement($type_ids);
            $project->save();

            $project->technologies()->attach($faker->randomElements($technology_ids, rand(0,3)));

        }
    }
}