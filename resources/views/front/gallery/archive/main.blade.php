@extends('front.frame.frame')

@section('head')
    <title>{{ setting()->ask('site_title')->gain() }} | {{ trans('front.gallery') }}</title>
@endsection

@section('content')
    <style>
        .ehda-card {
            display: none
        }
    </style>
    @include('front.frame.position_info', [
        'group' => 'توانستن',
        'category' => 'گالری',
        'title' => 'آرشیو',
    ])
    <div class="container-fluid">
        <div class="row gallery-archive">
            <div class="container">
                <div class="row mt20 mb20">
                    @for($i = 0; $i < 8; $i++)
                        @include('front.gallery.archive.item')
                    @endfor
                </div>
            </div>
        </div>
    </div>
@endsection