<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class GoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('merchants')->delete();
        DB::table('goods')->delete();
        DB::table('goods_attr')->delete();
        DB::table('goods_attr_category')->delete();
        DB::table('goods_rich_text')->delete();

        $merchant_id = DB::table('merchants')->insertGetId([
            'name' => '村头服装店',
            'image' => '/storage/test/goods/merchant.png',
            'mobile' => '18899999999',
            'province' => '山东省',
            'city' => '济南市',
            'district' => '历下区',
            'address' => '哪挨哪啊',
            'fare' => 2000
        ]);

        $category = DB::table('categorys')->where('name', '连衣裙')->first();

        // 普通商品
        for($i = 0; $i < 4; $i++) {

            $goods_id = DB::table('goods')->insertGetId([
                'merchant_id' => $merchant_id,
                'category_id' => $category->id,
                'name' => '服装' . $i,
                'image' => '/storage/test/goods/category_0_0_' . $i . '.png',
                'price' => '99',
                'old_price' => '998',
                'support_return' => rand(0, 1),
                'is_lucky' => 0,
                'recommend' => 1, 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('goods_rich_text')->insert([
                'goods_id' => $goods_id,
                'content' => '这是商品详情, hello gay'
            ]);

            $attrNames = ['颜色', '尺寸'];
            $propNames = ['attr1', 'attr2'];
            for ($j = 0; $j < 2; $j++) {
                $attr_cate_gory_id = DB::table('goods_attr_category')->insertGetId([
                    'merchant_id' => $merchant_id,
                    'goods_id' => $goods_id,
                    'name' => $attrNames[$j],
                    'attr_name' => $propNames[$j]
                ]);
            }

            $colors = ['红色', '绿色', '黄色', '紫色', '蓝色'];
            $sizes = ['S', 'M', 'L', 'XL', 'XXL'];
            for ($k = 0; $k < 5; $k ++) {
                DB::table('goods_attr')->insert([
                    'goods_id' => $goods_id,
                    'title' => '服装服装',
                    'price' => 100 + $i * 0.5,
                    'stock' => 100,
                    'attr1' => $colors[$k],
                    'attr2' => $sizes[$k],
                    'image' => '/storage/test/goods/category_0_0_' . $k . '.png'
                ]);
            }

            for ($m=0; $m < 3; $m++) {
                DB::table('images')->insert([
                    'imageable_type' => 'Entities\Goods',
                    'imageable_id' => $goods_id,
                    'image' => '/storage/test/goods/long' . $m . '.png'
                ]);
            } 

        }

        // 幸运区商品
        for($i = 0; $i < 4; $i++) {

            $goods_id = DB::table('goods')->insertGetId([
                'merchant_id' => $merchant_id,
                'category_id' => $category->id,
                'name' => '服装' . $i,
                'image' => '/storage/test/goods/category_0_0_' . $i . '.png',
                'price' => '99',
                'old_price' => '998',
                'support_return' => rand(0, 1),
                'is_lucky' => 1,
                'recommend' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('goods_rich_text')->insert([
                'goods_id' => $goods_id,
                'content' => '这是商品详情, hello gay'
            ]);

            $attrNames = ['颜色', '尺寸'];
            $propNames = ['attr1', 'attr2'];
            for ($j = 0; $j < 2; $j++) {
                $attr_cate_gory_id = DB::table('goods_attr_category')->insertGetId([
                    'merchant_id' => $merchant_id,
                    'goods_id' => $goods_id,
                    'name' => $attrNames[$j],
                    'attr_name' => $propNames[$j]
                ]);
            }

            $colors = ['红色', '绿色', '黄色', '紫色', '蓝色'];
            $sizes = ['S', 'M', 'L', 'XL', 'XXL'];
            for ($k = 0; $k < 5; $k ++) {
                DB::table('goods_attr')->insert([
                    'goods_id' => $goods_id,
                    'title' => '服装服装',
                    'price' => 100 + $k * 0.5,
                    'stock' => 100,
                    'attr1' => $colors[$k],
                    'attr2' => $sizes[$k],
                    'image' => '/storage/test/goods/category_0_0_' . $k . '.png'
                ]);
            }

            for ($m=0; $m < 3; $m++) {
                DB::table('images')->insert([
                    'imageable_type' => 'Entities\goods',
                    'imageable_id' => $goods_id,
                    'image' => '/storage/test/goods/long' . $m . '.png'
                ]);
            } 

        }
    }
}
