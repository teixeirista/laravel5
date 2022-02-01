<?php

use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

$factory->define(App\Models\File::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text(50),
        'file' => UploadedFile::fake()->create('file.pdf')
    ];
});
