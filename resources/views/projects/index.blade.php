@extends('layouts.app')

@section('content')

    <div class="container">

      @if(request()->session()->exists('message'))

      <div class="alert alert-primary" role="alert">
        {{ request()->session()->pull('message') }}
      </div>

      @endif
        <div class="container py-5">
            <div class="d-flex align-items-center">
              @if(request('trashed'))
              <h1 class="me-auto text-uppercase text-warning">Cestino</h1>
              @else
              <h1 class="me-auto text-uppercase text-warning">i mie lavori</h1>
              @endif

              <div>
                @if(request('trashed'))
                <a class="btn btn-outline-info text-uppercase fw-bolder me-2" href="{{ route('projects.index') }}">Tutti i miei progetti</a>
                <form action="{{route('projects.destroy.all')}}" method="POST">
                  @csrf
                  @method('DELETE')
                  <input type="submit" class="my-2 btn btn-outline-danger btn fw-bolder text-end" value="SVUOTA CESTINO">
                </form>
              @else
                <a class="btn btn-outline-info text-uppercase fw-bolder me-2" href="{{ route('projects.index',['trashed' => true]) }}">Cestino ({{ $num_of_trashed}})</a>
              @endif
                  <a class="btn btn-outline-success text-uppercase fw-bolder" href="{{ route('projects.create') }}">+ add new +</a>
              </div>
            </div>
          </div>
      
          <div class="container text-">
            <table class="table  text-white table-responsive table-inverse">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nome Progetto</th>
                  <th>Tipologia</th>
                  <th>Cliente</th>
                  <th>Web</th>
                  <th>Data creazione</th>
                  @if(request('trashed'))
                  <th >Data cancellazione</th>
                  @else
                  <th>Ultima modifica</th>
                  @endif
                  <th>Tecnologie utilizzate</th>
                  <th>Azioni</th>
                  
                </tr>
              </thead>
              <tbody>
                @forelse ($projects as $project)
                    <tr>
                      <td>{{ $project->id }}</td>
                      <td>
                        <a href="{{ route('projects.show',$project) }}">{{ $project->title }}</a>
                      </td>
                      <td class="text-center">{{ $project->type ? $project->type->name : '---'  }}</td>
                      <td>{{ $project->customer }}</td>
                      <td>{{ $project->url }}</td>
                      <td>{{ $project->created_at->format('d/m/y') }}</td>
                      @if(request('trashed'))
                      <td>{{$project->deleted_at->format('d/m/y')}}</td>
                      @else
                      <td>{{ $project->updated_at->format('d/m/y') }}</td>
                      @endif
{{-- **************************
  TECNOLOGIE
  ************************** --}}
                      <td>                        
                        @forelse ($project->technologies as $tecnologia )
                        <span class="badge rounded-pill text-bg-dark">{{$tecnologia->name}}</span>                          
                        @empty
                          ---
                        @endforelse
                      </td>
                      
                      <td>
                        <div>
                          @if(request('trashed'))
                          <form action="{{ route('projects.restore',$project) }}" method="POST">
                            @csrf
                            <input class="btn btn-sm btn-outline-success" type="submit" value="RIPRISTINA">
                          </form>
                          @else
                          <a class="btn btn-sm btn-outline-warning mt-3 me-1" href="{{ route('projects.edit',$project) }}">MODIFICA</a>
                          @endif
                          @if(request('trashed'))
                          <form action="{{route('projects.destroy', $project)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="ELIMINA" class="btn btn-sm btn-outline-danger mt-3 ms-1">
                          </form>
                      @else
                      <form action="{{route('projects.destroy', $project)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="CESTINA" class="btn btn-sm btn-outline-danger mt-3 ms-1">
                      </form>
                      @endif
                    </td>
                        </div>
                      </td>
                    </tr>
                @empty
                  <tr>

                    @if(request('trashed'))
                    <th colspan="9" class="text-uppercase text-center fw-bolder">il cestino è vuoto</th>
                      @else
                      <th colspan="9" class="text-uppercase text-center fw-bolder">Nessun lavoro trovato</th>
                      @endif
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
    </div>
@endsection