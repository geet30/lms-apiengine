   <tr>
            	<td>
           	   <a href="{{$mail_data['page_url'].'/'.$mail_data['sign_up_url']}}"><img src="{{ asset('/uploads/email_template/'.$template_image) }}" width="100%"  alt=""/></a>
                </td>
             </tr>
    <tr>
            	<td style="padding:10px 35px;">
                    <h2 style=" color:#2f3c3b; font-size:36px; margin:15px 0; font-family: 'Muli', sans-serif; line-height:44px;  text-align:left; font-weight:800">Hi {{$mail_data['cust_name']}},</h2>
                    <p style="font-size:16px; font-weight:400; color:#2f3c3b; text-align:justify; font-family: 'Muli', sans-serif; line-height:24px;">
                    The Australian Energy Regulator has identified that a typical customer switching from an electricity standing offer to the best market offer with the same retailer could SAVE up to $676 in Victoria, $381 in NSW, $332 in South Australia, $256 in Queensland and $204 in the ACT.
                    <br>
                    <br>
                        <b>See how much you can SAVE at {{$mail_data['suburb']}} through ECONNEX.</b>
                   </p>
                </td>
            </tr>
