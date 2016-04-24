<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Sam Hoang",
            'phone' => "01633460820",
            'email' => "samhv.ict@gmail.com",
            'password' => bcrypt("w8c8aaff"),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('users')->insert([
            'name' => "Son Dao",
            'phone' => "01633460820",
            'email' => "sondaoduy@gmail.com",
            'password' => bcrypt("w8c8aaff"),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        $faker = Faker::create();
        $faker->seed(time());
        foreach (range(1, 100) as $index) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'password' => bcrypt($faker->password(4, 60)),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]);
        }
    }
}
