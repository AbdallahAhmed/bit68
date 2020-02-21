@extends('partials.app')
@section('title','Weather')
@section('content')
    <div class="content">
        <form method="post" action="{{route('weather')}}">
            {{csrf_field()}}
            <h1>Get City Weather Conditions</h1>
            <div class="form-group">
                <input required class="form-control" value="{{$city ? $city : ''}}" type="text" name="city">
                <button type="submit">Search</button>
            </div>
        </form>
        @if($city)
            <Label>Temperature: {{$temperature}}</Label><br>
            <Label>humidity: {{$humidity}}</Label><br>
            <Label>clouds: {{$clouds}}</Label><br>
            <Label>pressure: {{$pressure}}</Label><br>
            <Label>Wind-Speed: {{$wind_speed}}</Label><br>
            <Label>Wind-Direction: {{$wind_direction}}</Label>
        @endif
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