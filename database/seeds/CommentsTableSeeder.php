<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $goods = DB::table('goods')->whereNull('deleted_at')->get();
        $user = DB::table('users')->first();
        foreach ($goods as $g) {
            DB::table('comments')->insert([
                'user_id' => $user->id,
                'order_id' => 0,
                'goods_id' => $g->id,
                'star' => 4,
                'content' => '不错, 挺好的',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        foreach ($goods as $g) {
            DB::table('comments')->insert([
                'user_id' => $user->id,
                'order_id' => 0,
                'goods_id' => $g->id,
                'star' => 4,
                'content' => '不错, 挺好的',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        foreach ($goods as $g) {
            DB::table('comments')->insert([
                'user_id' => $user->id,
                'order_id' => 0,
                'goods_id' => $g->id,
                'star' => 4,
                'content' => '不错, 挺好的',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        foreach ($goods as $g) {
            DB::table('comments')->insert([
                'user_id' => $user->id,
                'order_id' => 0,
                'goods_id' => $g->id,
                'star' => 4,
                'content' => '不错, 挺好的',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
