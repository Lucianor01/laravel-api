<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Generator as Faker;
use App\Models\Admin\Project;

use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //* CICLO CON FAKER
        for ($i = 0; $i < 10; $i++) {

            $new_Project = new Project();
            $new_Project->title = $faker->words(2, true);
            $new_Project->description = $faker->text(300);
            $new_Project->slug = Str::slug($new_Project->title, '-');
            $new_Project->price = $faker->randomFloat(2, 500, 5000);
            $new_Project->project_image = $faker->imageUrl(360, 360, 'Project', true);
            $new_Project->save();
        }
    }
}
