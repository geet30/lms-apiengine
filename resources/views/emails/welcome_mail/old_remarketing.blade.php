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
          <img src="{{ asset('/uploads/affiliates_logo/logo.png') }}" alt=""/></td>
      <td style="text-align:right; color:#6B6B6B; font-size:30px; font-weight:bold;border-bottom:1px solid #CFCFCF; padding-bottom:10px;  width:50%"><span style="color:#e3710a">Call </span>{{ $data['affiliate']['ivr_number'] }}</td>
    </tr>
          <tr>
          <td colspan="2" style="padding-top:20px;  ">
            <img src="{{ asset('/uploads/affiliate_mail_banner/banner.jpg') }}" alt="" width="100%"  /></td>
          </tr>
          <tr>
          <td colspan="2" style="font-size:30px; font-weight:bold; padding-top:30px;">
          Hi {{ $data['first_name'].' '.$data['last_name'] }} ,
          </td>
          </tr>
          <tr>
		<?php
			if(isset($data['visitor_data']['full_address']) && !empty($data['visitor_data']['full_address'])){
				$state = explode(',',$data['visitor_data']['full_address']);
				$state = $state[1];
			}else{
				$state = 'Australia';
			}
		?>	
		
		<?php 
		$page_url = $data['affiliate']['page_url'].'/'.$hash;
		$visitor_id=Crypt::encrypt($data['visitor_data']['visitor_id']);
		?>  
          <td colspan="2" style="padding-bottom:20px;" >
          <p>Did you know only 1 in 5 Australian households review their energy and gas plan 
each year? Don’t be one of the households missing out on the potential
savings that could be available to you</p>
<p>Here are some great value energy deals available for {{ $state }}
households through {{ $page_url }} </p>
<p>Don't want to receive emails from us? <a href="<?php echo $data['affiliate']['page_url'].'/unsubscriber/'.$unsubscriber_id;?>">Unsubscriber</a></p>
          </td>
          </tr>
<!--
          </tr>
          @if(isset($plans['electricity']))
          @foreach($plans['electricity'] as $plan)
          <tr>
          <td colspan="2" style="padding-bottom:20px">
          <table style="border:1px solid #cccc; padding:10px;"  align="center">
          <tr>
          <td>
            <img src="{{ asset('/uploads/providers_logo/'.$plan['provider_image']) }}" alt="provider"/></td>
            <td style="text-align:right; font-size:25px; font-weight:bold">{{ $plan['name'] }}</td>
          </tr>
          <tr>
          <td colspan="2">
          <table cellpadding="0" cellspacing="0" width="100%">
          <tr>
          <td width="33%">
          <h2 style="width:100%; text-align:center; font-size:60px; color:#0038D1; margin-bottom:5px;" >{{ $plan['pay_day_discount_usage'] }}</h2>
          <span style="width:100%; text-align:center; font-size:18px; color:#0038D1; display:inline-block">{{ $plan['pay_day_discount_usage_desc'] }}</span>
          </td>
          <td width="33%">
          <h2 style="width:100%; text-align:center; font-size:60px; color:#0038D1; margin-bottom:5px;" >{{ $plan['gurrented_discount_usage'] }}</h2>
          <span style="width:100%; text-align:center; font-size:18px; color:#0038D1; display:inline-block">{{ $plan['gurrented_discount_usage_desc'] }}</span>
          </td>
          <td width="33%">
          <h2 style="width:100%; text-align:center; font-size:60px; color:#0038D1; margin-bottom:5px;" >{{ $plan['direct_debit_discount_usage'] }}</h2>
          <span style="width:100%; text-align:center; font-size:18px; color:#0038D1; display:inline-block">{{ $plan['direct_debit_discount_desc'] }}</span>
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
          @endforeach
         @endif
          @if(isset($plans['gas']))
          @foreach($plans['gas'] as $plan)
          <tr>
          <td colspan="2" style="padding-bottom:20px">
          <table style="border:1px solid #cccc; padding:10px;"  align="center">
          <tr>
          <td>
            <img src="detail_logo2.png" alt=""/></td>
            <td style="text-align:right; font-size:25px; font-weight:bold">{{ $plan['name'] }}</td>
          </tr>
          <tr>
          <td colspan="2">
          <table cellpadding="0" cellspacing="0" width="100%">
          <tr>
          <td width="33%">
          <h2 style="width:100%; text-align:center; font-size:60px; color:#0038D1; margin-bottom:5px;" >{{ $plan['pay_day_discount_usage'] }}</h2>
          <span style="width:100%; text-align:center; font-size:18px; color:#0038D1; display:inline-block">{{ $plan['pay_day_discount_usage_desc'] }}</span>
          </td>
          <td width="33%">
          <h2 style="width:100%; text-align:center; font-size:60px; color:#0038D1; margin-bottom:5px;" >{{ $plan['gurrented_discount'] }}</h2>
          <span style="width:100%; text-align:center; font-size:18px; color:#0038D1; display:inline-block">{{ $plan['gurrented_discount_desc'] }}</span>
          </td>
          <td width="33%">
          <h2 style="width:100%; text-align:center; font-size:60px; color:#0038D1; margin-bottom:5px;" >{{ $plan['direct_debit_discount'] }}</h2>
          <span style="width:100%; text-align:center; font-size:18px; color:#0038D1; display:inline-block">{{ $plan['direct_debit_discount_desc'] }}</span>
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
          @endforeach
         @endif
-->
         @if(isset($data['affiliate']['youtube_url']) ||isset($data['affiliate']['twitter_url']) || isset($data['affiliate']['facebook_url'] ))
         <tr>
          <td colspan="2" valign="middle" align="center" style="padding:10px; border-bottom:1px solid #cccc">
			  @if(isset($data['affiliate']['facebook_url']) && $data['affiliate']['facebook_url']!='')
				  <a target="_blank" href="{{ $data['affiliate']['facebook_url'] }}"><img src="{{ asset('/project/resources/views/emails/welcome_mail/1490369519_social-facebook.png') }}"  alt="facebook" /></a>
                @endif
                @if(isset($data['affiliate']['twitter_url']) && $data['affiliate']['twitter_url']!='')
                  <a target="_blank" href="{{ $data['affiliate']['twitter_url'] }}"><img src="{{ asset('/project/resources/views/emails/welcome_mail/1490369542_03-twitter.png') }}" alt="twitter"/></a>
                @endif
                @if(isset($data['affiliate']['youtube_url']) && $data['affiliate']['youtube_url']!='')
                 <a target="_blank" href="{{ $data['affiliate']['youtube_url'] }}"><img src="{{ asset('/project/resources/views/emails/welcome_mail/1490635624_18-youtube.png') }}"  alt="youtube"/></a>
                @endif
            </td>
          </tr>
          @endif
          <tr>
          <td colspan="2" style="padding-top:20px; padding-bottom:20px;">
          <table width="100%" cellpadding="0" cellspacing="0">
          <tr>
          <td style=" color:#ccc; font-size:13px;">
<a href="#" style="text-decoration:none; color:#969696">Unsubscribe |</a></td>
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
 <td style=" color:#ccc;font-size:13px;">
	 <?php $page_url = $data['affiliate']['page_url'].'/'.$hash; ?>
<a href="{{ $page_url }}" style="text-decoration:none; color:#969696">link</a></td>
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
