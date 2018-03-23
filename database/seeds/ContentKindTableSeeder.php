<?php

use Illuminate\Database\Seeder;

class ContentKindTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(DB::table('content_kinds')->get() as $d){
        	DB::table('content_kinds')->where('id', $d->id)->update([
        		'url' => str_slug($d->name)
        	]);
        }
    }
}
