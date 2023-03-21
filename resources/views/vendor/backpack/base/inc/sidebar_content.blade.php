<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

<li class="treeview">
  <a href="#"><i class="fa fa-tag"></i> <span>Crawler</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
    <li><a href='{{ backpack_url('crawlerWebsite') }}'><i class='fa fa-tag'></i> <span>Site</span></a></li>
    <li><a href='{{ backpack_url('crawlerPage') }}'><i class='fa fa-tag'></i> <span>Page</span></a></li>
    <li><a href='{{ backpack_url('crawlerPost') }}'><i class='fa fa-tag'></i> <span>Post</span></a></li>
    <li><a href='{{ backpack_url('crawlerCategory') }}'><i class='fa fa-tag'></i> <span>Category</span></a></li>
    <li><a href='{{ backpack_url('crawlerTag') }}'><i class='fa fa-tag'></i> <span>Tag</span></a></li>
  </ul>
</li>

<li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
<li><a href="{{backpack_url('page') }}"><i class="fa fa-file-o"></i> <span>Pages</span></a></li>


@if(backpack_user()->can('Read Permission'))
  <li><a href="{{ backpack_url('log') }}"><i class="fa fa-terminal"></i> <span>Logs</span></a></li>
  <li><a href='{{ url(config('backpack.base.route_prefix', 'admin').'/backup') }}'><i class='fa fa-hdd-o'></i> <span>Backups</span></a></li>
  <li><a href='{{ url(config('backpack.base.route_prefix', 'admin') . '/setting') }}'><i class='fa fa-cog'></i> <span>Settings</span></a></li>
  <!-- Users, Roles Permissions -->
  <li class="treeview">
    <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
      <li><a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
      <li><a href="{{ backpack_url('role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
      <li><a href="{{ backpack_url('permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
    </ul>
  </li>
@endif



<li><a href="https://neverj.com" target="_blank"><i class="fa fa-plane"></i> <span>NeverJ</span></a></li>