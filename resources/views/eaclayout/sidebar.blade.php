<ul id="main-menu" class="main-menu">
	<li class="active opened active "> <a href="{{route('eac.dashboard')}}"><i class="entypo-gauge"></i><span class="title">Dashboard</span></a>
	</li>
	<li class="has-sub"> <a href="#"><i class="entypo-layout"></i><span class="title">Manage Records</span></a>
		<ul>
			<li> <a href="{{route('eac.subevent')}}"><span class="entypo-layout">Sub Event Master</span></a></li>
			<li> <a href="{{route('eac.choreographer')}}"><span class="entypo-layout">Choreographer</span></a></li>
			<!-- <li> <a href="{{route('eac.guest')}}"><span class="entypo-layout">Guest</span></a></li> -->
			<li> <a href="{{route('eac.user')}}"><span class="entypo-layout">User</span></a></li>
			<li> <a href="{{route('eac.group')}}"><span class="entypo-layout">Group</span></a></li>
			<li> <a href="{{route('eac.attendence')}}"><span class="entypo-layout">Attendence</span></a></li>
			<li> <a href="{{route('eac.showschedule')}}"><span class="entypo-layout">Event Scheduling</span></a></li>
			<li> <a href="{{route('eac.Expence')}}"><span class="entypo-layout">Manage Expence</span></a></li>
		</ul>
	</li>
	<li class="has-sub"> <a href="#"><i class="entypo-layout"></i><span class="title">Reports</span></a>
		<ul>
			<li> <a href="{{route('eac.eventReport')}}"><span class="entypo-layout">Event Wise Participate Report</span></a></li>
			<li> <a href="{{route('eac.expenseReport')}}"><span class="entypo-layout">Event Wise Expense</span></a></li>
		</ul>
	</li>
	<li><a href="{{route('eac.logout')}}"><span class="entypo-logout right">Logout</span></a></a></li>
</ul>