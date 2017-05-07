<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $goods = DB::table('goods')->first();
        if ($goods) {
            DB::table('banners')->insert([
                'keytype' => 1,
                'keyid' => $goods->id,
                'image' => '/storage/test/goods/long1.png',
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        DB::table('banners')->insert([
            'keytype' => 2,
            'keyid' => 0,
            'image' => '/storage/test/goods/long2.png',
            'link' => 'http://baidu.com',
            'active' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
