@extends('layouts.app')

@section('page-title')
    SMArt image creation
@endsection

@section('content')
<div class="container">
    <img src={{ $image->link }}>
</div>
@endsection
