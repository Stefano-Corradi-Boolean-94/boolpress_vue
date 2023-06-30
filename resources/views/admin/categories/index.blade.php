@extends('layouts.admin')

@section('content')

<div class="container p-5">

    @if (session('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif


    <h2 class="fs-4 text-secondary my-4">
        Gestions categorie
    </h2>

    <div class="w-50">

        <form action="{{ route('admin.categories.store') }}" method="POST" >
        <div class="input-group mb-3">
                @csrf
                <input type="text" class="form-control" name="name" placeholder="Nuova categoria" aria-label="Nuova categoria" aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fa-solid fa-plus"></i> Add</button>
            </div>
        </form>


       <table class="table">
        <thead>
          <tr>
            <th scope="col">Nome</th>
            <th scope="col">Azioni</th>

            <th scope="col">Num Posts</th>
          </tr>
        </thead>
        <tbody>

            @foreach ($categories as $category)
                <tr>
                    <td>
                        <form
                          action="{{ route('admin.categories.update', $category) }}"
                          method="POST"
                          id="edit_form"
                        >
                            @csrf
                            @method('PUT')
                            <input class="border-0" name="name" type="text" value="{{  $category->name  }}">
                        </form>

                    </td>
                    <td>
                        <button
                          class="btn btn-primary"
                          onclick="submitEditForm()"
                        ><i class="fa-solid fa-floppy-disk"></i></button>
                        @include('admin.partials.form-delete',[
                                                                'title'=>'Eliminazione Categoria',
                                                                'id'=> $category->id,
                                                                'message'=> "Confermi l'eliminazione della categoria $category->name?",
                                                                'route' => route('admin.categories.destroy', $category)
                                                            ])
                    </td>
                    <td>{{ count($category->posts) }}</td>
                </tr>
            @endforeach


        </tbody>
      </table>
    </div>




</div>

<script>
    function submitEditForm(){
        const form = document.getElementById('edit_form');
        form.submit();
    }
</script>

@endsection
