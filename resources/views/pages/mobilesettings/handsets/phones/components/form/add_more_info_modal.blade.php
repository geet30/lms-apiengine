<!-- weekdays title -->
<div class="modal fade" id="add_more_info_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary px-5 py-4">
				<h2 class="fw-bolder fs-12 text-white add_more_info_header">
				
					@if(empty($moreInfo))
						Add Info
					@else
						Edit Info
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
                <form id = 'add_more_info_form' name="add_more_info_form" class="form">
                    <input type="hidden" name="handset_info_id" value="">
                    <div class="card-body border-top p-9">
                        <div class="row">
                            <label class="col-form-label fw-bold fs-6">{{ __ ('handset.formPage.more_info.s_no.label')}}</label>
                            <div class="fv-row">
                                <div class="form-check-solid fv-row">
                                    <select class="form-select form-select-solid" name="s_no" data-control="select2" data-hide-search="false" aria-label="{{ __ ('handset.formPage.more_info.s_no.placeHolder')}}" disabled data-placeholder="{{ __ ('handset.formPage.more_info.s_no.placeHolder')}}">
                                        
                                    </select>
                                    <input type="hidden" class="form-control" name="current_s_no" id="current_s_no" />
                                <span class="text-danger errors" id="s_no_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.more_info.title.label')}}</label>
                            <div class="fv-row">
                                <div class="form-check-solid fv-row">
                                    <input type="text" name="title" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('handset.formPage.more_info.title.placeHolder')}}" value="{{isset($moreInfo) ? $moreInfo->title :''}}" autocomplete="off" />
                                <span class="text-danger errors" id="title_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label fw-bold fs-6">{{ __ ('handset.formPage.more_info.what_to_upload.label')}}</label>
                               <div class="col-lg-8 fv-row">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                        <input class="form-check-input" type="radio" name="linktype" value="url" {{isset($moreInfo) && $moreInfo->linktype == 'url' ? 'checked':''}} checked />
                                        <span class="form-check-label">{{ __ ('handset.formPage.more_info.url.label')}}</span>
                                </label>
                                <!--end::Option-->
                                <!--begin::Option-->
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input" type="radio" name="linktype" value="file" {{isset($moreInfo) && $moreInfo->linktype == 'file' ? 'checked':''}} />
                                    <span class="form-check-label">{{ __ ('handset.formPage.more_info.file.label')}}</span>
                                </label>
                                <span class="text-danger errors" id="linktype_error"></span>
                            </div>
                        </div>
                        <div class="url_box">
                            <div class="row">
                                <label class="col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.more_info.url.label')}}</label>
                                <div class="fv-row">
                                    <div class="form-check-solid fv-row">
                                        <input type="text" name="url" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('handset.formPage.more_info.url.placeHolder')}}" value="{{isset($moreInfo) ? $moreInfo->url :''}}" autocomplete="off" />
                                    <span class="text-danger errors" id="url_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="file_box" style="display: none;">
                            <div class="row">
                                <label class="col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.more_info.file.label')}}</label>
                                <div class="fv-row">
                                    <div class="form-check-solid fv-row">
                                        <input type="file" accept=".pdf" class="form-control form-control-lg form-control-solid" name="file">
                                    <span class="text-danger errors" id="file_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
			</div>
            <div class="model-footer d-flex justify-content-end py-6 px-9">
                <a href="javascript:void(0);" type="button" class="btn btn-light btn-active-light-primary me-2 cancel_more_info_btn">{{ __ ('handset.formPage.more_info.cancelButton')}}</a>
                <button type="button" class="btn btn-primary submit_btn" id="add_more_info_form_submit_btn" data-form="add_more_info_form">{{ __ ('handset.formPage.more_info.submitButton')}}</button>
            </div>
  		</div>
	</div>
</div>
