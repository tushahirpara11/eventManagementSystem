@extends('student/index')
@section('title','Event Registrtion')
@section('head','Event Registrtion')
@section('content')
<div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-primary"><h3>Event Registration<h3></div><br>
                <div class="card-block">
                    <div class="container">
                        <form method="post"  action="/student/event_registration">
                            {{ csrf_field() }}
                            <label for="usr">Select Event :</label> 
                            <select name="s_e_id" class="form-control">
                                @foreach($sub_event as $data)
                                    <option value="{{ $data->s_e_id }}">{{ $data->s_e_name }}</option>
                                @endforeach
                            </select><br>
                            <input type="hidden" name="user_id" value="{{ session('id') }}" />
                            <label for="group">Event Faculty:</label> 
                            <select disabled style="pointer-events:disabled;" name="u_name" id="u_name" class="form-control">                                
                            </select>                            
                            <input type="hidden" id="g_id" name="g_id" value=""/>
                            <br/>
                            <label for="usr">Want To be An volunteer :</label> &nbsp;
                            <input type="checkbox" id="volunteer" name="volunteer" value="" />
                            <br/>
                            <input type="hidden" id="role_id" name="role_id" value="5" />                            
                            <button type="submit" name="submit" class="btn btn-success">Submit</button><br><br>
                        </form>
                    </div>
                </div>
        </div>
</div>
<script>
 $("select[name='s_e_id']").click(function () {
    $("#u_name").html('');
    var s_e_id = $(this).val();
    var token = $("input[name='_token']").val();
    $.ajax({
      url: "<?php echo route('ajaxGroup') ?>",
      method: 'POST',
      data: { s_e_id: s_e_id, _token: token },
      success: function (option) {       
        for(var i=0;i<option.option.length;i++){          
            for(var j=0;j<option.user.length;j++){          
                $("#u_name").append(`<option value="${option.option[i].g_id}">${option.user[j].f_name} ${option.user[j].l_name} </option>`);                
                $("#g_id").val(option.option[i].g_id);                
            }        
        }        
      }
    });
  });
</script>
<script>
$('#volunteer').click(function(){
if($(this).prop("checked") == true){
$('#role_id').val('4');
}
else{
$('#role_id').val('5');
}
    })
</script>
@stop