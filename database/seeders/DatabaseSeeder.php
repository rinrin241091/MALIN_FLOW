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
        $user->image = 'https://chiemtaimobile.vn/images/companies/1/%E1%BA%A2nh%20Blog/avatar-facebook-dep/Hinh-dai-dien-hai-huoc-cam-dep-duoi-ai-do.jpg?1704789789335';
        $user->address = '62 Le Vinh Huy, Hoa Cuong Bac, Hai Chau, Da Nang';
        $user->save();    

        $this->call([
            UserSeeder::class
        ]);
    }
}
