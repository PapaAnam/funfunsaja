<?php

use Illuminate\Database\Seeder;

class FeedbackKindTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('feedback_kinds')->insert([
    		[
    			"id" => 2,
    			"name" => "Saran & Kritik",
    			"url" => "/feedback/suggestions",
    			"created_at" => null,
    			"updated_at" => null
    		],
    		[
    			"id" => 3,
    			"name" => "Pertanyaan",
    			"url" => "/feedback/questions",
    			"created_at" => null,
    			"updated_at" => null
    		],
    		[
    			"id" => 4,
    			"name" => "Testimoni",
    			"url" => "/feedback/testimoni",
    			"created_at" => null,
    			"updated_at" => null
    		]
    	]);
    }
}
