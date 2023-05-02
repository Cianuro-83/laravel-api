<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Technology;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $trashed = $request->input('trashed');

        if ($trashed) {
            $projects = Project::onlyTrashed()->get();
        } else {
            $projects = Project::all();
        }

        $num_of_trashed = Project::onlyTrashed()->count();

        return view('projects.index', compact('projects', 'num_of_trashed'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types= Type::orderBy('name', 'asc')->get();
        $technologies= Technology::orderBy('name', 'asc')->get();
        return view('projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request )
    {
        $data=$request->validated();

        $data['slug']=Str::slug( $data['title'] );
        

        $new_project=Project::create($data);
        $request->session()->flash('message', 'Il progetto è stato creato correttamente.');
        
        if(isset($data['technologies'])){
            $new_project->technologies()->attach($data['technologies']);
        }

        if (isset($data['checkbox']))
        return to_route('projects.create');
         else
       return to_route('projects.show', $new_project);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Project $project)
    {
        $types= Type::orderBy('name', 'asc')->get();
        $technologies= Technology::orderBy('name', 'asc')->get();

        return view('projects.edit', compact('project', 'types','technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data=$request->validated();

        if ($data['title'] != $project->title){
            $data['slug'] = Str::slug($data['title']);
        }
        $project->update($data);

        $request->session()->flash('message', 'Il progetto è stato modificato con successo.');
    




        if (isset($data['technologies'])) {
            $project->technologies()->sync($data['technologies']);
        } else {
            $project->technologies()->sync([]);
        }



        return to_route('projects.show', $project);
    }

    public function restore(Request $request, Project $project)
    {

        if ($project->trashed()) {
            $project->restore();

            $request->session()->flash('message', 'Il riprisino è avvenuto con successo.');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if ($project->trashed()) {
            $project->forceDelete(); // HARD DELETE
        } else {
            $project->delete(); //SOFT DELETE
        }
        return back();
    }


    public function destroyAll(Request $request)
    {

         $projects= Project::onlyTrashed()->forceDelete();
         $request->session()->flash('message', 'Il cestino è stato svuotato correttamente.');
        

         return to_route('projects.index');
    }
}