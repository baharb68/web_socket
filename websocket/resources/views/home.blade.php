@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <example-component :users="{{$users}}" :current_user="{{\Illuminate\Support\Facades\Auth::user()}}"></example-component>
        </div>
    </div>
</div>
@endsection
