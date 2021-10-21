@extends('frontend.main_master')

@section('content')
@section('title')
    My checkout Page
@endsection

    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ '/' }}">Home</a></li>
                    <li class='active'>Stripe</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->


    <h2>User Name: {{ $data['user_name'] }}</h2>

@endsection
