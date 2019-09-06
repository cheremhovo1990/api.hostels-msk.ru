<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Organization\Lodge::class, function (Faker $faker) {
    $latitude = $faker->latitude(55.65, 55.85);
    $longitude = $faker->longitude(37.55, 37.65);
    $district = \App\Models\District::byLatitudeLongitude((float)$latitude, (float)$longitude)->first();
    $municipality = \App\Models\Municipality::byLatitudeLongitude((float)$latitude, (float)$longitude)->first();
    $organizations = \App\Models\Organization\Organization::get();

    return [
        'city_id' => \App\Models\City::where('name', 'Москва')->first()->id,
        'administrative_district_id' => $district->id,
        'municipality_id' => $municipality->id,
        'organization_id' => $organizations[mt_rand(0, count($organizations) - 1)],
        'announce' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'latitude' => $latitude,
        'longitude' => $longitude,
        'phone' => mt_rand(79000000000, 79999999999),
        'address' => $faker->address,
        'data' => [
            'source' => 'seed',
        ],
        'status' => \App\Models\Organization\Lodge::STATUS_ENABLE,
        'image_token' => uniqid('', true),
        'opening_hours' => 'Круглосуточно',
        'schema_org' => ['opening_hours' => []],
    ];
});
