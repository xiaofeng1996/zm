<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SearchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $keywords = ['服装', '电脑', '手机', '鞋', '袜子'];
        foreach ($keywords as $keyword) {
            $datas[] = [
                'keyword' => $keyword,
                'keyword_count' => 1,
                'sort' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }
        DB::table('searches')->insert($datas);
    }
}
