<div id="commission-table">
{{-- load table here--}}
</div>

@section('styles')
    <link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
    <style>
        .custom-width {
            min-width: 120px;
        }

        table.sub-table th {
            padding-top: 10px !important;
            font-size: 12px;
        }

        .all-table-css-class tr th {
            padding-bottom: 4px !important;
        }

        #affiliate-services-dropdown{
            margin-left: 1rem!important;
        }

        @media only screen and (max-width:388px) {
            #btn-add-commission{
                margin-left: 0.25rem!important;
            }
            #affiliate-services-dropdown{
                margin-left: .25rem!important;
                min-width: 90px;
            }
        }

        .edit-commission{
            cursor: pointer;
            font-size: 1.8em!important;
        }

        .here {
            color: #009ef7;
            cursor: pointer;
        }
    </style>
@endsection

@section('scripts')
    <script src="/custom/js/affiliate-commission.js"></script>
    <script src="/custom/js/breadcrumbs.js"></script>
    <script src="/custom/js/loader.js"></script>
    <script>
        const breadArray = [
            {
                title: 'Dashboard',
                link: '/',
                active: false
            },
            {
                title: 'Affiliates',
                link: '/affiliates/list',
                active: false
            },
            {
                title: 'Commission',
                link: '#',
                active: true
            }
        ];

        const breadInstance = new BreadCrumbs(breadArray);
        breadInstance.init();
    </script>
@endsection
