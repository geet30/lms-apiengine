

<div class="modal fade" id="generate_month_recon_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modalalert" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 style="text-align: center;font-weight: bold;"><u>Month Adjustment </u></h4>		  	
		  	</div>
        <form id="add_adjustment_form" name="add_adjustment_form" method="post" accept-charset="UTF-8" class="form pb-0">
		 	<input type="hidden" name="counter" id="counter" value="1">
            <!-- <input type="hidden" name="affiliate_id" id="affiliate_id" value=""> -->
		 	<input type="hidden" name="recon_file_type" id="recon_file_type" value="live">
            @csrf

		  	<div class="modal-body">
			<div class="modalcontentText month-adjustmentmodal">
				<div class="clearfix"></div>
				<div class="month-div">
					<label><b>Select Month</b></label>
					<div class="clearfix"></div>
					<?php for ($i = 1; $i <= 6; $i++) { 
							$radio_value = date('m', strtotime("-$i month"));
							$year_value = date('Y', strtotime("-$i month"));

					?>
                    <div class="radio-month-div">

                        <input type="radio" name="selected_month" class="selected_month" value="{{$radio_value.' '.$year_value}}" /><span class="adjustment">{{date('F Y', strtotime("-$i month"))}}</span>
                        <br>
                    </div>	
					<?php } ?>
				</div>

				<div class="clearfix"></div>
				<hr>
				<div class="row" id="month_generate_recon_check">
					<div class="form-group col-md-12 recon_checkcls" >
						<input type="checkbox" name="generate_monthrecon_checkbox" class="generate_monthrecon_checkbox">
						<span>Mark this checkbox to provide your acceptance.</span>
					</div>
				</div>

			</div>
		  </div>
		  <div class="modal-footer text-center">
		    <button type="button" class="btn btn-success" id="submit_recon_month_data">Generate file</button>
			<button type="button" class="btn btn-light me-3"
            data-bs-dismiss="modal">{{ __('buttons.cancel') }}</button>
                     
		  </div>
		{!!  Form::close(); !!}
		</div>
	  </div>
	</div>

