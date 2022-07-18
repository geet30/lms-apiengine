<div class="card-body pt-9 pb-0">
<!-- <div class="d-flex flex-wrap flex-sm-nowrap mb-3"> -->
    <div class="d-flex overflow-auto h-55px">
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap" id="handset_tab_permission">
            <!-- manage_handset_phones -->
              
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 active phones" data-bs-toggle="tab" href="#phones">Phones</a>
                </li>
               
                @if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_brands',$userPermissions,$appPermissions))
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 getBrands" data-bs-toggle="tab" href="#brands">Brands
                        </a>
                    </li>
                @endif
                @if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_rams',$userPermissions,$appPermissions))
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 getram" data-bs-toggle="tab" href="#ram">RAM
                        </a>
                    </li>
                @endif
                @if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_interanl_storage',$userPermissions,$appPermissions))
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 getstorage" data-bs-toggle="tab" href="#internal_storage">Internal Storage
                        </a>
                    </li>
                @endif
                @if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_colors',$userPermissions,$appPermissions))
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 getcolors" data-bs-toggle="tab" href="#colors">Colors
                        </a>
                    </li>
                @endif
                @if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_contracts',$userPermissions,$appPermissions))
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 getcontracts" data-bs-toggle="tab" href="#contracts">Contracts
                        </a>
                    </li>
                @endif 



            </ul>
    </div>
<!-- </div> -->
</div>  
