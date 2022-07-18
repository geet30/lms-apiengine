@extends('errors::illustrated-layout')

@section('title', __('System Error'))

<!--begin::Illustration-->
@section('image')
<img src="/common/media/illustrations/sketchy-1/17.png" alt="" class="mw-100 mb-10 h-lg-450px" />
<!--end::Illustration-->
@endsection
@section('message')
<h1 class="fw-bolder fs-2qx text-gray-800 mb-10">System Error</h1>
<!--begin::Message-->
<div class="fw-bold fs-3 text-muted mb-15">Something went wrong!
<br />Please try again later.</div>
<!--end::Message-->
@endsection
