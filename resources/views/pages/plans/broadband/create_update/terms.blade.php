<div class="tab-pane fade" id="terms" role="tab-panel">
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{__('plans/broadband.terms_and_condition')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Content-->
        <div id="kt_account_plan_info" class="collapse show">
            <form class="form">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div class="pt-0 table-responsive">
                        <!--begin::Table-->
                        <table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class" id="lead_data_table">
                            
                            <tbody class="fw-bold text-gray-600">  
                                    <tr>
                                        <th>
                                        {{__('plans/broadband.title')}}
                                        </td>
                                        <th>
                                        {{__('plans/broadband.action')}}
                                        </td>
                                    </tr>
                                @foreach($plan->terms as $term)
                                    <tr>
                                        <td>
                                            <div class="row mb-2 mt-3">  
                                                <label class="col-lg-6 fw-bold fs-6" id="term_condition_title_{{$term->id}}">
                                                    {{$term->title}}
                                                </label>
                                            </div> 
                                        </td>
                                        <td>
                                            <div class="row mb-2 mt-3">  
                                                <a class="menu-link px-3 cursor-pointer get_term_page" id="term_condition_id_{{$term->id}}" data-bs-toggle="modal" data-bs-target="#edit_terms_and_condition_modal" data-id='{{$term->id}}'
                                                data-title='{{$term->title}}'
                                                data-description='{{$term->description}}'
                                                >{{__('plans/broadband.edit')}}</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> 
            </form>  
        </div>
    </div>
</div>