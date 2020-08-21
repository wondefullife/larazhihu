<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class, 100)->make();
        $now = Carbon::now();
        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'password' => $user->password,
                'remember_token' => $user->remember_token,
                'created_at' => $now->toDateTimeString(),
                'updated_at' => $now->toDateTimeString(),
            ];
        }
        $data[0]['email'] = 'fansheng0594@163.com';
        User::insert($data);
    }
}
