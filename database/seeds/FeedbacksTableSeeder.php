<?php

use Illuminate\Database\Seeder;

class FeedbacksTableSeeder extends Seeder
{

    private $COUNT = 20; // per user
    private $CHUNK = 4;
    private $TABLE = 'feedbacks';

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table($this->TABLE)->truncate();
        $faker          = \Faker\Factory::create('id_ID');
        $users          = DB::table('users')->where('status', '1')->inRandomOrder()->get()->pluck('id')->toArray();
        $ck             = DB::table('feedback_kinds')->inRandomOrder()->get()->pluck('id')->toArray();
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
                $tags = [];
                foreach(range(1, $faker->randomDigit) as $a){
                    $tags[] = $faker->word;
                }
                $date       = $faker->dateTimeBetween('-1 years');
                $data[] = [
                    "title"              => $title,
                    "url"                => str_slug($title),
                    "feedback_kind_id"   => $faker->randomElement($ck),
                    "content"            => $content,
                    "thumbnail"          => 'path/to/thumbnail',
                    "tags"               => json_encode($tags),
                    "created_at"         => $date,
                    "updated_at"         => $date,
                    "user_id"            => $user,
                    "status"             => (String) $faker->randomElement(status()),
                    "hit"                => $faker->numberBetween(20, 10000),
                ];
            }
            foreach (array_chunk($data, $this->CHUNK) as $d) {
                DB::table($this->TABLE)->insert($d);
            }
        }
    }
}
