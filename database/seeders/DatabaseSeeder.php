<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'Tu Dang';
        $user->email = 'tudangm10@gmail.com';
        $user->password = 'khongbiet111';
        $user->phone = '0347259766';
        $user->image = 'C:\xampp\htdocs\laravelversion1.com\public\avatars\1743066986_IMG_6776.JPG';
        $user->address = '62 Le Vinh Huy, Hoa Cuong Bac, Hai Chau, Da Nang';
        $user->save();    

        $this->call([
            UserSeeder::class
        ]);
    }
}
