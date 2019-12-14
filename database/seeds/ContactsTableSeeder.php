<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
        DB::statement('ALTER TABLE contacts ENGINE = MyISAM');
        $faker = Faker::create();
    	foreach (range(1,10000) as $index) {
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
        DB::statement('ALTER TABLE contacts ENGINE = InnoDB');
        Schema::table('contacts', function (Blueprint $table) {
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');
        });
    }
}
