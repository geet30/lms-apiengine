<!-- weekdays title -->
<div class="modal fade" id="handsetAssignedProvidersModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary px-5 py-4">
				<h2 class="fw-bolder fs-12 text-white">
                    Provider Assigned
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
                <div class="form-body">
                    <div class="form-group name">
                        <div class="clearfix"></div>
                        <div class="row assigned_providers_names mb-3">

                        </div>
                        <p><strong>Note: </strong> Handset has been assigned to some providers. On disabling, it will get disabled for all the provider's Plan also. Are you sure to continue?</p>
                    </div>
                </div>
			</div>
            <div class="model-footer d-flex justify-content-end py-6 px-9">
                <a href="javascript:void(0);" type="button" class="btn btn-light btn-active-light-primary me-2 cancel_assign_providers_btn">{{ __ ('handset.formPage.more_info.cancelButton')}}</a>
                <button type="button" class="btn btn-primary" id="handset_status_change_modal_btn" data-id="" data-status="">Confirm Disable</button>
            </div>
  		</div>
	</div>
</div>
