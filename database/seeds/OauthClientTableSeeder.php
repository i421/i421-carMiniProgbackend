<?php

use Illuminate\Database\Seeder;
use App\Tables\OauthClient;

class OauthClientTableSeeder extends Seeder
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
		$client = [
			'id' => 1,
			'user_id' => 1,
			'name' => 'pheicloud',
			'secret' => 'P2h0e1i8c0l1o0u1d888aaaqsBVXTbV2wsBEm5cq',
			'redirect' => 'http://www.etonesystem.com',
			'personal_access_client' => false,
			'password_client' => true,
			'revoked' => false,
		];

		OauthClient::create($client);
    }
}
