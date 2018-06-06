<?php

use Illuminate\Database\Seeder;
use App\Models\Customers;
use App\Models\Products;
use App\Models\Tools\Prices;
use App\Models\Tools\Fees;
use App\Models\Bookings;
use App\Models\BookingDetails;
use Carbon\Carbon;


class FakeBookings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
			$faker = Faker\Factory::create();

			$limit = 20;

			DB::beginTransaction();

			$vehicle_model = ['Toyota', 'Mitsubishi', 'Honda', 'Hyundai', 'Ford', 'BMW', 'Volkswagen', 'Chevrolet', 'Bentley', 'GMC', 'Audi', 'Mercedes Benz', 'Bugatti'];

			for ($i = 0; $i <= $limit; $i++) {

				$customer = Customers::active()->inRandomOrder()->first();
				$product = Products::active()->inRandomOrder()->first();
				$price = Prices::active()->where('product_id', $product->id)->inRandomOrder()->first();
				$revenue_share = $product->revenue_share;
				$sms_fee = Fees::active()->where('fee_name', 'sms_confirmation_fee')->select('amount')->first();
				$booking_fee = Fees::active()->where('fee_name', 'booking_fee')->select('amount')->first();
				$total_booking_cost = $price->price_value + $sms_fee->amount + $booking_fee->amount;
				$revenue_value = number_format($total_booking_cost * ($revenue_share / 100), 2);
				$airport_name = $product->airport[0]->airport_name;
				$category_name = $price->categories->category_name;

				$range1 = rand(3, 5);
				$range2 = rand(6, 10);

				$start= Carbon::now();
				$end = Carbon::now();

				$onoff = rand(0, 1);

				if ($onoff) {
					$start = $start->addDays($range1);
					$end = $end->addDays($range2);
				} else {
					$start = $start->subDays($range2);
					$end = $end->subDays($range1);
				}

				$vehicle_model_key = rand(0, 12);

				$booking = Bookings::select('id')->orderBy('id', 'desc')->first();
				if ($booking) {
					$id = $booking->id;
					$id++;
				} else {
					$id = 1;
				}

				$booking = Bookings::create([
					'booking_id' => Bookings::generate_booking_id($id),
					'customer_id' => $customer->id,
					'product_id' => $product->id,
					'price_id' => $price->id,
					'order_title' => "{$airport_name}-{$category_name}",
					'price_value' => $price->price_value,
					'revenue_value' => $revenue_value,
					'sms_confirmation_fee' => $sms_fee->amount,
					'booking_fees' => $booking_fee->amount,
					'drop_off_at' => $start->format('Y-m-d H:i:s'),
					'return_at' => $end->format('Y-m-d H:i:s'),
					'flight_no_going' => strtoupper(substr($faker->md5(), 0, 6)),
					'flight_no_return' => strtoupper(substr($faker->md5(), 0, 6)),
					'car_registration_no' => '',
					'vehicle_model' => $vehicle_model[$vehicle_model_key],
					'vehicle_color' => $faker->safeColorName(),
					'is_paid' => rand(0, 1),
					'paid_at' => $start->subDays(1)->format('Y-m-d H:i:s')
				]);

				if ($booking) {
					BookingDetails::create([
						'booking_id' => $booking->id,
						'no_of_passengers_in_vehicle' => rand(1, 5),
						'with_oversize_baggage' => $onoff,
						'with_children_pwd' => $onoff
					]);
				}
			}

			DB::commit();

			$this->command->info('Dummy booking has been created.');

		} catch (Exception $e) {
        	DB::rollback();
        	$this->command->error($e->getMessage());
		}
    }
}
