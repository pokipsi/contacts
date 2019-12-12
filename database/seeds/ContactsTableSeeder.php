<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	foreach (range(1,1000) as $index) {
	        DB::table('contacts')->insert([
            'avatar' => $faker->imageUrl($width = 100, $height = 100),
            'firstName' => $faker->firstName,
            'lastName' => $faker->lastName,
            'address' => $faker->streetAddress,
            'city' => $faker->city,
            'zip' => $faker->postcode,
            'country' => $faker->country,
            'email' => $faker->freeEmail,
            'phone' => $faker->phoneNumber,
            'note' => $faker->text($maxNbChars = 100),
            'group_id' => ($index % 3) + 1
	        ]);
	    }
    }
}
