@extends('fclayout.app')
@section('content')
<div class="row">
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('fc.user')}}">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="entypo-users"></i></div>
				<div class="num" data-start="0" data-end="{{$user[0]->count}}" data-postfix="" data-duration="1500" data-delay="1200">0</div>
				<h3>Users</h3>
			</div>
		</a>
	</div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('fc.attendence')}}">
			<div class="tile-stats tile-red">
				<div class="icon"><i class="entypo-list"></i></div>
				<div class="num" data-start="0" data-end="{{$attendence[0]->count}}" data-postfix="" data-duration="1500" data-delay="0">0</div>
				<h3>Attendence</h3>
			</div>
		</a>
	</div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('fc.Expence')}}">
			<div class="tile-stats tile-green">
				<div class="icon"><i class="entypo-user"></i></div>
				<div class="num" data-start="0" data-end="{{$expence[0]->count}}" data-postfix="" data-duration="1500" data-delay="600">0</div>
				<h3>Expence</h3>
			</div>
		</a>
	</div>
	<div class="clear visible-xs"></div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('fc.practiceSchedule')}}">
			<div class="tile-stats tile-blue">
				<div class="icon"><i class="entypo-flow-tree"></i></div>
				<div class="num" data-start="0" data-end="{{$practiceSchedule[0]->count}}" data-postfix="" data-duration="1500" data-delay="1800">0</div>
				<h3>Practice Schedule</h3>
			</div>
		</a>
	</div>
	<div class="col-sm-3 col-xs-6">
		<a href="{{route('fc.costumes')}}">
			<div class="tile-stats tile-cyan">
				<div class="icon"><i class="entypo-clipboard"></i></div>
				<div class="num" data-start="0" data-end="{{$costumes[0]->count}}" data-postfix="" data-duration="1500" data-delay="1800">0</div>
				<h3>Costume</h3>
			</div>
		</a>
	</div>
</div>
@endsection