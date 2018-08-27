@extends('emails.templates.email_layout')

@section('greetings')
	<!-- 2 Even Columns : BEGIN -->
	<tr>
		<td valign="top" style="padding: 10px; background-color: #ffffff;">
			<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr>
					<!-- Column : BEGIN -->

					<td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
						<h1 style="margin: 0 0 10px; font-size: 20px; line-height: 30px; color: #333333; font-weight: normal;">Dear {{ ucwords($first_name) }}</h1>
						<p style="margin: 0 0 10px;">This is your temporary password <strong>{{ $password }}</strong>, please insure to change this temporary password once you log in.</p>
						<br>
						<p style="margin: 0 0 10px;">You can login to your member's portal through this <a href="{{ url('/member/login') }}" style="color:blue;" target="_blank">link</a>.</p>
						<br>
						<p style="margin: 0 0 10px;">Thank you.</p>
					</td>
					<!-- Column : END -->
					<!-- Column : BEGIN -->

				</tr>
			</table>
		</td>
	</tr>
	<!-- 2 Even Columns : END -->

@stop
