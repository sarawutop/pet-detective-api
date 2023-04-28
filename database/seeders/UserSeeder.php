<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'admin@example.com')->first();
        if (!$user) {
            $user = new User;
            $user->name = "Administrator Aad.";
            $user->role = 'admin';
            $user->email = 'admin@example.com';
            $user->password = Hash::make('adminpass');
            $user->save();
        }

        $user = User::where('email', 'user01@example.com')->first();
        if (!$user) {
            $user = new User;
            $user->name = "ยูสเซอร์ 01";
            $user->role = 'user';
            $user->email = 'user01@example.com';
            $user->password = Hash::make('userpass');
            $user->save();
        }

        $user = User::where('email', 'user02@example.com')->first();
        if (!$user) {
            $user = new User;
            $user->name = "ปราณี";
            $user->role = 'user';
            $user->email = 'user02@example.com';
            $user->password = Hash::make('userpass');
            $user->save();
        }

        $user = User::where('email', 'user03@example.com')->first();
        if (!$user) {
            $user = new User;
            $user->name = "มะลิ";
            $user->role = 'user';
            $user->email = 'user03@example.com';
            $user->password = Hash::make('userpass');
            $user->save();
        }

        $user = User::where('email', 'user04@example.com')->first();
        if (!$user) {
            $user = new User;
            $user->name = "แตง";
            $user->role = 'user';
            $user->email = 'user04@example.com';
            $user->password = Hash::make('userpass');
            $user->save();
        }

        $user = User::where('email', 'user05@example.com')->first();
        if (!$user) {
            $user = new User;
            $user->name = "ส้ม";
            $user->role = 'user';
            $user->email = 'user05@example.com';
            $user->password = Hash::make('userpass');
            $user->save();
        }
    }
}
