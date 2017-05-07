<?php

use Illuminate\Database\Seeder;

class HtmlsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data[] = [ 
            'type' => 'guide', 
            'content' => '新手指引' 
        ];
        $data[] = [ 
            'type' => 'agreement', 
            'content' => '注册协议' 
        ];
        $data[] = [ 
            'type' => 'about_us', 
            'content' => '关于我们' 
        ];
        $data[] = [ 
            'type' => 'rule', 
            'content' => '幸运区规则' 
        ];
        
        $data[] = [ 
            'type' => 'balance_refer', 
            'content' => '现金余额说明' 
        ];
        $data[] = [ 
            'type' => 'register_rule', 
            'content' => '注册协议' 
        ];
        DB::table('htmls')->insert($data);
    }
}
