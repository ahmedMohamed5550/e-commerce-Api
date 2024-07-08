<?php

namespace App\Http\Controllers;

use App\Models\brands;
use Exception;
use Illuminate\Http\Request;

class brandsController extends Controller
{
    public function index(){
        $brands=brands::paginate(10);
        return response()->json($brands,200);
    }

    public function show($id){
        $brands=brands::find($id);
        if($brands){
            return response()->json($brands,200);
        }
        else
        return response()->json("brand not found",401);
    }

    public function store(Request $request){
        try{
            $request->validate([
                "name" => 'required|unique:brands,name'
            ]);
            $brands=brands::create([
                'name'=>$request->name
            ]);
            return response()->json($brands,200);
        }
        catch(Exception $e){
            return response()->json($e,500);
        }
    }

    public function update(Request $request,$id){
        try{
            $request->validate([
                "name" => 'required'
            ]);
            $brands=brands::find($id);
            if($brands){
                $brands->name =$request->name;
                $brands->update();
                return response()->json($brands,200);
            }
            else
            return response()->json("brand not found",401);
        }

        catch(Exception $e){
            return response()->json($e,500);
        }
    }

    public function destroy($id){
        $brands=brands::find($id);
        if($brands){
            $brands->delete();
            return response()->json("delete brand done",200);
        }
        else{
            return response()->json("brand not found",401);
        }



    }

    public function search($name){
        $brands=brands::where('name','like',"%".$name."%")->get();
        if($brands){
            return response()->json($brands,200);
        }
        else{
            return response()->json("This brand Not found",401);
        }
    }


}
