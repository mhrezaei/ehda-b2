@include('manage.frame.widgets.grid-rowHeader' , [
	'refresh_url' => "manage/users/update/$model->id"
])

{{--
|--------------------------------------------------------------------------
| Name
|--------------------------------------------------------------------------
|
--}}

<td>
	@include("manage.frame.widgets.grid-text" , [
		'text' => $model->full_name,
		'link' => $model->canEdit()? "modal:manage/users/act/-id-/edit" : '',
	])
</td>


{{--
|--------------------------------------------------------------------------
| Status
|--------------------------------------------------------------------------
|
--}}
<td>
	{{-- when specific role is given.--}}
	@if(false)  {{--and $request_role!='all')--}}
		@include("manage.frame.widgets.grid-text" , [
			'fake' => $status = $model->as($request_role)->status ,
			'text' => trans("forms.status_text.$status"),
			'color' => trans("forms.status_color.$status"),
			'icon' => trans("forms.status_icon.$status"),
			'link' => $model->is_not_a('dev')? "modal:manage/users/act/-id-/roles/" : '',
		])

	{{-- When viewing all users --}}
	@else
		{{ '' , $roles = $model->roles() }}

		@if($roles->count() > 0) {{-- <~~ when at least one role is defined. --}}
			@foreach($roles->get() as $role)
				@include("manage.frame.widgets.grid-text" , [
					'fake' => $status = $model->as($role->slug)->status ,
					'text' => $role->title . ': ' . trans("forms.status_text.$status"),
					'color' => trans("forms.status_color.$status"),
					'icon' => trans("forms.status_icon.$status"),
					'link' => $model->is_not_a('dev')? "modal:manage/users/act/-id-/roles/" : '',
				])
			@endforeach


		@else  {{-- <~~ when no role is defined. --}}
			@include("manage.frame.widgets.grid-text" , [
				'text' => trans('people.without_role'),
				'color' => "gray",
				'size' => "10",
				'link' => $model->is_not_a('dev')? "modal:manage/users/act/-id-/roles/" : '',
			])
		@endif
	@endif
</td>


{{--
|--------------------------------------------------------------------------
| Action Button
|--------------------------------------------------------------------------
|
--}}

@include("manage.frame.widgets.grid-actionCol" , [ 'actions' => [
	['pencil' , trans('forms.button.edit') , "modal:manage/users/act/-id-/edit" , $model->canEdit()],
	['key' , trans('people.commands.change_password') , "modal:manage/users/act/-id-/password" , !$model->trashed() and $model->canEdit() ] ,
	['shield' , trans('people.commands.permit') , "modal:manage/users/act/-id-/permit" , $model->is_not_a('dev') and $model->canPermit()],

//	['ban' , trans('people.commands.block') , 'modal:manage/users/act/-id-/roles' ,  $model->as($request_role)->canDelete()] ,
//	['undo' , trans('people.commands.unblock') , 'modal:manage/admins/-id-/undelete'  , !$model->as($request_role)->enabled()] ,
//	['times' , trans('forms.button.hard_delete') , 'modal:manage/admins/-id-/destroy' , !$model->as($request_role)->enabled()] ,

	['user' , trans('people.commands.login_as') , 'modal:manage/users/act/-id-/login_as' , user()->isDeveloper() ] ,
]])