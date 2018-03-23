<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class ContentTableSeeder extends Seeder
{

    private $COUNT = 10;

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('contents')->truncate();
        DB::table('bought_contents')->truncate();
        $faker          = Factory::create('id_ID');
        $users          = DB::table('users')->where('status', '1')->inRandomOrder()->get()->pluck('id')->toArray();
        $categories     = DB::table('categories')->inRandomOrder()->get()->pluck('id')->toArray();
        $ck             = DB::table('content_kinds')->inRandomOrder()->get()->pluck('id')->toArray();
        foreach ($users as $user) {
            $data = [];
            foreach (range(1, $this->COUNT) as $i) {
                $title = '';
                foreach(range(1, $faker->numberBetween(3, 10)) as $a){
                    $title .= str_random($faker->randomDigit).' ';
                }
                $content = '';
                foreach(range(1, $faker->numberBetween(1, 10)) as $a){
                    $content .= $faker->text(1000)."<br> ";
                }
                $tags = '';
                foreach(range(1, $faker->randomDigit) as $a){
                    $tags .= $faker->word.",";
                }
                $type       = $faker->randomElement(['0','1']);
                $is_free    = $type == '0';
                $date       = $faker->dateTimeBetween('-1 years');
                $data[] = [
                    "title"              => $title,
                    "url"                => str_slug($title),
                    "content_kind_id"    => $faker->randomElement($ck),
                    "category_id"        => $faker->randomElement($categories),
                    "content"            => $content,
                    "thumbnail"          => 'public/',
                    "tags"               => $tags,
                    "type"               => $type,
                    "created_at"         => $date,
                    "updated_at"         => $date,
                    "user_id"            => $user,
                    "status"             => (String) $faker->randomElement(range(1,4)),
                    "fee"                => $is_free ? 0 : round($faker->numberBetween(2000, 100000), -3),
                    "hit"                => $faker->numberBetween(20, 10000),
                ];
            }
            foreach (array_chunk($data, 4) as $d) {
                DB::table('contents')->insert($d);
            }
        }
    }
}
