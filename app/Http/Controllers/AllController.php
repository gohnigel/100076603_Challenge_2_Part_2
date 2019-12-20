<?php

namespace App\Http\Controllers;

use App\School;
use App\Student;
use App\Project;
use App\Reading;

class AllController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index', [
            'schools' => School::all(),
            'students' => Student::all(),
            'projects' => Project::all(),
            'readings' => Reading::all()
        ]);
    }
}
