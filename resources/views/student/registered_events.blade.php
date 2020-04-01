@extends('student/index')
@section('title','Registered Events')
@section('head','Registered Events')
@section('content')
<div class="container">
<table class='table  table-hover table-striped'>
    <thead class="table-info">
      <tr>
        <th>Sr.No</th>
        <th>Event Name</th>
        <th>Sub Event Name</th>
        <th>Event Start Date</th>
        <th>Event End Date</th>
        <th>Event Venue</th>
      </tr>
    </thead>
    <tbody>
      @foreach($event_registration as $data)
        <tr>
            <td>{{$loop->index+1}}</td>
             <td>
             @foreach($sub_events as $sub_event)
                @if($data->s_e_id == $sub_event->s_e_id)
                    @foreach($events as $event)
                        @if($sub_event->e_id == $event->e_id)
                            {{$event->e_name}}
                        @endif
                    @endforeach
                @endif
             @endforeach
             </td>
             <td>
             @foreach($sub_events as $sub_event)
                @if($data->s_e_id == $sub_event->s_e_id)
                    {{$sub_event->s_e_name}}
                @endif
             @endforeach
             </td>  
             <td>
             @foreach($sub_events as $sub_event)
                @if($data->s_e_id == $sub_event->s_e_id)
                    @foreach($events as $event)
                        @if($sub_event->e_id == $event->e_id)
                            {{$event->e_start_date}}
                        @endif
                    @endforeach
                @endif
             @endforeach
             </td>    
             <td>
             @foreach($sub_events as $sub_event)
                @if($data->s_e_id == $sub_event->s_e_id)
                    @foreach($events as $event)
                        @if($sub_event->e_id == $event->e_id)
                            {{$event->e_end_date}}
                        @endif
                    @endforeach
                @endif
             @endforeach
             </td> 
             <td>
             @foreach($sub_events as $sub_event)
                @if($data->s_e_id == $sub_event->s_e_id)
                    @foreach($events as $event)
                        @if($sub_event->e_id == $event->e_id)
                            @foreach($vanue as $venue)
                                @if($event->v_id == $venue->v_id)
                                    {{$venue->v_name}}
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @endif
             @endforeach
             </td>     
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@stop