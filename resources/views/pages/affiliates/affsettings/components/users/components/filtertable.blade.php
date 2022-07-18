         <tbody class="text-gray-600 target_table_data_body" id="">


             @if(isset($targetRecords) && count($targetRecords)>0)
             @foreach($targetRecords as $targetValue)
             @php
             $dateObj = DateTime::createFromFormat('!m', $targetValue['target_month']);
             $status='Not Achieved';
             if($targetValue['status'] == 0){
             $status ='Not Achieved';
             }elseif($targetValue['status']){
             $status = 'Achieved';
             }
             @endphp

             <tr id="filtertr">
                 <td>
                     <div class="form-check form-check-sm form-check-custom form-check-solid">
                         <input class="form-check-input" type="checkbox" value="1" />
                     </div>
                 </td>
                 <td>
                     <span>{{isset($targetValue['target_value']) ? $targetValue['target_value'] : 'N/A'}}</span>
                 </td>
                 <td>
                     <span>{{$dateObj->format('F')}}</span>
                 </td>
                 <td>
                     <span>{{ $targetValue['target_year']}}</span>
                 </td>
                 <td>
                     <span>{{$status}}</span>
                 </td>
                 <td>
                     <span>{{isset($targetValue['sales']) ? $targetValue['sales'] : 'N/A'}}</span>
                 </td>
                 <td>
                     <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                         <span class="svg-icon svg-icon-5 m-0">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                 <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                             </svg>
                         </span>
                     </a>
                     <div class="menu menu-sub  menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                         <div class="menu-item ">
                             <span class="menu-link  target_popup" data-id="{{$targetValue['id']}}" data-date="{{$dateObj->format('d')}}-{{$targetValue['target_year']}}" data-modified="{{$dateObj->format('F')}},{{ $targetValue['target_year']}}" data-comment="{{$targetValue['comment']}}" data-status="{{$status}}" data-sales="{{ $targetValue['sales']}}" data-target="{{$targetValue['target_value']}}">Edit</span>
                         </div>
                         <div class="menu-item ">
                             <span class="menu-link ">Delete</span>
                         </div>
                     </div>
                 </td>
             </tr>

             @endforeach
             @else
             <tr>
                 <td colspan="7" align="center">Sorry, no data found</td>
             </tr>
             @endif


         </tbody>