<?php

namespace App\Http\Controllers;

use App\Models\employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function store(Request $request){
        $employee=employee::create([
            'name'=> $request->name,
            'email' =>$request->email,
            'mobile' =>$request->mobile,
            'service' =>$request->service,
            'text' =>$request->text
        ]);
        return response()->json($employee,200);
    }
}
