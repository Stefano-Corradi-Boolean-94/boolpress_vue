@extends('layouts.admin')

@section('content')

<div class="container p-5">

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <h2 class="fs-4 text-secondary my-4">
        {{ $title }}
    </h2>

    <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method($method)

        <div class="mb-3">
            <label for="title" class="form-label">Titolo post</label>
            <input
              id="title"
              name='title'
              value="{{ old('title', $post?->title) }}"
              class="form-control @error('title') is-invalid @enderror"
              placeholder="Titolo"
              type="text"
            >
            @error('title')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Categorie</label>
            <select class="form-select" name="category_id" >
                <option value="" >Selezionare una categoria</option>
                @foreach ($categories as $category)
                    <option
                      value="{{ $category->id }}"
                      @if($category->id == old('category_id', $post?->category?->id)) selected @endif
                    >{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <p  class="form-label">Tag</p>
            <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">

                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">

                    @foreach ($tags as $tag)
                        <input
                          id="tag{{ $loop->iteration }}"
                          class="btn-check"
                          autocomplete="off"
                          type="checkbox"
                          value="{{ $tag->id }}"
                          name="tags[]"

                          @if (!$errors->any() && $post?->tags->contains($tag))
                            checked
                          @elseif ($errors->any() && in_array($tag->id, old('tags',[])))
                            checked
                          @endif
                        >
                        <label class="btn btn-outline-primary" for="tag{{ $loop->iteration }}">{{ $tag->name }}</label>
                    @endforeach

                  </div>

            </div>
        </div>

        <div class="mb-3">
            <label for="text" class="form-label">Testo</label>
            <textarea
              id="text"
              class="post-text"
              cols="50"
              name="text"
              rows="20"
            >{{ old('text', $post?->text) }}</textarea>
            @error('text')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input
              class="form-control mb-3"
              onchange="showImage(event)"
              id="image"
              name='image'
              type="file"
            >

            <img width="150" id="prev-image" src="{{ asset('storage/' . $post?->image_path) }}" onerror="this.src='/img/noimage.jpg'">
            <div>
                <input type="radio" name="noImage" onchange="removeImage()"> <label for="">No image</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="reading_time" class="form-label">Tempo di lettura</label>
            <input
              id="reading_time"
              name='reading_time'
              value="{{ old('reading_time', $post?->reading_time) }}"
              class="form-control"
              placeholder=""
              type="number"
            >
        </div>

        <button type="submit" class="btn btn-success">Invia</button>

    </form>


</div>

    <script>
        ClassicEditor
            .create( document.querySelector( '#text' ) )
            .catch( error => {
                console.error( error );
            } );

        function showImage(event){
            const tagImage = document.getElementById('prev-image');
            tagImage.src = URL.createObjectURL(event.target.files[0]);
        }

        function removeImage(){
            const imageInput = document.getElementById('image');
            imageInput.value = '';
            const tagImage = document.getElementById('prev-image');
            tagImage.src = '';
        }
    </script>

@endsection
