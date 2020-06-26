<ul id="main-menu" class="main-menu">
      <li class="active opened active "> <a href="{{route('admin.dashboard')}}"><i class="entypo-gauge"></i><span class="title">Dashboard</span></a>
      </li>
      <li class="has-sub"> <a href="../../layouts/layout-api/index.html"><i class="entypo-layout"></i><span class="title">Manage Records</span></a>
            <ul>
                  <li> <a href="{{route('admin.branch')}}"><span class="entypo-layout">Branch Master</span></a> </li>
                  <li> <a href="{{route('admin.stream')}}"><span class="entypo-layout">Stream Master</span></a></li>
                  <li> <a href="{{route('admin.division')}}"><span class="entypo-layout">Division Master</span></a></li>
                  <li> <a href="{{route('admin.venue')}}"><span class="entypo-layout">Venue Master</span></a></li>
                  <li> <a href="{{route('admin.event')}}"><span class="entypo-layout">Event Master</span></a></li>
                  <li> <a href="{{route('admin.subevent')}}"><span class="entypo-layout">Sub Event Master</span></a></li>
                  <li> <a href="{{route('admin.role')}}"><span class="entypo-layout">Role Master</span></a></li>
                  <li> <a href="{{route('admin.choreographer')}}"><span class="entypo-layout">Choreographer</span></a></li>
                  <!-- <li> <a href="{{route('admin.guest')}}"><span class="entypo-layout">Guest</span></a></li> -->
                  <li> <a href="{{route('admin.user')}}"><span class="entypo-layout">User</span></a></li>
                  <li> <a href="{{route('admin.group')}}"><span class="entypo-layout">Group</span></a></li>
                  <li> <a href="{{route('admin.Expence')}}"><span class="entypo-layout">Expence Type</span></a></li> 
                  <li> <a href="{{route('admin.report')}}"><span class="entypo-layout">Reports</span></a></li>                 
            </ul>
      </li>
      <li> <a href="/admin/logout"><span class="entypo-logout">Log Out</span> </a> </li>
</ul>