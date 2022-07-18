<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet"> 
</head>

<body>
<table width="700" border="0" cellspacing="0" cellpadding="0"  align="center" style="font-family:'Roboto', sans-serif;">
  <tbody>
    <tr>

      <td style="border-bottom:1px solid #CFCFCF; padding-bottom:10px; " width="50%">
          <img src="{{ asset('/uploads/profile_images/'.$affiliate['user']['photo']) }}" width="100px" alt="{{ $affiliate['company_name'] }}"/></td>
      <td style="text-align:right; color:#6B6B6B; font-size:30px; font-weight:bold;border-bottom:1px solid #CFCFCF; padding-bottom:10px;  width:50%"><img src="{{ asset('/uploads/providers_logo/'.$provider['logo']) }}" width="100" alt="Provider"/></td>
    </tr>
          <tr>
          <td colspan="2" style="padding-top:20px;  ">
            <img src="{{ asset('/uploads/affiliate_mail_banner/banner.jpg') }}" alt="" width="100%"  /></td>
          </tr>
          <tr>
          <td colspan="2" style="font-size:30px; font-weight:bold; padding-top:30px;">
        Dear {{ $visitor['first_name'].' '.$visitor['last_name'] }} ,
          </td>
          </tr>
          <tr>
          <td colspan="2" style="padding-bottom:20px;" >
          <p>Thanks for choosing {{ $affiliate['company_name'] }} to arrange your {{ $connection_type }} connection with 
{{ $provider['name'] }}.</p>


          </td>
          </tr>
          <tr>
          <td colspan="2" style="padding-bottom:30px;">
          Below are the details of your {{ $connection_type }} connection:
          </td>
          </tr>
          
          <tr>
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; border-right:1px solid #ccc">Name:</td>
          <td style="padding:10px; border-top:1px solid #cccc;">{{ $visitor['first_name'].' '.$visitor['last_name'] }}</td>
          </tr>
          <tr>
			  
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; border-right:1px solid #ccc">Property Address:</td>
          <?php 
          
          $connection_details = json_decode($visitor['visitor_data']['moving_address']); 
  

          ?>
          <td style="padding:10px; border-top:1px solid #cccc;"><?php if(!empty($connection_details->connection_details)) { echo $connection_details->connection_details;} ?></td>
          </tr>
          
          <tr>
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; border-right:1px solid #ccc">Provider:</td>
          <td style="padding:10px; border-top:1px solid #cccc;">{{ $provider['name'] }}</td>
          </tr>
           <tr>
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; border-right:1px solid #ccc">Provider Phone Number:</td>
          <td style="padding:10px; border-top:1px solid #cccc;">{{ $provider['phone'] }}</td>
          </tr>
           <tr>
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; border-right:1px solid #ccc">Electricity Plan Name:</td>
          <td style="padding:10px; border-top:1px solid #cccc;">{{ $plan['name'] }}</td>
          </tr>
          <tr>
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; border-right:1px solid #ccc">Plan Electricity Tariff Details:</td>
          <td style="padding:10px; border-top:1px solid #cccc;"><a href="{{asset('/uploads/plan_document/'.$plan['plan_document']) }}" target="_blank">Plan detail</a></td>
          </tr>
          <tr>
          <td style="padding:10px; font-weight:bold; border-top:1px solid #cccc; border-right:1px solid #ccc">
			  <a href="{{ url('/provider-term-conditions') }}"> Provider Important Documents:</a>
			 
			  </td>
          <td style="padding:10px; border-top:1px solid #cccc;">
<a href="#">{{ $provider['name'] }} Compliance Documents</a></td>
          </tr>
          
          <?php $i = 1; ?>
          @if(isset($other_plans) && count($other_plans)>0)
			  @foreach($other_plans as $plan)
			  <tr>
			  <td colspan="2" style="padding-bottom:20px; padding-top:30px;">
			  <table style="border:1px solid #cccc; padding:10px;"  align="center">
			  <tr>
			  <td>
				<img src="{{ asset('/uploads/providers_logo/'.$plan['provider_image']) }}" alt="provider"/ width="30px"></td>
				<td style="text-align:right; font-size:25px; font-weight:bold">{{ $plan['name'] }}</td>
			  </tr>
			  <tr>
			  <td colspan="2">
			  <table cellpadding="0" cellspacing="0" width="100%">
			  <tr>
			  <td width="33%" valign="top">
			  <h2 style="width:100%; text-align:center; font-size:60px; color:#0038D1; margin-bottom:5px;" >{{ $plan['rates'][0]['pay_day_discount_usage'] }}</h2>
			  <span style="width:100%; text-align:center; font-size:18px; color:#0038D1; display:inline-block">{{ $plan['rates'][0]['pay_day_discount_usage_desc'] }}</span>
			  </td>
			  <td width="33%" valign="top">
			  <h2 style="width:100%; text-align:center; font-size:60px; color:#0038D1; margin-bottom:5px;" >{{$plan['rates'][0]['direct_debit_discount_usage'] }}</h2>
			  <span style="width:100%; text-align:center; font-size:18px; color:#0038D1; display:inline-block">{{ $plan['rates'][0]['direct_debit_discount_desc'] }}</span>
			  </td>
			  <td width="33%" valign="top">
			  <h2 style="width:100%; text-align:center; font-size:60px; color:#0038D1; margin-bottom:5px;" >{{ $plan['rates'][0]['gurrented_discount_usage'] }}</h2>
			  <span style="width:100%; text-align:center; font-size:18px; color:#0038D1; display:inline-block">{{ $plan['rates'][0]['gurrented_discount_usage_desc'] }}</span>
			  </td>
			  </tr>
			  </table>
			  </td>
			  </tr>
			   <tr>
			  <td colspan="2" >
			  <p style="font-size:15px;">{{ $plan['features'] }}</p>
			  </td>
			  </tr>
			  </table>
			  </td>
			  </tr>
			  <?php 
			   if($i == 2){
				   break;
			   } 
			  $i++; 
			  ?>
			  
			  @endforeach
          @endif
          
          <tr>
          <td colspan="2" style="font-size:27px; text-align:center; font-weight:bold; padding-top:30px; color:#969696; padding-bottom:20px;">Please note the following important information:</td>
          </tr>
          <tr>
          
          <td style="font-size:16px; text-align:left;  padding-bottom:20px; color:#969696;" colspan="2" ><span  style="width:5%; float:left;"><img src="{{ asset('/project/resources/views/emails/welcome_mail/check.png') }}" alt=""/></span><p style="width:92%; float:right; margin-top:0;">{{ $affiliate['company_name'] }} will send your transfer request and details to {{ $provider['name'] }}. If your connection request is
approved by {{ $provider['name'] }} they will send a welcome pack including a price fact sheet to your postal
address or nominated email address.
</p></td>
          </tr>
          
          <tr>
          
          <td style="font-size:16px; text-align:left;  padding-bottom:20px; color:#969696;" colspan="2" ><span  style="width:5%; float:left;"><img src="{{ asset('/project/resources/views/emails/welcome_mail/check.png') }}" alt=""/></span><p style="width:92%; float:right; margin-top:0;">Once your application has been approved, you have a 10 business day cooling-off period if
you change your mind. If you wish to cancel your connection request you will need to
contact {{ $provider['name'] }} directly on 
{{ $provider['phone'] }}.
</p></td>
          </tr>
          
           <tr>
          
          <td style="font-size:16px; text-align:left;  padding-bottom:20px; color:#969696;" colspan="2" ><span  style="width:5%; float:left;"><img src="{{ asset('/project/resources/views/emails/welcome_mail/check.png') }}" alt=""/></span><p style="width:92%; float:right; margin-top:0;">If there are any issues with your application, {{ $provider['name'] }} may contact you directly.
</p></td>
          </tr>
          
           <tr>
          
          <td style="font-size:16px; text-align:left;  padding-bottom:20px; color:#969696;" colspan="2" ><span  style="width:5%; float:left;"><img src="{{ asset('/project/resources/views/emails/welcome_mail/check.png') }}" alt=""/></span><p style="width:92%; float:right; margin-top:0;">Should you wish to change any details of your connection request or have any questions
about your connections you will need to contact {{ $provider['name'] }} directly on 
{{ $provider['phone'] }}
. Unfortunately we
cannot change any details once your request has been sent.
</p></td>
          </tr>
          
          <tr>
          
          <td style="font-size:16px; text-align:left;  padding-bottom:20px; color:#969696;;" colspan="2" ><p style="width:100%; float:right; margin-top:0; font-weight:bold">If you are transferring from another retailer
</p></td>
          </tr>
          
          <tr>
          
          <td style="font-size:16px; text-align:left;  padding-bottom:20px; color:#969696;" colspan="2" ><span  style="width:5%; float:left;"><img src="{{ asset('/project/resources/views/emails/welcome_mail/check.png') }}" alt=""/></span><p style="width:92%; float:right; margin-top:0;">Once transferred your previous energy company will send you a final bill and from then on
your bill will come from {{ $provider['name'] }}.
</p></td>
          </tr>
           <tr>
          
          <td style="font-size:16px; text-align:left;  padding-bottom:20px; color:#969696;" colspan="2" ><span  style="width:5%; float:left;"><img src="{{ asset('/project/resources/views/emails/welcome_mail/check.png') }}" alt=""/></span><p style="width:92%; float:right; margin-top:0;">Your account will be transferred on or before your next scheduled meter read. Depending
on where you are in the billing cycle this could take up to 4 months. Please note: If you have
a smart meter your new provider does not need to wait for your next scheduled meter read
to transfer your electricity account so this may happen much faster
</p></td>
          </tr>
          
          <tr>
          
          <td style="font-size:16px; text-align:left;  padding-bottom:20px; color:#969696;;" colspan="2" ><p style="width:100%; float:right; margin-top:0; font-weight:bold">If you are moving property:
</p></td>
          </tr>
          
          <tr>
          
          <td style="font-size:16px; text-align:left;  padding-bottom:20px; color:#969696;" colspan="2" ><span  style="width:5%; float:left;"><img src="{{ asset('/project/resources/views/emails/welcome_mail/check.png') }}" alt="check"/></span><p style="width:92%; float:right; margin-top:0;">You need to ensure there is access to the meter and the main switch is turned off for {{ $provider['name'] }} to
connect your {{ $connection_type }} on the specified day
</p></td>
          </tr>
          
          <tr>
          
          <td style="font-size:16px; text-align:left;  padding-bottom:20px; color:#969696;" colspan="2" ><span  style="width:5%; float:left;"><img src="{{ asset('/project/resources/views/emails/welcome_mail/check.png') }}" alt=""/></span><p style="width:92%; float:right; margin-top:0;">It is your responsibility to tell your current supplier(s) that you are moving out of your current
property and that you would like the {{ $connection_type }} to be disconnected.
</p></td>
          </tr>
          
          <tr>
          
          <td style="font-size:16px; text-align:left;  padding-bottom:20px; color:#969696;border-bottom:1px solid #CFCFCF;" colspan="2" ><span  style="width:5%; float:left;"><img src="{{ asset('/project/resources/views/emails/welcome_mail/check.png') }}" alt=""/></span><p style="width:92%; float:right; margin-top:0;">The new connection may be done any time up until midnight on the day of transfer. As such,
if you need the connection to be done early in the day, we recommend you speak to {{ $provider['name'] }}
about changing it to the day before
</p></td>
          </tr>
          @if(isset($affiliate['youtube_url']) ||isset($affiliate['twitter_url']) || isset($affiliate['facebook_url'] ))
          <tr>
			<td colspan="2" valign="middle" align="center" style="padding:10px; border-bottom:1px solid #cccc">
				@if(isset($affiliate['facebook_url']) && $affiliate['facebook_url']!='')
				  <a target="_blank" href="{{ $affiliate['facebook_url'] }}"><img src="{{ asset('/project/resources/views/emails/welcome_mail/1490369519_social-facebook.png') }}"  alt="facebook" /></a>
                @endif
                @if(isset($affiliate['twitter_url']) && $affiliate['twitter_url']!='')
                  <a target="_blank" href="{{ $affiliate['twitter_url'] }}"><img src="{{ asset('/project/resources/views/emails/welcome_mail/1490369542_03-twitter.png') }}" alt="twitter"/></a>
                @endif
                @if(isset($affiliate['youtube_url']) && $affiliate['youtube_url']!='')
                 <a target="_blank" href="{{ $affiliate['youtube_url'] }}"><img src="{{ asset('/project/resources/views/emails/welcome_mail/1490635624_18-youtube.png') }}"  alt="youtube"/></a>
                @endif
            </td>
          </tr>
          @endif
          <tr>
          <td colspan="2" style="padding-top:20px; padding-bottom:20px;">
          <table width="100%" cellpadding="0" cellspacing="0">
          <tr>
          
 <td style=" color:#ccc;font-size:13px;">
<a href="#" style="text-decoration:none; color:#969696">Privacy policy |</a></td>
          <td style=" color:#ccc;font-size:13px;">
<a href="#" style="text-decoration:none; color:#969696">Disclaimer |</a></td>
 <td style=" color:#ccc;font-size:13px;">
<a href="{{ url('/provider-term-conditions') }}" style="text-decoration:none; color:#969696">Terms and conditions |</a></td>
 <td style=" color:#ccc;font-size:13px;">
<a href="#" style="text-decoration:none; color:#969696">Contact us |</a></td>
 <td style=" color:#ccc;font-size:13px;">
<a href="#" style="text-decoration:none; color:#969696">View as webpage |</a></td>
          </tr>
          </table>
          </td>
          </tr>
          
          <tr>
          <td colspan="2" align="center"><img src="{ asset('/uploads/affiliates_logo/logo.png') }}" width="70" alt=""/></td>
          </tr>
         
     </tbody>
</table>


</body>
</html>
