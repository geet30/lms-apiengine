<x-base-layout>
    <div class="d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container">
                <!--begin::Navbar-->
                <div class="card mb-5 mb-xl-10">
                    <div class="card-body pt-9 pb-0">
                        <!--begin::Navs-->
                        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
                            <li class="nav-item mt-2">
                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#demad-tariff-section">
                                    {{ __('plans/energyPlans.demand_rates_tab') }}
                                </a>
                            </li>
                            <li class="nav-item mt-2">
                                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#id-matrix-section" id="id-matrix-tab">
                                    ID Matrix
                                </a>
                            </li>
                        </ul>
                        <!--begin::Navs-->
                    </div>
                </div>
                <!--end::Navbar-->
                <!--begin::Basic info-->
                {{ theme()->getView('pages/settings/master-settings/modal') }}
                <div class="tab-content">
                    {{ theme()->getView('pages/settings/master-settings/demad-tariff') }}
                    {{ theme()->getView('pages/settings/master-settings/id-matrix') }}
                </div>
            </div>

        </div>
    </div>

    @section('scripts')
        @include('pages.settings.master-settings.id-matrix-js')
        <script src="/custom/js/loader.js"></script>
        <script src="/custom/js/breadcrumbs.js"></script>

        <script>
            const breadArray = [{
                title: 'Dashboard',
                link: '/',
                active: false
            },
                {
                    title: 'Master Settings',
                    link: '#',
                    active: true
                },
            ];
            const breadInstance = new BreadCrumbs(breadArray, 'Plans');
            breadInstance.init();

            $(document).on('submit', '#demad_tariff_form', function (e) {
                e.preventDefault();
                $('.error').text('').fadeIn();
                let formData = new FormData(this);
                axios.post("{{ route('settings.master.settings.import.demand')}}", formData)
                    .then(function (response) {
                        $('#upload_tariff_code_file_modal').modal('hide');
                        $('[name=tariff_code_file]').val('');
                        toastr.success('Demand tariff sheet uploaded successfully');
                        $('#error-demand-modal').modal('show');
                        var saved = `<label style="color:red">Out of <b>${response.data.total_records}</b> plans <b>${response.data.inserted_records}</b> uploaded successfully.</label>`;
                        $('.record_info').html(saved);
                        var row = '';
                        $.each(response.data.errors, function (i, obj) {
                            $.each(obj, function (i, data) {
                                row += `<tr>
                                    <td style="width:20%">Row ${data['key']} </td>
                                    <td style="width:20%"> ${data['column']} </td>
                                    <td style="width:60%"> ${data['error']} </td>
                                </tr>`;
                            });
                        });
                        $("#error_body").html(row);
                    })
                    .catch(function (error) {
                        $('[name=tariff_code_file]').val('');
                        $.each(error.response.data.errors, function (key, value) {
                            $('.' + key + '_error').text(value).fadeIn();
                        });
                    });
            });

            $(document).on('hide.bs.modal', '#upload_plan_modal', function (e) {
                $('.error').text('').fadeIn();
            });

            $(document).on('click', '.download_sample', function (e) {
                axios.post("{{ route('settings.master.settings.get.demand.sample')}}")
                    .then(function (response) {
                        location.href = response.data.url;
                    })
                    .catch(function (error) {

                    });
            });

            $(document).on('click', '.download_master_tariff', function (e) {
                axios.post("{{ route('settings.master.settings.get.tarridId')}}")
                    .then(function (response) {
                    })
                    .catch(function (error) {

                    });
            });
        </script>
    @endsection
</x-base-layout>
