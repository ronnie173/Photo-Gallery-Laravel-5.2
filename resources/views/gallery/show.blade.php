@extends('layouts/main')


@section('content')

    <div class="callout primary">
        <div class="row column">
            <a href="/">Back To Galleries</a>
            <h1>{{$gallery->name}}</h1>
            <p class="lead">{{$gallery->description}}</p>
            @if(Auth::check())
                <a class="button" href="/photo/create/{{$gallery->id}}">Upload Photo </a>
            @endif

        </div>
    </div>
    <div class="row small-up-2 medium-up-3 large-up-4">

        @foreach($photos as $photo)
            <div class="column">
                <a href="/photo/details/{{$photo->id}}">
                    <img class="thumbnail" src="/images/{{$photo->image}}">
                </a>
                <h5>{{$photo->title}}</h5>
                <p>{{$photo->description}}</p>
            </div>
        @endforeach
    </div>

@stop