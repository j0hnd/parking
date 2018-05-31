<p>
	Hi {{ $firstname }},<br/>
	Your booking has been confirmed and your reference number is <strong>{{ $booking_id }}</strong>.<br/>
	Here are your booking details;<br>
	<ul>
		<li>Parking: {{ $order }}</li>
		<li>Drop Off: {{ $drop_off }}</li>
		<li>Return On: {{ $return_at }}</li>
	</ul>
	<br>
	Should you wish to modify your booking details, you can email us at help@parkingapp.com.
</p>