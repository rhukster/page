@extends('master')

@section('title', $title)

@section('header')
    <header>
        @include('parts.navbar')

        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div id="w2d">
                        <div id="painter"></div>
                        <div id="cleaner"></div>
                    </div><!-- w2d -->

                    <div id="header-content">
                        <h1>{{ __('messages.header.why') }}</h1>

                        <div id="token-sale-timer">
                            {!! __('messages.header.token-sale') !!}
                        </div><!-- token-sale-timer -->

                        <div id="header-buttons">
                            @spaceless
                            <a href="#" class="btn btn-default btn-lg">{{ __('messages.header.sign-up') }}</a>
                            <a href="#" class="btn btn-white btn-lg">{{ __('messages.header.whitepaper') }}</a>
                            @endspaceless
                        </div><!-- header-buttons -->

                        <h2>{{ __('messages.header.official') }}</h2>
                    </div><!-- header-content -->
                </div><!-- col -->
            </div><!-- row -->
        </div><!-- container -->
    </header>
@endsection

@section('content')
    {{--<div id="penis">--}}
    {{--<penis></penis>--}}
    {{--</div>--}}

    @include('parts.about')
    @include('parts.mission')
    @include('parts.whitepaper')
    @include('parts.roadmap')
    @include('parts.subscribe')
    @include('parts.team')
    @include('parts.companies')
    @include('parts.advisors')
    @include('parts.dj')
@endsection

@section('footer')
    @include('parts.footer')
@endsection