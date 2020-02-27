@extends('student/index')
@section('title','Events')
@section('head','Events')
@section('content')
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
          <td><button name="apply" class="btn btn-success" value="Apply">Register</button></td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@stop