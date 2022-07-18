<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>email</title>
<link href="https://fonts.googleapis.com/css?family=Muli:400,400i,600,700,800" rel="stylesheet">
<style type="text/css">
body{font-family: 'Muli', sans-serif; font-size:14px;}
p{margin:0;}
</style>
</head>

<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family: 'Muli', sans-serif; background:#fff;" align="center">
  <tbody>
    <tr>
      <td>
      	<!-- content main table start -->
        <table width="650" border="0" cellspacing="0" cellpadding="0"  align="center">
        <tbody>
            <tr>
            <td style="padding:0 15px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr>
                        <td><img src="{{ asset('/uploads/email_template/logo-bulk.png') }}" width="244" height="81" alt=""/></td>
                        <td align="right" style="font-size:16px; font-family: 'Muli', sans-serif; line-height:20px; font-weight:700; color:#2f3c3b;">Flick the switch! <br><span style="color:#e73534">Save on energy bills now.</span></td>
                    </tr>
                </tbody>
                </table>

            </td>
            </tr>
             <!-- template include-->
              @include('emails.welcome_mail.'.$mail_data['template'],['mail_data'=>$mail_data,'template_image'=>$template_image]) 
             <?php
             if($plan_records->count()!=0)
             {
				$termination_fee='NO';
				$discount=0;
				$discount_title=""; 
				$view_discount=""; 
				$terms_condition="";  
				$month_benifit_period="";
			    $array_replace['affiliate_name']=$mail_data['affiliate_name'];
			foreach($plan_records as $plan_key=>$plan_data)
			{
				 $array_replace['provider_name']=$plan_data->provider->name;
				 $array_replace['provider_phone']=$plan_data->provider->phone;
				 $array_replace['provider_address']=$plan_data->provider->address;
				 $array_replace['provider_email']=$plan_data->provider->email;
				 $termination_fee=$plan_data->termination_fee;
				 $discount= $plan_data->discount;
				 $discount_title=$plan_data->discount_title;
				 $month_benfit_period=$plan_data->month_benfit_period;
				 $terms_condition=str_replace($attributes,$array_replace,$plan_data->remarketing_terms_conditions);
		   ?>
          <tr>
            	<td style="padding:10px 20px 35px;">
                	<table style="border:1px solid #d3dbdd;  border-radius:8px; box-shadow:2px 2px 10px rgba(0, 0, 0, 0.2)" align="center">
          <tbody><tr>
            <td style="border-bottom:1px solid #d3dbdd; font-family: 'Muli', sans-serif; padding:10px 10px 10px 35px" width="35%"><img src="{{asset($plan_data->provider->logo)}}" width="140" alt=""></td>
            <td  width="65%" style="text-align:left; font-size:18px; font-family: 'Muli', sans-serif; border-bottom:1px solid #d3dbdd; padding:10px 35px 10px 10px; font-weight:bold"> {!!$plan_data->plan->name!!}</td>
          </tr>
          <tr>
            <td colspan="2" style="padding:10px 15px;" >
            <table width="100%" cellspacing="0" cellpadding="0">
                <tbody><tr>
                  <td width="45%" valign="top" style="padding:0 10px;"><h2 style="width:100%; margin:0; text-align:center; font-size:50px; color:#e73534; font-family: 'Muli', sans-serif; margin-bottom:5px;">{!!$discount !!}{!!$view_discount!!}</h2>
                    <span style="width:100%; font-family: 'Muli', sans-serif; text-align:center; font-size:13px; color:#2f3c3b; display:inline-block">{!!$discount_title !!}</span></td>
                  <td width="25%" valign="top"  style="padding:0 10px;"><h2 style="width:100%; font-family: 'Muli', sans-serif; margin:0; text-align:center; font-size:50px; color:#e73534; margin-bottom:5px;">{!!$month_benfit_period!!}</h2>
                    <span style="width:100%; text-align:center; font-size:13px; font-family: 'Muli', sans-serif; color:#2f3c3b; display:inline-block">Month
benefit period</span></td>
                  <td width="30%" valign="top"  style="padding:0 10px;"><h2 style="width:100%; font-family: 'Muli', sans-serif; margin:0; text-align:center; font-size:50px; color:#e73534; margin-bottom:5px;">{!!$termination_fee !!}</h2>
                    <span style="width:100%; text-align:center; font-size:13px; color:#2f3c3b; font-family: 'Muli', sans-serif; display:inline-block">Termination
fee</span></td>
                </tr>
              </tbody></table></td>
          </tr>
          <tr>
            <td colspan="2"  style="padding:10px 25px;"><p style="font-size:12px; color:#2f3c3b; font-family: 'Muli', sans-serif; line-height:20px; ">{!!$terms_condition!!}</p></td>
          </tr>
        </tbody></table>
                </td>
            </tr>
           <?php
		      }
		      }
		   ?> 
            <tr>
            	<td style="padding:10px 35px; background:#f7f8f8;" >
                 <h3 style="font-size:24px; font-weight:700; font-family: 'Muli', sans-serif; color:#e73534; line-height:30px; text-align:center">
                Remember switching with us means:
                </h3>
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td width="30%" align="center" style="padding:15px 0;">
                       	    <img src="{{ asset('/uploads/email_template/list1.png') }}" width="108" height="105" alt=""/></td>
                          <td width="70%" style="font-size:18px; font-weight:500; font-family: 'Muli', sans-serif; color:#2f3c3b; line-height:24px; text-align:left">Saving money on your next quarterly bill with us!.</td>
                        </tr>
                        <tr>
                            <td width="30%" align="center" style="padding:15px 0;">
                       	    <img src="{{ asset('/uploads/email_template/list2.png') }}" width="108" height="105" alt=""/></td>
                          <td width="70%" style="font-size:18px; font-weight:500; font-family: 'Muli', sans-serif; color:#2f3c3b; line-height:24px; text-align:left">Switch online right now! No annoying phone calls.</td>
                        </tr>
                         <tr>
                            <td width="30%" align="center" style="padding:15px 0;">
                       	    <img src="{{ asset('/uploads/email_template/list3.png') }}" width="108" height="105" alt=""/></td>
                          <td width="70%" style="font-size:18px; font-weight:500; font-family: 'Muli', sans-serif; color:#2f3c3b; line-height:24px; text-align:left">Get connected quicker – our system arranges it all.</td>
                        </tr>
                         <tr>
                            <td width="30%" align="center" style="padding:15px 0;">
                       	    <img src="{{ asset('/uploads/email_template/list4.png') }}" width="108" height="105" alt=""/></td>
                          <td width="70%" style="font-size:18px; font-weight:500; font-family: 'Muli', sans-serif; color:#2f3c3b; line-height:24px; text-align:left">100% neutral offers – don’t weigh results like other comparison sites.</td>
                        </tr>
                         <tr>
                            <td colspan="2" align="center" style="padding:15px 0; ">
                            	<a href="{{$mail_data['page_url'].'/'.$mail_data['sign_up_url']}}" style="line-height: 30px; padding: 10px 35px; font-size:20px; color:#fff; background:#e73534; display:inline-block; font-family: 'Muli', sans-serif; text-decoration:none; border-radius:30px;">View Plans</a>
                                <p style="font-size:12px; font-weight:400; font-family: 'Muli', sans-serif; color:#2f3c3b; line-height:20px; text-align:center">Click <a href="{{$mail_data['page_url'].'/'.$mail_data['sign_up_url']}}" style="color:#2f3c3b">HERE</a> to start saving on energy!</p>
                       	    </td>
                          
                        </tr>
                    </tbody>
                </table>

                </td>
            </tr>
            <tr>
            	<td style="background:#e73534; padding:15px 35px; ">
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td width="40%"><img src="{{ asset('/uploads/email_template/footer-logo.png') }}" width="175" height="58" alt="" style="border:0; "/></td>
      <td width="60%" align="right">
      	
				@if(isset($mail_data['facebook_url']) && !empty($mail_data['facebook_url']))
        		<a href="{{$mail_data['facebook_url']}}"><img src="{{asset('/uploads/email_template/fb-icon.png')}}" width="26" height="26" alt="" style="border:0; margin:4px; "/></a>
        		@endif
        		@if(isset($mail_data['twitter_url']) && !empty($mail_data['twitter_url']))
                <a href="{{$mail_data['twitter_url']}}"><img src="{{ asset('/uploads/email_template/twitter-icon.png') }}" width="26" height="26" alt="" style="border:0; margin:4px; "/></a>
                @endif
                @if(isset($mail_data['youtube_url']) && !empty($mail_data['youtube_url']))
                <a href="{{$mail_data['youtube_url']}}"><img src="{{ asset('/uploads/email_template/youtube-icon.png') }}" width="26" height="26" alt="" style="border:0; margin:4px; "/></a>
                @endif
                 @if(isset($mail_data['linkedin_url']) && !empty($mail_data['linkedin_url']))
				<a href="{{$mail_data['linkedin_url']}}"><img src="{{ asset('/uploads/email_template/linkedin-icon.png') }}" width="26" height="26" alt="" style="border:0; margin:4px; "/></a>
                @endif
                  @if(isset($mail_data['google_url']) && !empty($mail_data['google_url']))
                <a href="{{$mail_data['google_url']}}"><img src="{{ asset('/uploads/email_template/google-icon.png') }}" width="26" height="26" alt="" style="border:0; margin:4px; "/></a>
                @endif
       
      </td>
    </tr>
  </tbody>
</table>

              </td>
            </tr>
            <tr>
            	<td style=" padding:10px 35px; " align="center">
					<a href="{{$mail_data['page_url'].'/'.$mail_data['sign_up_url']}}" style="color:#2f3c3b; width:auto; margin:4px; padding:0; display:inline-block; font-family: 'Muli', sans-serif; font-size:12px; text-decoration:underline ">Approved Product List </a>
					
					 <a href="{{$mail_data['page_url'].'/'.$mail_data['sign_up_url']}}" style="color:#2f3c3b; width:auto; margin:4px; padding:0; display:inline-block; font-family: 'Muli', sans-serif; font-size:12px; text-decoration:underline ">Disclaimer</a>
                     <a href="{{$mail_data['page_url'].'/'.$mail_data['sign_up_url']}}" style="color:#2f3c3b; width:auto; margin:4px; padding:0; display:inline-block; font-family: 'Muli', sans-serif; font-size:12px; text-decoration:underline ">T&Cs   </a>
                     <a href="http://www.bulkbargain.com.au/" style="color:#2f3c3b; width:auto; margin:4px; padding:0; display:inline-block; font-family: 'Muli', sans-serif; font-size:12px; text-decoration:underline ">Contact Us</a>
                     <a href="#" style="color:#2f3c3b; width:auto; margin:4px; padding:0; display:inline-block; font-family: 'Muli', sans-serif; font-size:12px; text-decoration:underline ">View as webpage</a>
					
                

                </td>
            </tr> 
            <tr>
            	<td style=" padding:10px 45px; " align="center">
                	<p style="color:#777677; font-size:11px; line-height:16px; font-family: 'Muli', sans-serif;">
                    This email was sent to: {{$mail_data['cust_email']}} You have received this email because you have previously
used {{$mail_data['affiliate_website']}} for a quote and/or agreed to be contacted by {{$mail_data['affiliate_name']}}
{{$mail_data['affiliate_address']}}.
                    </p>
                </td>
            </tr>
            <tr>
            	<td style=" padding:0px 45px 10px; " align="center">
                	<p style="color:#777677; font-size:11px; line-height:16px; font-family: 'Muli', sans-serif;">
                   <a href="{{$mail_data['page_url'].'/unsubscriber/'.$mail_data['unsubscriber_url']}}" style="color:#777677;">Unsubscribe</a> | <a href="#" style="color:#777677;">Privacy</a>
                    </p>
                </td>
            </tr>                      
        </tbody>
        </table>

      	<!-- content main table end -->
      </td>
    </tr>
  </tbody>
</table>

</body>
</html>

