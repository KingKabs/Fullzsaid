<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Person;
use Faker\Factory as Faker;

class PersonsSeeder extends Seeder {

    public function run(): void {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {

            Person::create([
                'firstName' => $faker->firstName,
                'lastName' => $faker->lastName,
                'country' => $faker->country,
                'email' => $faker->unique()->safeEmail,
                'emailPass' => $faker->password(),
                'faUname' => $faker->userName,
                'faPass' => $faker->password(),
                'backupCode' => strtoupper($faker->bothify('????-####')),
                'securityQa' => $faker->sentence(3),
                'state' => $faker->state,
                'gender' => $faker->randomElement(['Male', 'Female']),
                'zip' => $faker->postcode,
                'dob' => $faker->date('Y-m-d', '2010-01-01'),
                'address' => $faker->address,
                'description' => $faker->sentence(10),
                'ssn' => $faker->ssn(),
                'cs' => $faker->randomElement(['A', 'B', 'C']), // or leave as placeholder
                'city' => $faker->city,
                'purchaseDate' => $faker->dateTimeBetween('-2 years', 'now'),
            ]);
        }
    }
}
