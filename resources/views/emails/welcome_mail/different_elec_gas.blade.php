<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link href="https://fonts.googleapis.com/css?family=Muli:400,400i,600,700,800" rel="stylesheet"> 
</head>

<body>
<table width="700" border="0" cellspacing="0" cellpadding="0"  align="center" style="font-family: 'Muli', sans-serif;">
  <tbody>
    <tr>

      <td style="padding-bottom:10px; " width="50%">
          <img src="{{ asset('/uploads/email_template/logo-bulk.png') }}" width="244" height="81" alt=""/></td>
     <td align="right" style="font-size:16px; font-family: 'Muli', sans-serif; line-height:20px; font-weight:700; color:#2f3c3b;">Flick the switch! <br><span style="color:#e73534">Save on energy bills now.</span></td>
    </tr>
          <tr>
          <td colspan="2" style="font-size:30px; font-weight:bold; padding-top:30px;">
        <h2 style=" color:#2f3c3b; font-size:36px; margin:15px 0; font-family: 'Muli', sans-serif;  line-height:44px;  text-align:left; font-weight:800">Dear {{ $visitor['first_name'] }},</h2>
          </td>
          </tr>
          <tr>
          <td colspan="2" style="padding-bottom:20px; font-family: 'Muli', sans-serif; font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;" >
          <p>Thanks for choosing {{ $affiliate['legal_name'] }} to arrange your electricity connection with 
{{ $mail_content['electricity_provider_name'] }} and gas connection with {{ $mail_content['gas_provider_name'] }}.</p>


          </td>
          </tr>
          <tr>
          <td colspan="2" style="padding-bottom:30px; font-family: 'Muli', sans-serif; font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">
          Below are the details of your electricity and gas connections:
          </td>
          </tr>
          
          <tr>
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; font-family: 'Muli', sans-serif; border-right:1px solid #ccc;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">Name:</td>
          <td style="padding:10px; border-top:1px solid #cccc; font-family: 'Muli', sans-serif;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">{{ $visitor['first_name'].' '.$visitor['last_name'] }}</td>
          </tr>
          
          <tr>
			  
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; font-family: 'Muli', sans-serif; border-right:1px solid #ccc;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">Property Address:</td>
           <?php 
          $connection_address = json_decode($visitor['visitor_data']['moving_address']); 
          ?>
          <td style="padding:10px; border-top:1px solid #cccc; font-family: 'Muli', sans-serif; font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;"><?php if(isset($connection_address->connection_details) && !empty($connection_address->connection_details)) { echo $connection_address->connection_details;}?></td>
          </tr>
          
          <tr>
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; font-family: 'Muli', sans-serif; border-right:1px solid #ccc;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">Electricity Provider:</td>
          <td style="padding:10px; border-top:1px solid #cccc; font-family: 'Muli', sans-serif;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">{{ $mail_content['electricity_provider_name'] }}</td>
          </tr>
           <tr>
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; font-family: 'Muli', sans-serif; border-right:1px solid #ccc;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">Electricity Provider Phone Number:</td>
          <td style="padding:10px; border-top:1px solid #cccc; font-family: 'Muli', sans-serif;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">{{ $mail_content['electricity_phone_number'] }}</td>
          </tr>
          <tr>
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; font-family: 'Muli', sans-serif; border-right:1px solid #ccc;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">Electricity Reference Number:</td>
          <td style="padding:10px; border-top:1px solid #cccc;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">{{ $mail_content['electricity_ref_number'] }}</td>
          </tr>
           <tr>
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; border-right:1px solid #ccc;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">Electricity Plan Name:</td>
          <td style="padding:10px; border-top:1px solid #cccc; font-family: 'Muli', sans-serif;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">{{ $mail_content['electricity_name'] }}</td>
          </tr>
          <tr>
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; font-family: 'Muli', sans-serif; border-right:1px solid #ccc;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">Electricity Plan Tariff Details:</td>
          <td style="padding:10px; border-top:1px solid #cccc; font-family: 'Muli', sans-serif;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;"><a href="{{asset('/uploads/plan_document/'.$mail_content['electricity_plan_document']) }}" target="_blank">Plan detail</a></td>
          </tr>
          <tr>
		  <tr>
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; font-family: 'Muli', sans-serif; border-right:1px solid #ccc;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">Gas Provider:</td>
          <td style="padding:10px; border-top:1px solid #cccc; font-family: 'Muli', sans-serif;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">{{ $mail_content['gas_provider_name'] }}</td>
          </tr>
            <tr>
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; font-family: 'Muli', sans-serif; border-right:1px solid #ccc;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">Gas Provider Phone Number:</td>
          <td style="padding:10px; border-top:1px solid #cccc; font-family: 'Muli', sans-serif;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">{{ $mail_content['gas_phone_number'] }}</td>
          </tr>
           <tr>
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; font-family: 'Muli', sans-serif; border-right:1px solid #ccc;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">Gas Reference Number:</td>
          <td style="padding:10px; border-top:1px solid #cccc; font-family: 'Muli', sans-serif;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">{{ $mail_content['gas_ref_number'] }}</td>
          </tr>
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc;  font-family: 'Muli', sans-serif;border-right:1px solid #ccc;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">Gas Plan Name:</td>
          <td style="padding:10px; border-top:1px solid #cccc; font-family: 'Muli', sans-serif; font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">{{ $mail_content['gas_name'] }}</td>
          </tr>
          <tr>
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; font-family: 'Muli', sans-serif; border-right:1px solid #ccc;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">Gas Plan Tariff Details:</td>
          <td style="padding:10px; border-top:1px solid #cccc; font-family: 'Muli', sans-serif;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;"><a href="{{asset('/uploads/plan_document/'.$mail_content['gas_plan_document']) }}" target="_blank">Plan detail</a></td>
          </tr>
          <tr>
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; font-family: 'Muli', sans-serif; border-right:1px solid #ccc;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">
			 Provider Terms and Conditions
			 
			  </td>
          <td style="padding:10px; border-top:1px solid #cccc; font-family: 'Muli', sans-serif;font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">
              <a href="{{ url('/provider-term-conditions/'.$mail_content['electricity_id']) }}"> Terms and Conditions</a>
            </td>
          </tr>
          
          <tr>
          <td colspan="2" style="font-size:27px; text-align:left; font-family: 'Muli', sans-serif; font-weight:bold; padding-top:30px; color:#2f3c3b; padding-bottom:20px;">Please note the following important information:</td>
          </tr>
          <tr>
          
          <td style="font-size:16px; text-align:left;  font-family: 'Muli', sans-serif; padding-bottom:20px; color:#2f3c3b;" colspan="2" ><p style="width:100%; float:right; font-family: 'Muli', sans-serif; margin-top:0; font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">{{ $affiliate['legal_name'] }} will send your transfer request and details to {{ $mail_content['electricity_provider_name'] }} and {{ $mail_content['gas_provider_name'] }}. If your connection request is approved by {{ $mail_content['electricity_provider_name'] }} and {{ $mail_content['gas_provider_name'] }}, they will send a welcome pack including a price fact sheet to your postal
address or nominated email address.
</p></td>
          </tr>
          
          <tr>
          
          <td style="font-size:16px; text-align:left; font-family: 'Muli', sans-serif;  padding-bottom:20px; color:#2f3c3b;" colspan="2" ><p style="width:100%; float:right; margin-top:0; font-family: 'Muli', sans-serif; font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">Once your application has been approved, you have a 10 business day cooling-off period if
you change your mind. If you wish to cancel your connection request you will need to
contact {{ $mail_content['electricity_provider_name'] }} and {{ $mail_content['gas_provider_name'] }} directly on 
{{ $mail_content['electricity_phone_number'] }} and {{ $mail_content['gas_phone_number'] }} phone number respectively.
</p></td>
          </tr>
          
           <tr>
          
          <td style="font-size:16px; text-align:left; font-family: 'Muli', sans-serif;  padding-bottom:20px; color:#2f3c3b; font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;" colspan="2" ><p style="width:100%; float:right; margin-top:0;">If there are any issues with your application, {{ $mail_content['electricity_provider_name'] }} or {{ $mail_content['gas_provider_name'] }} may contact you directly.
</p></td>
          </tr>
          
           <tr>
          
          <td style="font-size:16px; text-align:left;  padding-bottom:20px; color:#2f3c3b;" colspan="2" ><p style="width:100%; float:right; margin-top:0; font-family: 'Muli', sans-serif; font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">Should you wish to change any details of your connection request or have any questions
about your connections you will need to contact {{ $mail_content['electricity_provider_name'] }} and {{ $mail_content['gas_provider_name'] }} directly on 
{{ $mail_content['electricity_phone_number'] }} and {{ $mail_content['gas_phone_number'] }}
respectively. Unfortunately, we
cannot change any details once your request has been sent.
</p></td>
          </tr>
          
          <tr>
          
          <td style="font-size:16px; text-align:left; font-family: 'Muli', sans-serif;  padding-bottom:20px; color:#2f3c3b;" colspan="2" ><p style="width:100%; float:right; font-family: 'Muli', sans-serif; margin-top:0; font-weight:bold"><strong>If you are transferring from another retailer</strong>
</p></td>
          </tr>
          
          <tr>
          
          <td style="font-size:16px; text-align:left;  padding-bottom:20px; color:#2f3c3b;" colspan="2" ><p style="width:100%; float:right; margin-top:0; font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">Once transferred your previous energy company will send you a final bill and from then on
your bill will come from {{ $mail_content['electricity_provider_name'] }} and {{ $mail_content['gas_provider_name'] }}.
</p></td>
          </tr>
           <tr>
          
          <td style="font-size:16px; text-align:left;  padding-bottom:20px; color:#2f3c3b;" colspan="2" ><p style="width:100%; float:right; margin-top:0; font-family: 'Muli', sans-serif; font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">Your account will be transferred on or before your next scheduled meter read. Depending
on where you are in the billing cycle this could take up to 4 months. Please note: If you have
a smart meter your new provider does not need to wait for your next scheduled meter read
to transfer your electricity account so this may happen much faster.
</p></td>
          </tr>
          
          <tr>
          
          <td style="font-size:16px; text-align:left;  padding-bottom:20px; color:#2f3c3b;;" colspan="2" ><p style="width:100%; float:right; margin-top:0; font-family: 'Muli', sans-serif; font-weight:bold"><strong>If you are moving property:</strong>
</p></td>
          </tr>
          
          <tr>
          
          <td style="font-size:16px; text-align:left;  padding-bottom:20px; color:#2f3c3b;" colspan="2" ><p style="width:100%; float:right; font-family: 'Muli', sans-serif; margin-top:0; font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">You need to ensure there is access to the meter and the main switch is turned off for {{ $mail_content['electricity_provider_name'] }} and {{ $mail_content['gas_provider_name'] }} to
connect your electricity &amp; gas on the specified day
</p></td>
          </tr>
          
          <tr>
          
          <td style="font-size:16px; text-align:left;  padding-bottom:20px; color:#2f3c3b;" colspan="2" ><p style="width:100%; float:right; margin-top:0; font-family: 'Muli', sans-serif; font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">It is your responsibility to tell your current supplier(s) that you are moving out of your current
property and that you would like the electricity &amp; gas to be disconnected.
</p></td>
          </tr>
          
          <tr>
          
          <td style="font-size:16px; text-align:left;  padding-bottom:20px; color:#2f3c3b;border-bottom:1px solid #CFCFCF;" colspan="2" ><p style="width:100%; font-family: 'Muli', sans-serif; float:right; margin-top:0; font-size:16px; font-weight:400; color:#2f3c3b; line-height:24px;">The new connection may be done any time up until midnight on the day of transfer. As such,
if you need the connection to be done early in the day, we recommend you speak to {{ $mail_content['electricity_provider_name'] }} and {{ $mail_content['gas_provider_name'] }}
about changing it to the day before
</p></td>
          </tr>
         <tr>
     <td style="background:#e73534; padding:15px 35px; " colspan="2">
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
      <td width="40%"><img src="{{ asset('/uploads/email_template/footer-logo.png') }}" width="175" height="58" alt="" style="border:0; "/></td>
      <td width="60%" align="right">
      	
				@if(isset($affiliate['facebook_url']) && $affiliate['facebook_url']!='')
        		<a href="{{$affiliate['facebook_url']}}"><img src="{{asset('/uploads/email_template/fb-icon.png')}}" width="26" height="26" alt="" style="border:0; margin:4px; "/></a>
        		@endif
        		 @if(isset($affiliate['twitter_url']) && $affiliate['twitter_url']!='')
                <a href="{{$affiliate['twitter_url']}}"><img src="{{ asset('/uploads/email_template/twitter-icon.png') }}" width="26" height="26" alt="" style="border:0; margin:4px; "/></a>
                @endif
                @if(isset($affiliate['youtube_url']) && $affiliate['youtube_url']!='')
                <a href="{{$affiliate['youtube_url']}}"><img src="{{ asset('/uploads/email_template/youtube-icon.png') }}" width="26" height="26" alt="" style="border:0; margin:4px; "/></a>
                @endif
        
      </td>
    </tr>
  </tbody>
 </table>

              </td>
            </tr>
     <tr>
            	<td style=" padding:10px 35px; " align="center" colspan="2">
               <a href="#" style="color:#2f3c3b; width:auto; margin:4px; padding:0; display:inline-block; font-family: 'Muli', sans-serif; font-size:12px; text-decoration:underline ">Contact Us</a>
               <a href="#" style="color:#2f3c3b; width:auto; margin:4px; padding:0; display:inline-block; font-family: 'Muli', sans-serif; font-size:12px; text-decoration:underline ">View as webpage</a>

                </td>
            </tr>  
  

         
     </tbody>
</table>
</body>
</html>
