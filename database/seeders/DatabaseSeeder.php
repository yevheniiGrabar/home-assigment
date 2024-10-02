<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Employee;
use App\Models\Record;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::factory(2)->create();
        User::factory(2)->create();
        Employee::factory(20)->create();
        Category::factory(7)->create();
        Record::factory(20)->create();
    }
}
