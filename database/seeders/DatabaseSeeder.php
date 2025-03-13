<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Client;
use App\Models\ComplianceType;
use App\Models\LeaveStatus;
use App\Models\LeaveType;
use App\Models\Site;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        if(User::all()->count() > 0) {
            User::factory(1)->create();

        }
        else{
            User::factory()->create([
                'name' => "Mehedi hasan",
                'email' => "mehedihasanmondol.online@gmail.com",
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10),
                'mobile' => '01779282747',
                'status' => 'active',
            ]);

        }

        Client::factory(3)->create();
        Bank::factory(3)->create();
        ComplianceType::factory(3)->create();
        LeaveStatus::factory(3)->create();
        LeaveType::factory(3)->create();
        Site::factory(3)->create();
    }
}
