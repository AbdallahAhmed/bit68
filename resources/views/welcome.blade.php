@extends('partials.app')
@section('title','Login')
@section('content')
    <div class="content">
        <form method="post" action="{{route('login')}}">
            {{csrf_field()}}
            <h1>Login</h1>
            <div class="form-group">
                <input class="form-control" value="{{\Request::old('email')}}" type="email" name="email">
                <input class="form-control" type="password" name="password">
                <button type="submit">Login</button>
            </div>
        </form>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection