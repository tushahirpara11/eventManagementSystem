<ul id="main-menu" class="main-menu">
  <li class="active opened active "> <a href="#"><i class="entypo-gauge"></i><span class="title">Dashboard</span></a>
  </li>
  <li class="has-sub"> <a href="#"><i class="entypo-layout"></i><span class="title">Manage Records</span></a>
    <ul>                  
      <li> <a href="{{route('fc.user')}}"><span class="entypo-layout">User</span></a></li>      
      <li> <a href="{{route('fc.attendence')}}"><span class="entypo-layout">Attendence</span></a></li>      
      <li> <a href="{{route('fc.Expence')}}"><span class="entypo-layout">View Expence</span></a></li>      
      <li> <a href="{{route('fc.practiceSchedule')}}"><span class="entypo-layout">Practice Schedule</span></a></li>      
    </ul>
  </li>
  <li><a href="{{route('fc.logout')}}"><span class="entypo-logout right">Logout</span></a></a></li>
</ul>