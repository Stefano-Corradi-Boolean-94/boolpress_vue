@extends('layouts.admin')

@section('content')
<div class="container p-5">
    <div  class="mb-5">
        <h2 class="fs-4 text-secondary my-4">
        Home dashboard
        </h2>
        <p>Numero post presenti: {{ $n_posts }}</p>

        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Crea nuovo post</a>
    </div>

@if ($last_post)
    <h5>Ultimo post</h5>
   <div>
        <h6>{{ $last_post?->title }}
            <a href="{{ route('admin.posts.show', $last_post) }}" class="btn btn-success"><i class="fa-regular fa-eye"></i></a>
            <a href="{{ route('admin.posts.edit', $last_post) }}" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></a>
        </h6>
        <div>
            <img class="w-50" src="{{ asset('storage/' . $last_post?->image_path) }}" alt="{{ $last_post?->title }}"  onerror="this.src='/img/noimage.jpg'">
        </div>
        <p>{!! $last_post?->text !!}</p>

    </div>

    </div>
@endif

@endsection
