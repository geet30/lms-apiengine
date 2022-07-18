<ul class="d-md-block nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fw-bold mb-n2 me-7 pb-5">
    <?php $tab= 0; ?> 
    @foreach($allPermission as $permission)
        @if(in_array($permission[1], ['show_leads','show_sales','show_visits','show_statistics']))
            <li class="{{$tab == 0 ?'active' :''}} {{$permission[1]}} {{$permission[2]}}_tab nav-item">
                <a class="ms-md-4 nav-link text-active-primary pb-2 text-gray-600 fs-7" data-bs-target="#tab_{{$permission[1]}}" data-bs-toggle="tab">
                    {{ $permission[0] }}
                </a>
            </li>
        @else
            @if(in_array($permission[1], ['show_affiliates','show_providers','show_users','show_handsets','show_addons','show_manage_to_do_list','show_upload_leads','show_add_lead_manually','show_add_lead_manually_old','show_ip_settings','show_set_usage','show_reports','show_recon_settings','show_manage_faq','show_promotional_sms','show_detokenization','energy_settings_permission']) && in_array($role, ['admin','qa']))
                <li class="{{$tab == 0 ?'active' :''}} {{$permission[1]}} {{$permission[2]}}_tab nav-item">
                    <a class="ms-md-4 nav-link text-active-primary pb-2 text-gray-600 fs-7" data-bs-target="#tab_{{$permission[1]}}" data-bs-toggle="tab">
                        {{ $permission[0] }}
                    </a>
                </li>
            @elseif(in_array($permission[1], ['show_settings']) && in_array($role, ['admin']))
                <li class="{{$tab == 0 ?'active' :''}} {{$permission[1]}} {{$permission[2]}}_tab nav-item">
                    <a class="ms-md-4 nav-link text-active-primary pb-2 text-gray-600 fs-7" data-bs-target="#tab_{{$permission[1]}}" data-bs-toggle="tab">
                        {{ $permission[0] }}
                    </a>
                </li>
            @endif
        @endif
        <?php $tab++; ?>
    @endforeach
</ul>

 