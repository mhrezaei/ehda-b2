@extends('manage.frame.use.0')

@section('section')
	<div id="divTab">
		@include('manage.posts.tabs')
	</div>

	@include("manage.frame.widgets.toolbar" , [
//		'title' => $page[0][1].' / '.$page[1][1].' / '.$page[2][1],
		'buttons' => [
			[
				'target' => url("manage/posts/$posttype->slug/create/$locale"),
				'type' => "success",
				'caption' => trans('forms.button.add_to').' '.$posttype->title ,
				'icon' => "plus-circle",
			],
		],
		'search' => [
			'target' => url("manage/posts/$posttype->slug/$locale/search"),
			'label' => trans('forms.button.search'),
			'value' => isset($keyword)? $keyword : '' ,
		],
	])

	@include("manage.frame.widgets.grid" , [
		'table_id' => "tblPosts",
		'row_view' => "manage.posts.browse-row",
		'handle' => "selector",
		'headings' => [
			trans('validation.attributes.title'),
			[trans('validation.attributes.price'),'', $posttype->hasFeature('price')],
			trans('validation.attributes.status'),
			trans('forms.button.action')
		],
	])

@endsection


