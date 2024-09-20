<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Genre;
use App\Models\Book;
use App\Models\Loan;



// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

       // Genre::factory(10)->create();
       // Book::factory(50)->create();

       Loan::factory(20)->create();

    }
}
