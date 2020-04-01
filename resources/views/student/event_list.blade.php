@extends('student/index')
@section('title','Events')
@section('head','Events')
@section('content')
@if (session('success'))
<div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>{{ Session::get('success') }}</strong>
</div>
@endif
@if (session('error'))
<div class="alert alert-danger alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>{{ Session::get('error') }}</strong>
</div>
@endif
<div class="container">
<table class='table  table-hover table-striped'>
    <thead class="table-info">
      <tr>
        <th>Sr.No</th>
        <th>Event Name</th>
        <th>Discription</th>
        <th>Date</th>
        <th>End Date</th>
        <th>Apply</th>
      </tr>
    </thead>
    <tbody>
      @foreach($events as $data)
        <tr>
          <td>{{$loop->index+1}}</td>
          <td>{{$data->e_name}}</td>
          <td>{{$data->e_discription}}</td>
          <td>{{$data->e_start_date}}</td>
          <td>{{$data->e_end_date}}</td>
          <td>
          <form method="post" action="/student/sub_event_list">
          {{ csrf_field() }}
            <input type="hidden" name="e_id" value="{{ $data -> e_id }}" />
            <input type="submit" name="submit" class="btn btn-primary" value="Register" />
          </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@stop