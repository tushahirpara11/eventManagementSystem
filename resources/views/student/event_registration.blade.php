@extends('student/index')
@section('title','Event Registrtion')
@section('head','Event Registrtion')
@section('content')
<div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-primary"><h3>Event Registration<h3></div><br>
                <div class="card-block">
                    <div class="container">
                        <form method="post"  action="/">
                            {{ csrf_field() }}
                            <label for="usr">Select Event :</label> 
                            <select name="s_e_id" class="form-control">
                                @foreach($sub_event as $data)
                                    <option value="{{ $data->s_e_id }}">{{ $data->s_e_name }}</option>
                                @endforeach
                            </select><br>
                            <input type="hidden" name="user_id" value="{{ session('id')}}" />
                            <input type="hidden" name="role_id" value="" />
                            <button type="submit" name="submit" class="btn btn-success">Submit</button><br><br>
                        </form>
                    </div>
                </div>
        </div>
</div>
@stop