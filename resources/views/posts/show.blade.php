@extends('layouts.master')

@section('content')

  <div class="col-sm-8 blog-main">

    <h1>{{ $post->title }}</h1>

    {{ $post->body }}

    <div class="comments">
      <hr>
        @foreach ($post->comments as $comment)
          <ul class="list-group">

            <li class='list-group-item'>
                <strong>
                {{ $comment->created_at->diffforHumans() }}:
                </strong>
                {{ $comment->body }}
            </li>
        @endforeach
        </ul>
    </div>

{{-- Add a comment --}}
  <hr>
    <div class="card">
      <div class="card-block">
        <form method="POST" action="{{ $post->id }}/comments">
          {{ csrf_field() }}
          <div class="form-group">
            <textarea name="body" placeholder="Add your Comment here!" class="form-control"></textarea>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">Publish</button>
          </div>
        </form>
      </div>
    </div>

  </div>
@endsection
