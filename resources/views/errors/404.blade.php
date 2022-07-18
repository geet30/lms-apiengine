@extends('errors::illustrated-layout')

@section('title', __('Page Not Found'))

<!--begin::Illustration-->
@section('image')
<img src="/common/media/illustrations/sketchy-1/18.png" alt="" class="mw-100 mb-10 h-lg-450px" />
<!--end::Illustration-->
@endsection
@section('message')
<!--begin::Message-->
<h1 class="fw-bold mb-10" style="color: #A3A3C7">Seems there is nothing here</h1>
<!--end::Message-->
@endsection
