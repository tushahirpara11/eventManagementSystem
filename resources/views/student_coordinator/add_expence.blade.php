@extends('student_coordinator/index')
@section('title','Add Expence')
@section('head','Add Expence')
@section('content')
<style>
    .error{
        color:red;
    }
</style>
@if (session('success'))
<div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>{{ Session::get('success') }}</strong>
</div>
@endif
<div class="col-lg-6">
    <div class="card">
        <div class="card-header bg-primary"><h3>Add Expence<h3></div><br>
            <div class="card-block">
                <div class="container">
                    <form method="post" id="add_expence" action="/student_coordinator/add_expence">
                        {{ csrf_field() }}
                            <select class="form-control" name="event" id="event">
                                <option value="Select Event">Select Event</option>
                                @foreach ($events as $event)
                                    <option value="{{$event->e_id}}">{{$event->e_name}}</option>
                                @endforeach
                            </select><br>
                            <select class="form-control" name="sub_event" id="sub_event">
                            <option value="Select Sub_Event">Select Sub Event</option>
                                @foreach ($sub_events as $sub_event)
                                    <option value="{{$sub_event->s_e_id}}">{{$sub_event->s_e_name}}</option>
                                @endforeach
                            </select><br>
                            <select class="form-control" name="expence_type" id="expence_type">
                                <option value="Select Expence_Type">Select Expence Type</option>
                                @foreach ($expence_type as $expence)
                                    <option value="{{$expence->e_t_id}}">{{$expence->name}}</option>
                                @endforeach
                            </select><br>
                            <input type="hidden" name="u_id" value="{{session('coordinator')}}">
                            <input type="hidden" name="status" value="0">
                            <input type="number" id="amount" class="form-control" name="amount" placeholder="Enter Amount"><br>
                            <textarea class="form-control" id="desc" name="desc" placeholder="Enter Description"></textarea><br>

                            <button type="submit" name="submit" class="btn btn-success">Submit</button><br><br>
                    </form>
                </div>
            </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $("#add_expence").submit(function(e) {
        let event = $("#event").val();
        let sub_event = $("#sub_event").val();
        let expence = $("#expence_type").val();
        let amount = $("#amount").val();
        let desc = $("#desc").val();
      $(".error").remove();
      // return false;
      if (event == "") {
        e.preventDefault();
        $("#event").after(
          '<span class="error">This field is required</span>'
        );
      }else if(event == "Select Event")
      {
        e.preventDefault();
        $("#event").after(
          '<span class="error">please select appropriate event</span>'
        );
      }
      if(sub_event == ""){
        e.preventDefault();
        $("#sub_event").after(
          '<span class="error">This field is required</span>'
        );
      }else if(sub_event == "Select Sub_Event")
      {
        e.preventDefault();
        $("#sub_event").after(
          '<span class="error">please select appropriate sub event</span>'
        );
      }
      if(expence == ""){
        e.preventDefault();
        $("#expence_type").after(
          '<span class="error">This field is required</span>'
        );
      }else if(expence == "Select Expence_Type")
      {
        e.preventDefault();
        $("#expence_type").after(
          '<span class="error">please select appropriate Expence Type</span>'
        );
      }
      if(amount <= 0){
        e.preventDefault();
        $("#amount").after(
          '<span class="error">please Enter Valid Amount</span>'
        );
      } 
      if(desc == ""){
        e.preventDefault();
        $("#desc").after(
          '<span class="error">This field is required</span>'
        );
      }
    });
  });
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
  $("select[name='event']").change(function() {
    $("#sub_event").html('');
    var event = $(this).val();
    var token = $("input[name='_token']").val();
    $.ajax({
      url: "<?php echo route('ajaxevent') ?>",
      method: 'POST',
      data: {
        e_id: event,
        _token: token
      },
      success: function(option) {
        for (i = 0; i < option.option.length; i++) {
          $("#sub_event").append(`<option value="${option.option[i].s_e_id}">${option.option[i].s_e_name} </option>`);
        }
      }
    });
  });
</script>
@stop