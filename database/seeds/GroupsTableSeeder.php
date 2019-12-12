<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $groupNames = ['Family', 'Friends', 'Business'];

        foreach ($groupNames as $name) {
            DB::table('groups')->insert([
                'name' => $name
            ]);    
        }
        
    }
}
