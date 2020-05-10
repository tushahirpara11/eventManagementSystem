@extends('eaclayout.app')
@section('content')
<div class="row">
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('eac.subevent')}}">
			<div class="tile-stats tile-red">
				<div class="icon"><i class="entypo-list"></i></div>
				<div class="num" data-start="0" data-end="{{$subEvents[0]->count}}" data-postfix="" data-duration="1500" data-delay="0">{{$subEvents[0]->count}}</div>
				<h3>Sub Events</h3>
			</div>
		</a>
	</div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('eac.subevent')}}">
			<div class="tile-stats tile-green">
				<div class="icon"><i class="entypo-user"></i></div>
				<div class="num" data-start="0" data-end="{{$choreographer[0]->count}}" data-postfix="" data-duration="1500" data-delay="600">0</div>
				<h3>Choreographer</h3>
			</div>
		</a>
	</div>
	<div class="clear visible-xs"></div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('eac.user')}}">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="entypo-users"></i></div>
				<div class="num" data-start="0" data-end="{{$user[0]->count}}" data-postfix="" data-duration="1500" data-delay="1200">0</div>
				<h3>Users</h3>
			</div>
		</a>
	</div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('eac.group')}}">
			<div class="tile-stats tile-blue">
				<div class="icon"><i class="entypo-flow-tree"></i></div>
				<div class="num" data-start="0" data-end="{{$group[0]->count}}" data-postfix="" data-duration="1500" data-delay="1800">0</div>
				<h3>Group</h3>
			</div>
		</a>
	</div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('eac.getschedule')}}">
			<div class="tile-stats tile-cyan">
				<div class="icon"><i class="entypo-clipboard"></i></div>
				<div class="num" data-start="0" data-end="{{$schedule[0]->count}}" data-postfix="" data-duration="1500" data-delay="1800">0</div>
				<h3>Scheduling</h3>
			</div>
		</a>
	</div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('eac.Expence')}}">
			<div class="tile-stats tile-purple">
				<div class="icon"><i class="entypo-clipboard"></i></div>
				<div class="num" data-start="0" data-end="{{$expence[0]->count}}" data-postfix="" data-duration="1500" data-delay="1800">0</div>
				<h3>Expence</h3>
			</div>
		</a>
	</div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('eac.guest')}}">
			<div class="tile-stats tile-brown">
				<div class="icon"><i class="entypo-users"></i></div>
				<div class="num" data-start="0" data-end="{{$guest[0]->count}}" data-postfix="" data-duration="1500" data-delay="1800">0</div>
				<h3>guest</h3>
			</div>
		</a>
	</div>
</div>
@endsection