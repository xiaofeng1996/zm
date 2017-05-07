<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorys = [
            [
                'name' => '推荐',
                'children' => ['连衣裙', '口红', '开衫', '套头衫', '棒球衫', '鞋', '袜子'], 
            ],
            [
                'name' => '数码',
                'children' => ['电脑', '手机', '平板']
            ],
        ];

        DB::table('categorys')->delete();

        for($i = 0; $i < 2; $i++) {
            $name = $categorys[$i]['name'];
            $children = $categorys[$i]['children'];
            $id = DB::table('categorys')->insertGetId([
                'name' => $name,
                'sort' => $i,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);        
            foreach ($children as $key => $cName) {
                DB::table('categorys')->insert([
                    'parent_id' => $id,
                    'name' => $cName,
                    'image' => '/storage/test/category/category_' . $i . '_' . $key . '.png',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}