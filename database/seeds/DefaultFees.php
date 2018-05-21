<?php

use Illuminate\Database\Seeder;
use App\Models\Tools\Fees;


class DefaultFees extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fees::truncate();

        $fees = [
        	['fee_name' => 'sms_confirmation_fee', 'amount' => '0.49'],
        	['fee_name' => 'cancellation_waiver', 'amount' => '1.99'],
        	['fee_name' => 'booking_fee', 'amount' => '1.95'],
		];

        foreach ($fees as $fee) {
			Fees::create($fee);
		}
    }
}
