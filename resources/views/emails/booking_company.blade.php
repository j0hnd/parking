@extends('emails.templates.email_layout')

@section('greetings')
	<!-- 2 Even Columns : BEGIN -->
	<tr>
		<td valign="top" style="padding: 10px; background-color: #ffffff;">
			<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr>
					<!-- Column : BEGIN -->

					<td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
						<h1 style="margin: 0 0 10px; font-size: 20px; line-height: 30px; color: #333333; font-weight: normal;">Dear {{ ucwords($carpark->name) }}</h1>
						<p style="margin: 0 0 10px;">Heads up! A client booked your company.</p>
						{{--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut lectus erat, maximus et faucibus ut, pharetra in velit.</p>--}}
					</td>
					<!-- Column : END -->
					<!-- Column : BEGIN -->

				</tr>
			</table>
		</td>
	</tr>
	<!-- 2 Even Columns : END -->

@stop

@section('book-details')
	<!-- 2 Even Columns : BEGIN -->
	<tr>
		<td valign="top" style="padding: 10px; background-color: #ffffff;">
			<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr>
					<!-- Column : BEGIN -->
					<td class="stack-column-center" valign="top">
						<table role="presentation" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td style="padding: 10px; text-align: center">
									<img src="https://mytravelcompared.com/img/email-booking-details.jpg" width="270" height="60" alt="alt_text" border="0" class="fluid" style="height: auto; line-height: 15px;">
								</td>
							</tr>
							<tr>
								<td style="font-family: sans-serif; font-size: 12px; color: #555555;line-height: 20px; text-align: left;" class="center-on-narrow">
									<table class="" width="100" border="0">
										<tbody>
										<tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">Car Park:</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;" width="100">{{ $booking->order_title }}</td>
										</tr>
										<tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">Parking Price:</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;" width="156">£{{ $booking->price_value }}</td>
										</tr>
                                        <tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">No. of Passengers:</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">{{ $booking->booking_details->no_of_passengers_in_vehicle }}</td>
										</tr>
										<tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">Travelling with large baggage:</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">{{ $booking->booking_details->with_oversize_baggage == 1 ? 'Yes' : 'No' }}</td>
										</tr>
										<tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">Travelling with children or disabled person:</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">{{ $booking->booking_details->with_children_pwd == 1 ? 'Yes' : 'No' }}</td>
										</tr>
										{{-- <tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">Overall
												Cost:</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">£{{ $booking->price_value + $booking->booking_fees + $booking->sms_confirmation_fee + $booking->cancellation_waiver }}</td>
										</tr> --}}
										</tbody>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<!-- Column : END -->
					<!-- Column : BEGIN -->
					<td class="stack-column-center" valign="top">
						<table role="presentation" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td style="padding: 10px; text-align: center">
									<img src="https://mytravelcompared.com/img/email-client-details.jpg" width="270" height="60" alt="alt_text" border="0" class="fluid" style="height: auto; line-height: 15px;">
								</td>
							</tr>
							<tr>
								<td style="font-family: sans-serif; font-size: 12px; color: #555555;line-height: 20px; text-align: left;" class="center-on-narrow">
									<table class="" width="100" border="0">
										<tbody>
										<tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">Name:</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="100">{{ ucwords($customer->first_name) }} {{ ucwords($customer->last_name) }}</td>
										</tr>
										<tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">Contact Number:</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">{{ empty($customer->mobile_no) ? "N/A" : $customer->mobile_no }}</td>
										</tr>
										<!--<tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">Email:</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">{{ empty($customer->email) ? "N/A" : $customer->email }}</td>
										</tr>-->
										<tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">Vehicle Registration:</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">{{ empty($booking->car_registration_no) ? "N/A" : $booking->car_registration_no }}</td>
										</tr>
										<tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">Vehicle Make:</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">{{ empty($booking->vehicle_make) ? "N/A" : $booking->vehicle_make }}</td>
										</tr>
										<tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">Vehicle Model:</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">{{ empty($booking->vehicle_model) ? "N/A" : $booking->vehicle_model }}</td>
										</tr>
										<tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">Vehicle Color:</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">{{ empty($booking->vehicle_color) ? "N/A" : ucwords($booking->vehicle_color) }}</td>
										</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<!-- Column : END -->
				</tr>
			</table>
		</td>
	</tr>
	<!-- 2 Even Columns : END -->
@stop



@section('journey-details')
	<!-- 2 Even Columns : BEGIN -->
	<tr>
		<td valign="top" style="padding: 10px; background-color: #ffffff;">
			<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr>
					<!-- Column : BEGIN -->
					<td class="stack-column-center" valign="top">
						<table role="presentation" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td style="padding: 10px; text-align: center">
									<img src="https://mytravelcompared.com/img/email-client-journey.jpg" width="270" height="60" alt="alt_text" border="0" class="fluid" style="height: auto; line-height: 15px;">
								</td>
							</tr>
							<tr>
								<td style="font-family: sans-serif; font-size: 12px; color: #555555;line-height: 20px; text-align: left;" class="center-on-narrow">
									<table class="" width="100" border="0">
										<tbody>
										<tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top" width="100">Departure Date:</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">{{ $booking->drop_off_at->format('d M Y') }}</td>
										</tr>
										<tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top" width="100">Departure Time:</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">{{ $booking->drop_off_at->format('H:i') }}</td>
										</tr>
										<tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top" width="100">Arrival Date:</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">{{ $booking->return_at->format('d M Y') }}</td>
										</tr>
										<tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top" width="100">Arrival Time:</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">{{ $booking->return_at->format('H:i') }}</td>
										</tr>
										<tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top" width="100">Flight No. (Departure):</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">{{ $booking->flight_no_going }}</td>
										</tr>
										<tr>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top" width="100">Flight No. (Arrival):</td>
											<td width="8">&nbsp;</td>
											<td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">{{ $booking->flight_no_return }}</td>
										</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<!-- Column : END -->
					<!-- Column : BEGIN -->
					<td class="stack-column-center" valign="top">
						<table role="presentation" cellspacing="0" cellpadding="0" border="0">
							<!--<tr>
							<td style="padding: 10px; text-align: center">
									<img src="https://mytravelcompared.com/img/email-change-booking.jpg" width="270" height="60" alt="alt_text" border="0" class="fluid" style="height: auto; line-height: 15px;">

							 </td>
							</tr>
							<tr>
								<td style="font-family: sans-serif; font-size: 12px; color: #555555;line-height: 20px; text-align: left;" class="center-on-narrow">
								<a style="font-weight: bold; color: #28B2E0; text-decoration: underline; padding-left: 20px; margin-top: -40px;" href="#">Click here to change your booking.</a>
								<p style="padding-left: 20px; width: 90%;">	You can change your booking up to 48 hours prior to the date of departure through our https://mytravelcompared.com Members Area</p>
								</td>
							</tr>-->
						</table>
					</td>
					<!-- Column : END -->
				</tr>
			</table>
		</td>
	</tr>
	<!-- 2 Even Columns : END -->
@stop


@section('important-notice')


	<!-- 1 Column Text : BEGIN -->
	<tr>
		<td style="background-color: #ffffff;">
			<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr>
					<td style="padding: 10px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; background: red; font-weight: bold; color: white;">Important Information</td>
				</tr>
				<tr>
					<td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; background: #f2f2f2;">
						Mytravelcompared.com are agents for the featured car parks and customers will be contracting with the individual car park and will be subject to their terms and conditions which contain certain exemption clauses and limit each company`s liability.
						<br><br>
						Mytravelcompared.com's terms and conditions are available at <a href="https://www.mytravelcompared.com/uk/terms-and-conditions">https://www.mytravelcompared.com/uk/terms-and-conditions</a>
						<br><br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- 1 Column Text : END -->

@stop
