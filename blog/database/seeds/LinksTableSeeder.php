<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'link_name' => '仪掌门',
                'link_title' => '团队上线项目',
                'link_url' => 'http://www.yizhangmeng.com',
                'link_order' => 1,
            ],
            [
                'link_name' => '个人博客',
                'link_title' => '解决技术的问题',
                'link_url' => 'http://www.blog.com',
                'link_order' => 2,
            ]
        ];
        DB::table('links')->insert($data);

    }
}
