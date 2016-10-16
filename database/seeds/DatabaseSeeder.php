<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call('UserTableSeeder');
        $this->call('UserTableSeeder');

        Model::reguard();
    }
}

class UserTableSeeder extends Seeder
{
    public function run()
    {

        DB::table('users')->delete();

        $users = array(
                ['name' => 'Marimuthu', 'email' => 'marivaikunth@gmail.com@gmail.com', 'password' => Hash::make('secret')],
                ['name' => 'Yogesh', 'email' => 'myogesh10@gmail.com', 'password' => Hash::make('secret')],
                ['name' => 'Susmitha', 'email' => 'snsusmitha5@gmail.com', 'password' => Hash::make('secret')],
                ['name' => 'Brintha', 'email' => 'brinthamohanan17@gmail.com', 'password' => Hash::make('secret')],
        );
        foreach ($users as $user)
        {
            User::create($user);
        }

    }
}