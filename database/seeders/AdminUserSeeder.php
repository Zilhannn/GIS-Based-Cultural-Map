<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin 1
        $email1 = 'admin1@gmail.com';
        $password1 = 'admin1';

        $user1 = User::where('email', $email1)->first();

        if ($user1) {
            $user1->name = 'Administrator';
            $user1->password = $password1;
            $user1->is_admin = 1;
            $user1->save();
            $this->command->info("Updated existing admin user: {$email1}");
        } else {
            User::create([
                'name' => 'Administrator',
                'email' => $email1,
                'password' => $password1,
                'is_admin' => 1,
            ]);
            $this->command->info("Created admin user: {$email1}");
        }

        // Admin 2
        $email2 = 'admin2@gmail.com';
        $password2 = 'admin2';

        $user2 = User::where('email', $email2)->first();

        if ($user2) {
            $user2->name = 'Administrator 2';
            $user2->password = $password2;
            $user2->is_admin = 1;
            $user2->save();
            $this->command->info("Updated existing admin user: {$email2}");
        } else {
            User::create([
                'name' => 'Administrator 2',
                'email' => $email2,
                'password' => $password2,
                'is_admin' => 1,
            ]);
            $this->command->info("Created admin user: {$email2}");
        }
    }
}
