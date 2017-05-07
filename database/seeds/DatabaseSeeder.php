<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoryTableSeeder::class);
        $this->call(GoodsTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(BannersTableSeeder::class);
        $this->call(ConfigsTableSeeder::class);
        $this->call(BanksTableSeeder::class);
        $this->call(SearchesTableSeeder::class);
    }
}
