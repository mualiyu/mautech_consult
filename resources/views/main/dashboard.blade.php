@extends('layouts.index')

@section('content')
<div class="container-fluid">
    @if (session('message'))
        <div class="alert alert-success" role="alert">
            {{ $message}}
        </div>
    @endif
    @if (session('erro'))
        <div class="alert alert-warning" role="alert">
            {{ $error}}
        </div>
    @endif
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active"></li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            
        </div>
    </div>
    <div style="height: 100vh;"></div>
    <div class="card mb-4"><div class="card-body">When scrolling, the navigation stays at the top of the page. This is the end of the static navigation demo.</div></div>
</div>
@endsection