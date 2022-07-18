    <div class="card-body pt-0">
        <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class dataTable no-footer dtr-inline" id="plan_rate_table">
            <thead>
                <tr class="fw-bolder fs-6 text-gray-800 px-7">
                    <!-- <th class="min-w-300px" data-priority="1">Records</th> -->
                    <th data-priority="1" class="text-capitalize text-nowrap">{{ __('plans/energyPlans.sr_no') }}</th>
                    <th class="text-capitalize text-nowrap">{{ __('plans/energyPlans.distributor_name') }}</th>
                    <th class="text-capitalize text-nowrap">{{ __('plans/energyPlans.upload_tariff_details') }}</th>
                    <th class="text-capitalize text-nowrap">{{ __('plans/energyPlans.type') }}</th>
                    <th class="text-capitalize text-nowrap">{{ __('plans/energyPlans.actions') }}</th>
                </tr>
            </thead>
            <tbody>
               @foreach ($planRates as $key => $rate )
               <tr>
                <td>{{$key+1}}</td>
                <td>{{isset($rate['distributors']->name)?$rate['distributors']->name:''}}</td>
                <td><a title="Upload plan pdf" class="btn btn-circle btn-icon-only btn-default uploadPlan" data-id="" data-plan="Basic Saver Business - NSW
                    " data-toggle="modal"><span class="fa fa-cloud-upload" style="color:#578ebe;"></span></a></td>
                <td>{{$rate->type}}</td>
                <td>
                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-end">{{ __('plans/energyPlans.actions') }}
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                        <span class="svg-icon svg-icon-5 m-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                    fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                        data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{ theme()->getPageUrl('provider/plans/energy/edit-plan-rate/'.$rate->id.'/'.$energyType) }}" class="menu-link px-3">{{ __('plans/energyPlans.edit_rate') }}</a>
                            @if($rate['type'] != 'gas_peak_offpeak' && $energyType =='electricity')
                            <a href=" {{ theme()->getPageUrl('provider/plans/energy/rates/demand/'.$rate->id.'/'.encryptGdprData($rate->distributor_id).'/'.$plan->plan_type)}}" class="menu-link px-3">{{ __('plans/energyPlans.demand_rates') }}</a>
                            
                            @endif
                            <a href="" class="menu-link px-3">{{ __('plans/energyPlans.delete') }}</a>
                        </div>
                    </div>
                    <!--end::Menu-->
                </td>
               @endforeach
            </tbody>
        </table>
    </div>
    @section('styles')
        <link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    @endsection
    @section('scripts')
        <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
        <script src="/custom/js/breadcrumbs.js"></script>
        <script>
            var energyType = "{{ $energyType }}";
            var diff_aff = '/provider/list';
            var aff_head = 'Providers';
            let selectedProvider = "{{ ucwords($selectedProvider->name) }}";
            let current_sub_head = "{{ ucwords($plan->name) }}";
            const breadArray = [{
                    title: 'Dashboard',
                    link: '/',
                    active: false
                },
                {
                    title: aff_head,
                    link: diff_aff,
                    active: false
                },
                {
                    title: selectedProvider,
                    link: "{{ $url }}",
                    active: false
                },
                {
                    title: capitalizeFirstLetter(energyType) + " Plans",
                    link: "{{ $url }}",
                    active: false
                },
                {
                    title: current_sub_head,
                    link: '#',
                    active: false
                },
                {
                    title: "Plan Rates",
                    link: '#',
                    active: true
                },
            ];
            const breadInstance = new BreadCrumbs(breadArray);
            breadInstance.init();
            const dataTable = $("#plan_rate_table")
                .on('draw.dt', function (){
                    KTMenu.createInstances();
                })
                .DataTable({
                    searching: true,
                    ordering: true,
                    "sDom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                });

            function capitalizeFirstLetter(str) {
                return str[0].toUpperCase() + str.slice(1);
            }
            $('#search_leads').keyup(function() {
                console.log($(this).val());
                dataTable.search($(this).val()).draw();
            })
            $('#add_plan_close, #cancel').click(function() {
                $("#add_plan_modal").modal('hide');
            });

            $(document).on('submit','#add_plan_rate_form',function(e) {
               e.preventDefault();
               loaderInstance.show();
                $('.error').text('').fadeIn();
                let formData = new FormData(this);
                axios.post("{{ route('energy.upload.plan.rate.list')}}",formData)
                    .then(function (response) {
                        loaderInstance.hide();
                        $('#upload_plan_modal').modal('hide');
                        $('[name=upload_plan_rate]').val('');
                        toastr.success('Plan sheet uploaded successfully');

                        main_response = response;
						upload_records = response.data.saved_record;
						total_records = response.data.total_records;

						if(response.data.missed_record == undefined){
							$('#error-plan-rate-modal').modal('show');
                            saved = `<label style="color:red">Out of <b>${response.data.total_records}</b> plans Rates <b>${response.data.saved_record}</b> uploaded successfully.</label>`;
                            var row = '';
                            $('.record_info').html(saved);
                            $.each(response.data.errors, function(i, obj){
                                $.each(obj, function(i, data){
                                    row +=`<tr>
                                            <td style="width:20%">Row ${data['key']} </td>
                                            <td style="width:20%"> ${data['column']} </td>
                                            <td style="width:60%"> ${data['error']} </td>
                                        </tr>`;
                                });
                            });
                            $("#error_body").html(row);
						}else{
							rate_sheet_mapping_plan(main_response);
						}
                    })
                    .catch(function (error) {
                        loaderInstance.hide();
                        if(error.response.status = 400 || error.response.status == 500)
                        {
                            toastr.error(error.response.data.message);
                        }
                        $('[name=upload_plan_rate]').val('');
                        $.each(error.response.data.errors, function (key, value) {
                            $('.' + key + '_error').text(value).fadeIn();
                        });
                    });

            });

            function rate_sheet_mapping_plan(response){
                if(response.data.success)
                {
                    var names = [];
                    var duplicate = [];
                    $('#distributor_mapping_modal .modal-body table tbody').html('');
                    if(response.data.missed_record)
                    {
                        missed_records = response.data.missed_record;
                        var sugestDistributors = response.data.suggestion_distributor;
                        $('#distributor_mapping_modal').modal('show');
                        var distributorsSelect = '<select class="form-control"><option value="">Select Distributor</option>';
                        $.each(sugestDistributors,function(key ,value){
                            distributorsSelect += '<option value="' + key + '">' +key +'</option>';
                        });
                        distributorsSelect += '</select>';

                        $.each(response.data.missed_record,function(){
                            names.push(this.Distributor);
                        });
                        var tds = jQuery.unique(names);
                        $.each(tds,function(){
                            $('#distributor_mapping_modal .modal-body table tbody').append('<tr class="missed_record_tr">'
                            +'<td>'+this+'</td>'
                            +'<td>'+distributorsSelect+' <span class="form_error" style="color:red"></span></td>'
                            +'</tr>');
                        });
                    }
                }
            }

            $(document).on('submit','#distributor_mapping_form',function(e){
                e.preventDefault();
                var flag = 1;
                $('span.form_error').hide();
                $('#distributor_mapping_modal .modal-body table tbody tr.missed_record_tr').each(function()
                {
                    var selected_distributor = $(this).children('td:first-child').next().children('select').val();
                    if(selected_distributor == '')
                    {
                        flag = 0;
                        $(this).children('td:first-child').next().children('span').slideDown(400).html('Please select an option');
                    }
                });

                if(flag == 1)
                {
                    $('#distributor_mapping_form .modal-body table tbody tr.missed_record_tr').each(function(){
                        var pre_name = $(this).children('td:first-child').text();
                        var new_name = $(this).children('td:first-child').next().children('select').val();
                        $.each(missed_records,function(){
                            if(this.Distributor === pre_name)
                                this.Distributor = new_name;
                        });
                    });
                    let formData = new FormData(this);
                    var plan_id = formData.get('plan_id');
                    var type = formData.get('type');
                    loaderInstance.show();
                    axios.post("{{ route('energy.upload.missing.plan.rate.list')}}",{ data: missed_records, plan_id: plan_id,upload_records:upload_records,total_records:total_records,type:type})
                    .then(function (response) {
                        loaderInstance.hide();
                        $('#distributor_mapping_modal').modal('hide');
						$('#error-plan-rate-modal').modal('show');
						saved = `<label style="color:red">Out of <b>${response.data.total_records}</b> plans Rates <b>${response.data.saved_record}</b> uploaded successfully.</label>`;

					    $('.record_info').html(saved);
                        var row = '';
						$.each(response.data.errors, function(i, obj){
							$.each(obj, function(i, data){
								row +=`<tr>
										<td style="width:20%">Row ${data['key']} </td>
										<td style="width:20%"> ${data['column']} </td>
										<td style="width:60%"> ${data['error']} </td>
									</tr>`;
							});
						});
						$("#error_body").html(row);
                    })
                    .catch(function (error) {
                        loaderInstance.hide();
                        if(error.response.status = 400 || error.response.status == 500)
                        {
                            toastr.error(error.response.data.message);
                        }
                    });

                    return false;
                }
            });

            $(document).on('click','.download_sample',function(e){
                axios.post("{{ route('energy.download.plan.rate.list')}}",{'type':$(this).data('type')})
                .then(function (response) {
                    location.href=response.data.url;
                })
                .catch(function (error) {

                });
            });

            $(document).on('hide.bs.modal','#error-plan-rate-modal',function(e){
                location.reload();
            });

            $(document).on('click', '#view-provider', function (event) {
                var url = $(this).data('url');
                $('#provider-detail .modal-body').attr('data-kt-indicator', 'on');
                axios.get(url)
                    .then(function (response) {
                        setTimeout(function () {
                            $('#provider-detail .modal-body').attr('data-kt-indicator', 'off');
                            $('#provider-detail .modal-body').append(response.data)
                        }, 1000)
                    })
                    .catch(function (error) {
                        $('#provider-detail .modal-body').attr('data-kt-indicator', 'off');
                        console.log(error);
                    })
                    .then(function () {

                    });
            });

            $('#provider-detail').on('hidden.bs.modal', function (e) {
                $('#provider-detail .modal-body').html('<span class="indicator-progress">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span> </span>');
            });
        </script>
    @endsection


