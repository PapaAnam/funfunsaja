<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // $this->call(ContentKindTableSeeder::class);
        $this->call(ContentTableSeeder::class);
        $this->call(PointsTableSeeder::class);
        $this->call(BankAccountSeederTable::class);
        $this->call(DepositsTableSeeder::class);
        $this->call(DepositClaimLogsTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        // $this->call(FeedbackKindTableSeeder::class);
        $this->call(FeedbacksTableSeeder::class);
        // $this->call(NotificationTableSeeder::class);
        // $this->call(ActivityTableSeeder::class);
        // $this->call(AdminsTableSeeder::class);
    }
}
