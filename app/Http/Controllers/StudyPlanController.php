<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudyPlanController extends Controller
{
    public function index(){
        return view('admin.resource.studyplan.index');
    }
    
    public function actIndex(){
        return view('admin.resource.actbook.index');
    }
}
