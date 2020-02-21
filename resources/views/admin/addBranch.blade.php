@extends('layout.app')
@section('content')
<h2>Add Branch</h2> <br />
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
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-primary" data-collapsed="0">
      <div class="panel-heading">
        <div class="panel-title">
          Branch Field
        </div>       
      </div>
      <div class="panel-body">
        <form role="form" method="POST" action="/admin/branch" class="form-horizontal form-groups-bordered">
          {{csrf_field()}}
          <div class="form-group"> <label for="branchCode" class="col-sm-3 control-label">Branch Code</label>
            <div class="col-sm-5"> <input type="text" oncopy="return false" oncut="return false" onpaste="return false" name="b_code" class="form-control" id="b_code" placeholder="Enter Branch Code">
            </div>
          </div>
          <div class="form-group"> <label for="branchName" class="col-sm-3 control-label">Branch Name</label>
            <div class="col-sm-5"> <input type="text" oncopy="return false" oncut="return false" onpaste="return false" name="b_name" class="form-control" id="b_name" placeholder="Enter Branch Name">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
              <button type="submit" class="btn btn-info">Add Branch</button>
              <button type="reset" class="btn btn-danger">Clear</button>
            </div>            
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection