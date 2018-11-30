@extends('layouts.main')

@section('content')
    <div id="trends-content">
        <div class="block-header">
            <h2 style="display: inline;">TRENDING TOPICS</h2>
        </div>
        <div class="row">
            <div class="col-md-4 col-xs-12 col-lg-4 col-sm-4">
                <div class="card">
                    <div class="header">
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <h2>Twitter Trending</h2>
                                <img src="{{ asset('icons/media/Twitter.png') }}" alt="Twitter Logo" class="trending-logo">
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="panel-group" id="accordion_twit" role="tablist" aria-multiselectable="true">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-12 col-lg-4 col-sm-4">
                <div class="card">
                    <div class="header">
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <h2>Google Trending</h2>
                                <img src="{{ asset('icons/media/google.png') }}" alt="Twitter Logo" class="trending-logo">
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="panel-group" id="accordion_goo" role="tablist" aria-multiselectable="true">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-12 col-lg-4 col-sm-4">
                <div class="card">
                    <div class="header">
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <h2>Youtube Trending</h2>
                                <img src="{{ asset('icons/media/youtube.png') }}" alt="Twitter Logo" class="trending-logo">
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="panel-group" id="accordion_you" role="tablist" aria-multiselectable="true">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-script')
    <script src="{{ asset('js/request/trends.js') }}"></script>
@endsection
