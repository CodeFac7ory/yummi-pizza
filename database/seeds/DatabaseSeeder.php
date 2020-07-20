<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);


        DB::table('users')->insert([
            'id' => '1',
            'name' => 'Bosko',
            'email' => 'damjanovicb@gmail.com',
            'password' => '$2y$10$BKCOuBllQULBbDT/hx9Am.GG9G8278WpXm2PH3vsGD5gCNLTWz.1O',
            'street' => '221b Baker St',
            'postal_code' => 'NW1 6XE',
            'city' => 'London',
            'country' => 'United Kingdom',
            'password' => '$2y$10$BKCOuBllQULBbDT/hx9Am.GG9G8278WpXm2PH3vsGD5gCNLTWz.1O',
            'created_at' => '2020-07-19 08:39:50',
            'updated_at' => '2020-07-19 08:39:50',
        ]);

        DB::table('pizzas')->insert([
            'name' => 'Funghi Pizza',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
            'picture' => 'https://i0.wp.com/www.sugarlovespices.com/wp-content/uploads/2019/06/Pizza-Funghi-e-Salsiccia-Mushroom-and-Sausage-Pizza-feat.jpg?w=683&ssl=1',
            'price' => '799',
        ]);

        DB::table('pizzas')->insert([
            'name' => 'Pizza Quattro Formaggi',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
            'picture' => 'https://media-cdn.tripadvisor.com/media/photo-s/0f/c5/06/a6/pizza-quattro-formaggi.jpg',
            'price' => '899',
        ]);
    }
}
