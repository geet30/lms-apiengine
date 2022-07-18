<div class="card-body p-5">
    <div class="row mb-8">
        <div class="col-xl-4">
            <div class="fs-6 fw-bold">Business Information</div>
        </div>
        <div class="col-xl-8 fv-row">
            {{$provider->name}}
        </div>
    </div>

    <div class="row mb-8">
        <div class="col-xl-4">
            <div class="fs-6 fw-bold">ABN/ACN</div>
        </div>
        <div class="col-xl-8 fv-row">
            {{$provider->abn_acn_no}}
        </div>
    </div>
    <div class="row mb-8">
        <div class="col-xl-4">
            <div class="fs-6 fw-bold">Legal Name</div>
        </div>
        <div class="col-xl-8 fv-row">
            {{$provider->legal_name}}
        </div>
    </div>
    <div class="row mb-8">
        <div class="col-xl-4">
            <div class="fs-6 fw-bold">Complaint Email</div>
        </div>
        <div class="col-xl-8 fv-row">
            {{$provider->complaint_email}}
        </div>
    </div>
    <div class="row mb-8">
        <div class="col-xl-4">
            <div class="fs-6 fw-bold">Support Email</div>
        </div>
        <div class="col-xl-8 fv-row">
            {{$provider->support_email}}
        </div>
    </div>
    <div class="row mb-8">
        <div class="col-xl-4">
            <div class="fs-6 fw-bold">Phone Number</div>
        </div>
        <div class="col-xl-8 fv-row">
            {{decryptGdprData($provider->user->phone)}}
        </div>
    </div>
    <div class="row mb-8">
        <div class="col-xl-4">
            <div class="fs-6 fw-bold">Address</div>
        </div>
        <div class="col-xl-8 fv-row">
            {{$provider->getUserAddress->address}}
        </div>
    </div>
    <div class="row mb-8">
        <div class="col-xl-4">
            <div class="fs-6 fw-bold">Description</div>
        </div>
        <div class="col-xl-8 fv-row">
            {{$provider->description}}
        </div>
    </div>
</div>
