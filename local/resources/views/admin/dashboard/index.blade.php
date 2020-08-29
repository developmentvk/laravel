@extends('admin.layouts.master')
@section('title') {{ cpTrans('dashboard') }} @endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ cpTrans('dashboard') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ cpTrans('home') }}</a></li>
        <li class="active">{{ cpTrans('dashboard') }}</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    
</section>
<!-- /.content -->
@endsection
@section('scripts')
@endsection
