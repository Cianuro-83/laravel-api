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
    <div class="d-flex align-items-center py-5">
        <div class="me-auto">
            <div>
                @if ($project->type)
                <p class="badge text-bg-info">{{$project->type->name}}</p>

                @else
                <p class="badge text-bg-danger">{{'NESSUNA TIPOLOGIA ASSOCIATA'}}</p>
                    
                @endif
            </div>
            <h1>{{ $project->title }}</h1>
            <p class="fs-6"><span>Slug: </span>{{ $project->slug }}</p>
            <p class="fs-6"><span>Data di Creazione: </span>{{ $project->created_at->format('d/m/y') }}</p>
            <p class="fs-6"><span>Ultima modifica: </span>{{ $project->created_at->format('d/m/y') }}</p>
            <span>Tecnologie utilizzate: </span>
            @forelse ($project->technologies as $tecnologia)            
            <span class="badge rounded-pill text-bg-success">{{$tecnologia->name}}</span>                          
            @empty
              ---
            @endforelse
        </div>

        <div>
            <a class="btn btn-sm btn-outline-warning mt-3" href="{{ route('projects.edit',$project) }}">MODIFICA</a>
        </div>
        
    </div>
</div>
<div class="container">
    <p>
        {{ $project->description }}
    </p>
</div>

<div class="container">
    <h4 class="text-uppercase">progetti correlati</h4>
    @if ($project->type)
    <ul>
        @foreach ($project->getRelatedProjects() as $related_project )
        <li>
            <a href="{{route('projects.show', $related_project)}}">
                {{$related_project->title}}
        </a>
        </li>
            
        @endforeach
    </ul>
        @else
        <h4 class="text-uppercase">nessun progetto correlato</h4>

    @endif
</div>
@endsection