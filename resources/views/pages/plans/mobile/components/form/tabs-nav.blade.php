<!--begin::Navs-->
<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
    <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 active" data-bs-toggle="tab" href="#basic_details">{{ __ ('mobile.formPage.tabs.basicDetails')}}</a>
    </li>
    @if(isset($plan))
    <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#inclusions">{{ __ ('mobile.formPage.tabs.inclusions')}}</a>
    </li>
    <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#fees">{{ __ ('mobile.formPage.tabs.fees')}}</a>
    </li>

    <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 " data-bs-toggle="tab" href="#terms-condition">{{ __ ('mobile.formPage.tabs.terms')}}</a>
    </li>
    <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#other-info">{{ __ ('mobile.formPage.tabs.otherInformation')}}</a>
    </li>
    <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#plan-reference">{{ __ ('mobile.formPage.tabs.planReferences')}}</a>
    </li>
    @endif
</ul>
<!--begin::Navs-->