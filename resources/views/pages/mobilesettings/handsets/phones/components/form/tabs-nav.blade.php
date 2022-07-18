<!--begin::Navs-->
<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
    <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 active" data-bs-toggle="tab" href="#basic_details">{{ __ ('handset.formPage.tabs.basicDetails')}}</a>
    </li>
    @if(isset($phone))
    <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#specifications">{{ __ ('handset.formPage.tabs.specifications')}}</a>
    </li>
    <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#features">{{ __ ('handset.formPage.tabs.features')}}</a>
    </li>
    <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#more_info">{{ __ ('handset.formPage.tabs.more_info')}}</a>
    </li>
    @endif
</ul>
<!--begin::Navs-->