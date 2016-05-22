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
            'name' => "Admin",
            'phone' => "666",
            'email' => "admin",
            'password' => bcrypt("admin"),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('users')->insert([
            'name' => "Son Dao",
            'phone' => "01633460820",
            'email' => "sondaoduy@gmail.com",
            'password' => bcrypt("test"),
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
                'password' => bcrypt(1111),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]);
        }
    }
}
