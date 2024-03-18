<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Subscription;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Subscription::create([
            'email' => 'flaksie228@gmail.com',
            'confirmation_token' => 'LoWPvCIjx1jXMxQDLQGuVUrlALUn2pnVADSvIVDBgC6mWRhqeKb1hQAuduID3pGF',
            'confirmed' => true
        ]);
    }
}
