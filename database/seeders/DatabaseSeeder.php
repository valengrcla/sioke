<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // DB::table('pengguna')->update([
        //     [
        //         'id_pengguna' => (string) Str::uuid(),
        //         'nama_pengguna' => "valen",
        //         'username' => 'vlnjelek',
        //         'password' => bcrypt('vlnjelek'),
        //         'user_img' => 'vlnjelek.png',
        //         'id_role' => '59ed58a9-06ce-471c-bb28-5e5ee5274276',
        //         'created_at' => now(),
        //     ],
        // ]);

        DB::table('pengguna')->where('id_pengguna', "d848af6c-f6da-49b3-b4e8-e34c2f23aba4")->update([
            'password' => bcrypt('bambangpass'),
            'updated_at' => now(),
        ]);
        
    }
}
