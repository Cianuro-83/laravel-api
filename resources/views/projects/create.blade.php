@extends('layouts.app')

@section('content')

<div class="container">
  @if(request()->session()->exists('message'))
  <div class="alert alert-primary" role="alert">
    {{ request()->session()->pull('message') }}
  </div>
  @endif

</div>
<div class="container">
    <h1 class="py-3 text-uppercase text-center font-weight-bolder text-warning">aggiungi un nuovo lavoro</h1>
<div class="row">
    <div class="col-12">
        <form action="{{route("projects.store")}}" method="POST">
          @csrf
        
          <div class="row mb-3">
              <label for="title" class="col-sm-2 col-form-label">TITOLO</label>
              <div class="col-sm-10">
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                @error('title')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
            </div>

            <div class="row mb-3 ">
              <label for="type" class="col-sm-2 col-form-label">TIPOLOGIA</label>
              <div class="col-sm-10">
                <select class="form-select @error('type_id') is-invalid @enderror" id="type-id" name="type_id" aria-label="Default select example">
                  <option value="" selected>Seleziona una Tipologia</option>
                  @foreach ($types as $type)
                    <option @selected( old('type_id') == $type->id ) value="{{ $type->id }}">{{ $type->name }}</option>
                  @endforeach
                </select>
                @error('type_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
              @enderror
            </div>
          </div>

            <div class="row my-3">
                <label for="customer" class="col-sm-2 col-form-label">CLIENTE</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control @error('customer') is-invalid @enderror" id="customer" name="customer" value="{{ old('customer') }}">
                  @error('customer')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="url" class="col-sm-2 col-form-label">URL</label>
                <div class="col-sm-10">
                  <input type="url" class="form-control @error('url') is-invalid @enderror" id="url" name="url" value="{{ old('url') }}">
                  @error('url')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
                </div>
              </div>
 {{-- TECNOLOGIE --}}
              <div class="mb-3 d-flex">
                <label for="tecnologie" class="form-label">Tecnologie</label>
                <div class="d-flex ms-5 @error('technologies') is-invalid @enderror flex-wrap gap-3">                  
                  @foreach($technologies as $technology)
                    <div class="form-check">
                      <input name="technologies[]" @checked( in_array($technology->id, old('technologies',[]))) class="form-check-input" type="checkbox" value="{{ $technology->id }}" id="flexCheckDefault">
                      <label class="form-check-label" for="flexCheckDefault">
                        {{ $technology->name }}
                      </label>
                    </div>
                  @endforeach
                </div>
                @error('technologies')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                @enderror
              </div>
 {{-- TEXTAREA --}}

              <div class="form-floating mb-3">
                    <textarea class="form-control @error('description') is-invalid @enderror" placeholder="Insert description here" id="description" name="description" style="height: 200px" >{{ old('description') }}</textarea>
                    <label class="text-black" for="description">INSERISCI DESCRIZIONE</label>
                    @error('description')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
                      </div>
            {{-- RESTA SULLA PAGINA --}}
                      <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="1" id="checkbox" name="checkbox">
                        <label class="form-check-label" for="checkbox">
                          RESTA NELLA PAGINA DI CREAZIONE
                        </label>
                      </div>
            <button type="submit" class="btn btn-primary">AGGIUNGI NUOVO LAVORO</button>
          </form>
    </div>
</div>
@endsection