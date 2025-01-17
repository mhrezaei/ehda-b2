@include('manage.frame.widgets.sidebar-link' , [
	'icon' => 'dashboard' ,
	'caption' => trans('manage.dashboard') ,
	'link' => 'index' ,
])

{{--
|--------------------------------------------------------------------------
| Automatic Posts Menu
|--------------------------------------------------------------------------
|
--}}

@foreach(Manage::sidebarPostsMenu() as $item)
	@include("manage.frame.widgets.sidebar-link" , $item)
@endforeach

{{--
|--------------------------------------------------------------------------
| Comments
|--------------------------------------------------------------------------
|
--}}
@include("manage.frame.widgets.sidebar-link" , [
	'caption' => trans('posts.comments.users_comments') ,
	'link' => "comments" , 
	'permission' => "comments",
	'icon' => "comment",
])



{{--
|--------------------------------------------------------------------------
| Automatic Users Menu
|--------------------------------------------------------------------------
|
--}}

@foreach(Manage::sidebarUsersMenu() as $item)
	@include("manage.frame.widgets.sidebar-link" , $item)
@endforeach

{{--
|--------------------------------------------------------------------------
| Folded Settings
|--------------------------------------------------------------------------
|
--}}

@include("manage.frame.widgets.sidebar-link" , [
	'icon' => "cogs",
	'link' => "jafarz",
	'sub_menus' => Manage::sidebarSettingsMenu() ,
	'caption' => trans('settings.site_settings'),
])
