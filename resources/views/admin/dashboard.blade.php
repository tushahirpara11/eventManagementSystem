@extends('layout.app')
@section('content')
<div class="row">
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('admin.branch')}}">
			<div class="tile-stats tile-red">				
				<div class="num" data-start="0" data-end="{{$branch[0]->count}}" data-postfix="" data-duration="1500" data-delay="0">{{$subEvents[0]->count}}</div>
				<h3>Branch</h3>
			</div>
		</a>
	</div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('admin.stream')}}">
			<div class="tile-stats tile-yellow">				
				<div class="num" data-start="0" data-end="{{$stream[0]->count}}" data-postfix="" data-duration="1500" data-delay="0">{{$subEvents[0]->count}}</div>
				<h3>Stream</h3>
			</div>
		</a>
	</div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('admin.division')}}">
			<div class="tile-stats tile-blue">				
				<div class="num" data-start="0" data-end="{{$division[0]->count}}" data-postfix="" data-duration="1500" data-delay="0">{{$subEvents[0]->count}}</div>
				<h3>Division</h3>
			</div>
		</a>
	</div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('admin.venue')}}">
			<div class="tile-stats tile-aqua">				
				<div class="num" data-start="0" data-end="{{$venue[0]->count}}" data-postfix="" data-duration="1500" data-delay="0">{{$subEvents[0]->count}}</div>
				<h3>Venue</h3>
			</div>
		</a>
	</div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('admin.event')}}">
			<div class="tile-stats tile-cyan">				
				<div class="num" data-start="0" data-end="{{$events[0]->count}}" data-postfix="" data-duration="1500" data-delay="0">{{$subEvents[0]->count}}</div>
				<h3>Events</h3>
			</div>
		</a>
	</div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('admin.subevent')}}">
			<div class="tile-stats tile-orange">				
				<div class="num" data-start="0" data-end="{{$subEvents[0]->count}}" data-postfix="" data-duration="1500" data-delay="0">{{$subEvents[0]->count}}</div>
				<h3>Sub Events</h3>
			</div>
		</a>
	</div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('admin.role')}}">
			<div class="tile-stats tile-pink">				
				<div class="num" data-start="0" data-end="{{$role[0]->count}}" data-postfix="" data-duration="1500" data-delay="0">{{$subEvents[0]->count}}</div>
				<h3>Role</h3>
			</div>
		</a>
	</div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('admin.choreographer')}}">
			<div class="tile-stats tile-green">				
				<div class="num" data-start="0" data-end="{{$choreographer[0]->count}}" data-postfix="" data-duration="1500" data-delay="600">0</div>
				<h3>Choreographer</h3>
			</div>
		</a>
	</div>
	<div class="clear visible-xs"></div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('admin.user')}}">
			<div class="tile-stats tile-plum">				
				<div class="num" data-start="0" data-end="{{$user[0]->count}}" data-postfix="" data-duration="1500" data-delay="1200">0</div>
				<h3>Users</h3>
			</div>
		</a>
	</div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('admin.group')}}">
			<div class="tile-stats tile-gray">				
				<div class="num" data-start="0" data-end="{{$group[0]->count}}" data-postfix="" data-duration="1500" data-delay="1800">0</div>
				<h3>Group</h3>
			</div>
		</a>
	</div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('admin.Expence')}}">
			<div class="tile-stats tile-purple">				
				<div class="num" data-start="0" data-end="{{$expence_type[0]->count}}" data-postfix="" data-duration="1500" data-delay="1800">0</div>
				<h3>Expence Type</h3>
			</div>
		</a>
	</div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('admin.guest')}}">
			<div class="tile-stats tile-brown">				
				<div class="num" data-start="0" data-end="{{$guest[0]->count}}" data-postfix="" data-duration="1500" data-delay="1800">0</div>
				<h3>guest</h3>
			</div>
		</a>
	</div>
</div>
@endsection