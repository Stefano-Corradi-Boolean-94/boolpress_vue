@extends('layouts.admin')

@section('content')

<div class="container p-5">
    <h2 class="fs-4 text-secondary my-4">
        {{ $post->title }}
        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></a>
        @include('admin.partials.form-delete',[
                                                                'title'=>'Eliminazione Post',
                                                                'id'=> $post->id,
                                                                'message'=> "Confermi l'eliminazione del post $post->title?",
                                                                'route' => route('admin.posts.destroy', $post)
                                                            ])
    </h2>
    <p>{{ $data_formatted }}</p>
    <div>
        <span>Categoria:</span>
        <span class="badge text-bg-primary">{{ $post->category?->name }}</span>
    </div>
    <div>
        <span>Tag:</span>
        @forelse ($post->tags as $tag)
            <span class="badge text-bg-warning"> {{ $tag->name }} </span>
        @empty
            <span> - no tag -</span>
        @endforelse

    </div>
    <p>
        {!! $post->text !!}
    </p>
    <div>
        <img class="w-50" src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}"  onerror="this.src='/img/noimage.jpg'">
    </div>
    <p>{{ $post->image_original_name }}</p>

</div>

@endsection
