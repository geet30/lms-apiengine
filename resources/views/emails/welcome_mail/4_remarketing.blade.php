  <tr>
            	<td>
           	    <a href="{{$mail_data['page_url'].'/'.$mail_data['sign_up_url']}}"><img src="{{ asset('/uploads/email_template/'.$template_image) }}" width="100%"  alt=""/></a>
                </td>
             </tr>
  <tr>
            	<td style="padding:10px 35px;">
                	<h2 style=" color:#2f3c3b; font-size:36px; margin:15px 0; font-family: 'Muli', sans-serif; line-height:44px;  text-align:left; font-weight:800">Hi {{$mail_data['cust_name']}},</h2>
                    <p style="font-size:16px; font-weight:400; color:#2f3c3b; text-align:justify; font-family: 'Muli', sans-serif; line-height:24px;">
                    Did you know only 1 in 5 Australian households review their energy plan each year? 
                    <br>
                    <br>
                    20% of Australians are living a life with lower energy costs, which means more money spent on luxuries, holidays, and more.
                    <br>
                    <br>
                    Don’t be one of the millions households missing out on the potential savings that could be available to you.
                   </p>
                </td>
            </tr>
             <tr>
                            <td  align="left" style="padding:15px 35px; ">
                            	<a href="{{$mail_data['page_url'].'/'.$mail_data['sign_up_url']}}" style="line-height: 30px; padding: 10px 35px; font-size:20px; color:#fff; background:#e73534; display:inline-block; font-family: 'Muli', sans-serif; text-decoration:none; border-radius:30px;">Switch online today</a>
                                
                       	    </td>
                          
                        </tr>
