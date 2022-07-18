@extends('emails.template') 
@section('content')
   <h3>Hi Team {{$providerName}},</h3>
  <p>Please find CIMET sales attached for your reference.</p>
  <p><b>Date: </b>{{\Carbon\Carbon::now()}}</p> 
  @if($salesType!="")
  <p><b>Sales type: </b>{{$salesType}}</p> 
  @endif
  @if($requestType!="")
  <p><b>Request: </b>{{$requestType}}</p>
  @endif
  <p>Please email us back at qa@cimet.com.au for all rejections and status report.</p>
  <p>Regards</p> 
  <p>QA Team CIMET</p>
@stop

