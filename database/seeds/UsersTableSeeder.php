<?php

use Illuminate\Database\Seeder;
use App\Tables as TablesModels;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {

            DB::beginTransaction();
            $this->_createTableData();
            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            \Log::info('[dbSeed Exception]: ' . $e);

        }
    }

    /**
     * Create data of table
     */
    private function _createTableData()
    {
        $list = [
            [
                'nickname' => 'waiterx' . str_random(11),
                'name' => 'waiterx',
                'email' => 'shenjc@pheicloud.com',
                'phone' => '13738283483',
                'password' => bcrypt('waiterx'),
                'remember_token' => str_random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'nickname' => 'root' . str_random(16),
                'name' => 'root',
                'email' => 'root@etonesystem.com',
                'phone' => '13700000000',
                'password' => bcrypt('etone'),
                'remember_token' => str_random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        TablesModels\User::insert($list);

        for ($i = 1; $i < 3; $i++) {
            $user = TablesModels\User::find($i);
            $user->roles()->attach($i, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
