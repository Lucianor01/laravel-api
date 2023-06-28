<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;

use App\Models\Admin\Project;
use App\Models\Admin\Technology;
use App\Models\Admin\Type;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = Project::all();

        return view('admin.project.index', compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $types = Type::all();

        $technologies = Technology::all();

        return view('admin.project.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {

        $form_data = $request->validated();

        // TRASFORMAZIONE TITOLO IN SLUG
        $slug = Project::generateSlug($request->title);

        $form_data['slug'] = $slug;

        //? CARICAMENTO IMMAGINE 
        if ($request->hasFile('project_image')) {

            // GENERAZIONE PATH DOVE SI SALVERA' L'IMMAGINE NEL PROGETTO
            $path = Storage::disk('public')->put('project_images', $request->project_image);

            $form_data['project_image'] = $path;
        }

        $new_project = Project::create($form_data);

        //? CONTROLLO CHECKED TECHNOLOGIES 
        if ($request->has('technologies')) {
            $new_project->technologies()->attach($request->technologies);
        }

        return redirect()->route('admin.project.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();

        $technologies = Technology::all();

        return view('admin.project.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {

        //dd($request->type_id);
        $form_data = $request->validated();

        // TRASFORMAZIONE TITOLO IN SLUG
        $slug = Project::generateSlug($request->title);

        $form_data['slug'] = $slug;

        //? CARICAMENTO IMMAGINE 
        if ($request->hasFile('project_image')) {

            if ($project->project_image) {
                Storage::delete($project->project_image);
            }

            // GENERAZIONE PATH DOVE SI SALVERA' L'IMMAGINE NEL PROGETTO
            $path = Storage::disk('public')->put('project_images', $request->project_image);

            $form_data['project_image'] = $path;
        };


        if ($request->has('technologies')) {
            $project->technologies()->sync($request->technologies);
        }

        $project->update($form_data);

        return redirect()->route('admin.project.index')->with('success', "Congratulations you have modified your project: " . "<span class='text-primary'>" . strtoupper($project->title) . "</span>");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {

        if ($project->project_image) {
            Storage::delete($project->project_image);
        }

        $project->delete();

        return redirect()->route('admin.project.index');
    }
}
