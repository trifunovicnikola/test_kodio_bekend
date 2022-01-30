<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\project;
use Illuminate\Support\Facades\DB;

class projectController extends Controller
{
    public function addProject(Request $request)
    {

        $project = new project();
        $project->title=$request->title;
        $project->description=$request->description;
        $project->deadline= $request->deadline;
        $project->status= $request->status;
        $project->user = $request->user;
        $project->save();
        return DB::select('select * from projects where user='.$request->user);
    }

    public function deleteProject($id)
    {
        DB::select('delete from project where id='.$id);
        return DB::select('select * from project');
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $project = project::find($id)->first();
//        $project->title=$request->title;
//        $project->description=$request->description;
//        $project->deadline= $request->deadline;
        $project->status= $request->status;
        $project->save();
        return $project;

    }
    public function getUserProjects($id)
    {
        return DB::select('select * from projects where user='.$id);

    }

    public function getProjectById($id)
    {
        return project::find($id);
    }
}
