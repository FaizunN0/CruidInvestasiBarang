<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email'=>'super@local.test'],
            [
                'name'=>'Super Admin',
                'password'=>Hash::make('password123'),
                'role'=>'super'
            ]
        );

        // assign all permissions to super via pivot
        $all = Permission::pluck('id')->toArray();
        $user->permissions()->sync($all);
    }
}
