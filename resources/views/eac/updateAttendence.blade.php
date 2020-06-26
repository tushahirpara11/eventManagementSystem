@extends('eaclayout.app')
@section('content')
<h3>Update Attendece</h3> <br />
<script type="text/javascript">
  jQuery(document).ready(function($) {
    var $table4 = jQuery("#table-4");
    var table4 = $table4.DataTable({
      "aLengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      dom: 'Bfrtip',
      buttons: [
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
      ]
    });
    // Initalize Select Dropdown after DataTables is created
    $table4.closest('.dataTables_wrapper').find('select').select2({
      minimumResultsForSearch: -1
    });
    // Setup - add a text input to each footer cell
    $('#table-4 tfoot th').each(function() {
      var title = $('#table-4 thead th').eq($(this).index()).text();
      $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
    });
    // Apply the search
    table4.columns().every(function() {
      var that = this;
      $('input', this.footer()).on('keyup change', function() {
        if (that.search() !== this.value) {
          that
            .search(this.value)
            .draw();
        }
      });
    });
  });
</script>
<form id="submitAttendece" method="POST">
  {{csrf_field()}}
  <input type="hidden" value="{{$attendence[0]->present}}" id="hiddenPresent" />
  <table class="table table-bordered datatable" id="table-4">
    <thead>
      <tr>
        <th class="col-xs-1">#No.</th>
        <th class="col-xs-1">Enrollment No.</th>
        <th class="col-xs-1">Name</th>
        <th class="col-xs-1">Date</th>
        <th class="col-xs-1">Present</th>
      </tr>
    </thead>
    <tbody>
      @for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
        <!-- {{$flag=0}} -->
        <td>{{$i+1}}</td>
        <td>{{$data[$i]->enrollmentno}}</td>
        <td>{{$data[$i]->f_name}} {{$data[$i]->l_name}}</td>
        <input type="hidden" value="{{$attendence[0]->s_e_id}}" name="subEventId">
        <input type="hidden" value="{{$attendence[0]->date}}" name="eventDate">
        @for($k = 0; $k < count($attendence); $k++) <td>{{$attendence[$k]->date}}</td>
          @endfor
          <td>
						@for($j = 0; $j < count($present); $j++)						
						@if($data[$i]->u_id == $present[$j])
              <!-- {{$flag=1}} -->
              @break
              @endif
              @endfor
              @if($flag==1)
              <input type="checkbox" value="{{$data[$i]->u_id}}" checked onclick="getchecked(this);" class="form-control" name="present" />
              @else
              <input type="checkbox" value="{{$data[$i]->u_id}}" onclick="getchecked(this);" class="form-control" name="present" />
              @endif
          </td>
          </tr>
          @endfor
    </tbody>
    <tfoot>
      <tr>
        <th></th>
        <th>Enrollment No.</th>
        <th>Name</th>
        <th>Date</th>
        <th></th>
      </tr>
    </tfoot>
  </table>
  <br />
  <div style="margin-left: 35%">
    <button type="submit" class="btn btn-primary">Update Attendence</button>
  </div>
</form>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
  const yourArray = [];
  if (JSON.parse($("#hiddenPresent").val()) !== null) {
    for (let i = 0; i < JSON.parse($("#hiddenPresent").val()).length; i++) {
      yourArray.push(parseInt(JSON.parse($("#hiddenPresent").val())[i]));
    }
  }

  function getchecked(id) {
    if ($(id)[0].checked === true) {
      yourArray.push(parseInt($(id).val()));
    } else {
      yourArray.splice(yourArray.indexOf($(id).val()), 1);
    }
  }
  $(document).ready(function() {
    $("#submitAttendece").submit(function(e) {
      e.preventDefault()
      $.ajax({
        url: "<?php echo route('eac.updateattendence'); ?>",
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          s_e_id: $("input[name=subEventId]").val(),
          present: yourArray,
          date: $("input[name=eventDate]").val()
        },
        success: function(url) {
          if (url.flag == 0 || url.flag == 1) {
            window.location = 'http://127.0.0.1:8080/eac/attendence';
          }
        }
      });
    });
  });
</script>
@endsection