<?php

namespace Database\Seeders;

use App\Models\Kafedra;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SifatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name' => "Allamov Oybek",
            'email' => 'sifat@ubtuit.uz',
            'role' => 'sifat',
            'password' => Hash::make('sifat1234'),
        ]);
        $a=User::create([
            'name'=>"KI_mudir",
            'email'=>"ki_mudir@ubtuit.uz",
            'password'=>Hash::make('mudir123'),
            'role'=>'mudir'
        ]);
        Kafedra::create([
            'name'=>"Dasturiy injiniring",
            'user_id'=>1
        ]);
        Kafedra::create([
            'name'=>"Kompyuter injiniring",
            'user_id'=>$a->id
        ]);
    }
}
