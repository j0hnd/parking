@extends('emails.templates.email_layout')

@section('greetings')
          <!-- 2 Even Columns : BEGIN -->
 <tr>
	            <td valign="top" style="padding: 10px; background-color: #ffffff;">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
	                    <tr>
	                        <!-- Column : BEGIN -->
	                     
                            <td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                                <h1 style="margin: 0 0 10px; font-size: 20px; line-height: 30px; color: #333333; font-weight: normal;">Dear Name</h1>
                                <p style="margin: 0 0 10px;">Thank you for booking "Company Name" with My Travel Compared.</p>
                            </td>
	                        <!-- Column : END -->
	                        <!-- Column : BEGIN -->
	             
                            <td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                                <p style="margin: 0 0 10px;">Please download our app to view your booking.</p>
                                <a class="button-a button-a-primary" href="https://google.com/" style="background: #222222; border: 1px solid #000000; font-family: sans-serif; font-size: 15px; line-height: 15px; text-decoration: none; padding: 13px 17px; color: #ffffff; display: block; border-radius: 4px;">Download App Now!</a>
	                        </td>
	                        <!-- Column : END -->
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
	                        <td class="stack-column-center">
	                            <table role="presentation" cellspacing="0" cellpadding="0" border="0">
	                                <tr>
                                    <td style="padding: 10px; text-align: center">
	                                        <img src="{{ asset('/img/email-booking-details.jpg') }}" width="270" height="60" alt="alt_text" border="0" class="fluid" style="height: auto; line-height: 15px;">
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
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;" width="100">Gatwick
                                                      ABC Meet and Greet</td>
                                                  </tr>
                                                  <tr>
                                                    <td width="8">&nbsp;</td>
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">Parking Price:</td>
                                                    <td width="8">&nbsp;</td>
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;" width="156">£43.00</td>
                                                  </tr>
                                                  <tr>
                                                    <td width="8">&nbsp;</td>
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">Booking Fee:</td>
                                                    <td width="8">&nbsp;</td>
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">£1.95</td>
                                                  </tr>
                                                  <tr>
                                                    <td width="8">&nbsp;</td>
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">Overall
                                                      Cost:</td>
                                                    <td width="8">&nbsp;</td>
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">£44.95</td>
                                                  </tr>
                                                </tbody>
                                              </table>
	                                    </td>
	                                </tr>
	                            </table>
	                        </td>
	                        <!-- Column : END -->
	                        <!-- Column : BEGIN -->
	                        <td class="stack-column-center">
	                            <table role="presentation" cellspacing="0" cellpadding="0" border="0">
	                                <tr>
                                    <td style="padding: 10px; text-align: center">
	                                        <img src="{{ asset('/img/email-your-details.jpg') }}" width="270" height="60" alt="alt_text" border="0" class="fluid" style="height: auto; line-height: 15px;">
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
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="100">John Doe</td>
                                                  </tr>
                                                  <tr>
                                                    <td width="8">&nbsp;</td>
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">Contact Number:</td>
                                                    <td width="8">&nbsp;</td>
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">+449268632194</td>
                                                  </tr>
                                                  <tr>
                                                    <td width="8">&nbsp;</td>
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">Email:</td>
                                                    <td width="8">&nbsp;</td>
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">john.doe@email.com</td>
                                                  </tr>
                                                  <tr>
                                                    <td width="8">&nbsp;</td>
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;font-weight: bold" width="100">Vehicle Registration:</td>
                                                    <td width="8">&nbsp;</td>
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">YT04VEF</td>
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
	                                        <img src="{{ asset('/img/email-your-journey.jpg') }}" width="270" height="60" alt="alt_text" border="0" class="fluid" style="height: auto; line-height: 15px;">
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td style="font-family: sans-serif; font-size: 12px; color: #555555;line-height: 20px; text-align: left;" class="center-on-narrow">
                                        <table class="" width="100" border="0">
                                                <tbody>
                                                  <tr>
                                                    <td width="8">&nbsp;</td>
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top;" width="100">Location:</td>
                                                    <td width="8">&nbsp;</td>
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="100">Wonderland</td>
                                                  </tr>
                                                  <tr>
                                                    <td width="8">&nbsp;</td>
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top" width="100">Drop Off Date:</td>
                                                    <td width="8">&nbsp;</td>
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">10 Jan 2018 12:00</td>
                                                  </tr>
                                                  <tr>
                                                    <td width="8">&nbsp;</td>
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333;padding-top:2px;vertical-align:top" width="100">Return Date:</td>
                                                    <td width="8">&nbsp;</td>
                                                    <td style="font-family:Arial,Helvetica,sans-serif;text-align:left;font-size:12px;color:#333333" width="156">16 Jan 2018 12:00</td>
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
	                                <tr>
                                    <td style="padding: 10px; text-align: center">
	                                        <img src="{{ asset('/img/email-change-booking.jpg') }}" width="270" height="60" alt="alt_text" border="0" class="fluid" style="height: auto; line-height: 15px;">
                                            
	                                 </td>
	                                </tr>
	                                <tr>
	                                    <td style="font-family: sans-serif; font-size: 12px; color: #555555;line-height: 20px; text-align: left;" class="center-on-narrow">
                                        <a style="font-weight: bold; color: #28B2E0; text-decoration: underline; padding-left: 20px; margin-top: -40px;" href="#">Click here to change your booking.</a>
                                        <p style="padding-left: 20px; width: 90%;">	You can change your booking up to 48 hours prior to the date of departure through our https://mytravelcompared.com Members Area</p>
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
                            <b>Car Park Contact Number:</b> The chauffeur number is <b>05532 584120</b>
                            <br><br>
                            mytravelcompared.com are agents for the featured car parks and customers will be contracting with the individual car park and will be subject to their terms and conditions which contain certain exemption clauses and limit each company`s liability.
                            <br><br>
                            Mytravelcompared.com's terms and conditions are available at <a href="https://www.mytravelcompared.com/uk/terms-and-conditions">https://www.mytravelcompared.com/uk/terms-and-conditions</a>
                            <br><br>
                            Your keys will stay with the car park whilst you are away.
	                        </td>
	                    </tr>
	                </table>
	            </td>
	        </tr>
	        <!-- 1 Column Text : END -->

@stop


@section('direction-notice')
<br>
<!-- 1 Column Text : BEGIN -->
<tr>
	            <td style="background-color: #ffffff;">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                        <td style="padding: 10px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; background: red; font-weight: bold; color: white;">Directions</td>
                        </tr>
	                    <tr>
	                        <td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; background: #f2f2f2;">
                            <b>Sat Nav</b>
                            <p>Gatwick (LGW) South Terminal Departure – Postcode RH6 0NP</p>
                            <hr>
                            <p>Gatwick is 28 miles (45km) south of London, linked directly to the M23 at Junction 9 and to the A23 London-Brighton road.</p>
                            <br>
                            <b>Additional Information:</b>
                            <p>Please take a copy of your confirmation details by print make sure you can access the details via electronic device.</p>
                            <br>
                            <b>Warning:</b>
                            <p>Please ensure your car has tyre tread on each tyre that is within the legal limit, or is in any other way unsafe to drive, the driver will not be able to take your car and you will have to make other arrangements to park your car.  Your contract will be deemed to have started and you will not be able to claim a refund. Please also ensure that your vehicle has water in the washer bottle and that you have not run your fuel down to the minimum as although our car park is close to the airport we will have to drive your car off the airport itself.</p>
	                        </td>
	                    </tr>
	                </table>
	            </td>
	        </tr>
	        <!-- 1 Column Text : END -->

@stop

@section('what-to-do-notice')
<br>
<!-- 1 Column Text : BEGIN -->
<tr>
	            <td style="background-color: #ffffff;">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                        <td style="padding: 10px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; background: red; font-weight: bold; color: white;">What to do on Arrival/Return</td>
                        </tr>
	                    <tr>
	                        <td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; background: #f2f2f2;">
                            <b>On Arrival</b>
                            <p>Please call 07716 063 663 when you are 10 minutes from the airport for example the M25/M23 junction.</p>
                            <p>Please follow the signs to your terminal and then follow the signs to PASSENGER DROP OFF where you should park on the forecourt.</p>
                            <p>North Terminal – PLEASE NOTE – you must park in the right lane of the PASSENGER DROP OFF zone, between the Sofitel Hotel and the central reservation. We will find you.</p>
                            <hr>
                            <b>On Return</b>
                            <p>Please call 07716 063 663 only when you have collected ALL of your luggage. Your car will be returned to the area where you dropped it off.</p>
                            <p>You will be given a returns card at departure that will act as a receipt for your vehicle and also has maps to get you from the terminal back to the passenger drop off area.</p>
                            <p>Please note if you have hand luggage only please call as soon as you can.</p>
	                        </td>
	                    </tr>
	                </table>
	            </td>
	        </tr>
	        <!-- 1 Column Text : END -->

@stop