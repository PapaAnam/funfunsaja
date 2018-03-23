<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class PagesTableSeeder extends Seeder
{
    
    private $COUNT = 200;

    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	DB::table('pages')->truncate();
    	$faker = Factory::create('id_ID');
    	$data = [];
    	$pid = DB::table('page_kinds')->get()->pluck('id')->toArray();
    	$cid = DB::table('categories')->get()->pluck('id')->toArray();
    	foreach (range(1, $this->COUNT) as $i) {
    		$title = '';
    		foreach(range(1, $faker->numberBetween(2, 10)) as $a){
    			$title .= str_random($faker->numberBetween(5, 20))." ";
    		}
    		$content = '';
    		foreach(range(1, $faker->numberBetween(1, 10)) as $a){
    			$content .= $faker->text(1000)."<br> ";
    		}
    		$tags = '';
    		foreach(range(1, $faker->randomDigit) as $a){
    			$tags .= $faker->word.",";
    		}
    		$data[] = [
    			"title"          => $title,
    			"url"            => str_slug($title),
    			"page_kind_id"   => $faker->randomElement($pid),
    			"category_id"    => $faker->randomElement($cid),
    			"content"        => $content,
    			"thumbnail"      => 'public/',
    			"tags"           => $tags,
    			"created_at"     => $faker->dateTimeBetween('-3 years'),
    			"updated_at"     => $faker->dateTimeBetween('-3 years'),
    			"status"         => (String) $faker->randomElement(range(0,1)),
    			"hit"            => $faker->numberBetween(20, 2000),
    		];
    	}
    	foreach(collect($data)->chunk(100) as $d){
    		DB::table('pages')->insert($d->toArray());
    	}
    }
}
