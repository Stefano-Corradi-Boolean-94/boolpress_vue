@extends('layouts.admin')

@section('content')

<div class="container p-5">

    @if (session('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif


    <h2 class="fs-4 text-secondary my-4">
        Gestions tag
    </h2>

    <div class="w-50">

        <form action="{{ route('admin.tags.store') }}" method="POST" >
        <div class="input-group mb-3">
                @csrf
                <input type="text" class="form-control" name="name" placeholder="Nuovo tag" aria-label="Nuova tag" aria-describedby="button-addon2">
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

            @foreach ($tags as $tag)
                <tr>
                    <td>
                        <form
                          action="{{ route('admin.tags.update', $tag) }}"
                          method="POST"
                          id="edit_form{{ $tag->id }}"
                        >
                            @csrf
                            @method('PUT')
                            <input class="border-0" name="name" type="text" value="{{  $tag->name  }}">
                        </form>

                    </td>
                    <td>
                        <button
                          class="btn btn-primary"
                          onclick="submitEditForm({{ $tag->id }})"
                        ><i class="fa-solid fa-floppy-disk"></i></button>
                        @include('admin.partials.form-delete',[
                                                                'title'=>'Eliminazione Tag',
                                                                'id'=> $tag->id,
                                                                'message'=> "Confermi l'eliminazione del tag $tag->name?",
                                                                'route' => route('admin.tags.destroy', $tag)
                                                            ])
                    </td>
                    <td>{{ count($tag->posts) }}</td>
                </tr>
            @endforeach


        </tbody>
      </table>
    </div>




</div>

<script>
    function submitEditForm(id){
        const form = document.getElementById('edit_form' + id);
        form.submit();
    }
</script>

@endsection
