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
            'name' => 'Quattro Formaggi',
            'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit',
            'picture' => 'https://media-cdn.tripadvisor.com/media/photo-s/0f/c5/06/a6/pizza-quattro-formaggi.jpg',
            'price' => '899',
        ]);
        DB::table('pizzas')->insert([
            'name' => 'Napoletana',
            'description' => 'Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?',
            'picture' => 'https://upload.wikimedia.org/wikipedia/commons/a/a3/Eq_it-na_pizza-margherita_sep2005_sml.jpg',
            'price' => '999',
        ]);

        DB::table('pizzas')->insert([
            'name' => 'Margherita',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
            'picture' => 'https://www.najboljeizitalije.rs/ast_mslu/files/margarita.jpg',
            'price' => '699',
        ]);

        DB::table('pizzas')->insert([
            'name' => 'Prosciutto e Funghi',
            'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit',
            'picture' => 'https://i0.wp.com/www.piccolericette.net/piccolericette/wp-content/uploads/2019/10/4102_Pizza.jpg?resize=895%2C616&ssl=1',
            'price' => '1099',
        ]);
        DB::table('pizzas')->insert([
            'name' => 'Quattro Stagioni',
            'description' => 'Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?',
            'picture' => 'https://assets.wsimgs.com/wsimgs/rk/images/dp/recipe/201943/0070/img97l.jpg',
            'price' => '1199',
        ]);
        DB::table('pizzas')->insert([
            'name' => 'Diavola',
            'description' => 'Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?',
            'picture' => 'https://i1.wp.com/www.piccolericette.net/piccolericette/wp-content/uploads/2017/06/3236_Pizza.jpg?resize=895%2C616&ssl=1',
            'price' => '1150',
        ]);
    }
}
