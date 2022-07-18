<!-- weekdays title -->
<div class="modal fade" id="move_in_weekend_modal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog mw-650px">
		<div class="modal-content">
			<div class="modal-header bg-primary px-5 py-4">
				<h2 class="fw-bolder fs-12 text-white">
				
					@if(empty($weekend_content))
						Add Weekend Title & Description
					@else
						Edit Weekend Title & Description
					@endif
				
				</h2>
				<div data-bs-dismiss="modal"
                    class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                fill="black" />
                        </svg>
                    </span>
                </div>
				
	  		</div>
	 		 <div class="modal-body px-5">
			  	
             
	 				{!! Form::model($weekend_content,['method' => 'POST','id' => 'move_in_weekend_form']) !!}
	 				<!-- hidden field -->
					 @csrf
					 <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Holiday Title</label>
                        <div class="col-lg-8 fv-row">
                            <div class="form-check form-check-solid form-switch fv-row">
							{!! Form::text('holiday_title', null , ['class' => 'form-control form-control-lg form-control-solid','placeholder' => 'e.g. Good Friday']) !!}
							<span class="error" style="color: red;"></span>
                            </div>
                        </div>
                    </div>

					<div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Description</label>
                        <div class="col-lg-8 fv-row">
                            <div class="form-check form-check-solid form-switch fv-row">
							{!! Form::textarea('holiday_content', null , ['class' => 'form-control form-control-lg form-control-solid','placeholder' => 'e.g. This is Good Friday', 'rows' => 4, 'cols' => 40]) !!}
							<span class="error" style="color: red;"></span>
                            </div>
                        </div>
                    </div>
					
					<div class="clearfix"></div>
					<div class="card-footer d-flex justify-content-end py-6 px-9">
						<a class="btn btn-light btn-active-light-primary me-2" href="" data-bs-dismiss="modal">Cancel</a>
						<button type="button" id="move_in_week_btn" class="submit_button" class="btn btn-primary move_in_week_btn">
							@if(empty($weekend_content))
								Add
							@else
								Edit
							@endif</button>
					</div>

			      <?php echo Form::close(); ?>
				
			</div>
  		</div>
	</div>
</div>

<!-- closing time modal start here -->
<div class="modal fade" id="move_close_time_modal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog mw-650px">
		<div class="modal-content">
			<div class="modal-header bg-primary px-5 py-4">
                <h2 class="fw-bolder fs-12 text-white">Set Closing Time</h2>
                <div data-bs-dismiss="modal"
                    class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                fill="black" />
                        </svg>
                    </span>
                </div>
            </div>
			<div class="modal-body px-5">
	 		
				{!! Form::model($closing_time,['method' => 'POST','class' => 'form-horizontal form-bordered','id' => 'move_in_closing_time_form']) !!}
				<!-- hidden field -->
				
				<div class="row mb-6">
					<label class="col-lg-4 col-form-label fw-bold fs-6">Select Time</label>
					<div class="col-lg-8 fv-row">
						<div class="form-check form-check-solid form-switch fv-row">
						{!! Form::text('move_in_closing_time', $closing_time , ['class' => 'form-control-lg form-control-solid','id'=>'move_in_closing_time','placeholder' => 'Select Time']) !!}
						<span class="error" style="color: red;"></span>
						</div>
					</div>
                </div>
				<div class="card-footer d-flex justify-content-end py-6 px-9">
					<a class="btn btn-light btn-active-light-primary me-2" href="" data-bs-dismiss="modal">Cancel</a>
					<button type="button" id="move_in_closing_time_btn" class="submit_button" class="btn btn-primary">Save</button>
            	</div>
				<?php echo Form::close(); ?>
				
			</div>
  		</div>
	</div>
</div>
<!-- closing time modal end here -->