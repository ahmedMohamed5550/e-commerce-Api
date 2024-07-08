<?php

namespace App\Http\Controllers;

use App\Models\location;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class locationController extends Controller
{
    public function store(Request $request){
        try{
            $request->validate([
                'street'=> 'required',
                'building'=> 'required',
                'area'=> 'required'
            ]);

            $location=new location();
            $location->user_id = Auth::id();
            $location->street = $request->street;
            $location->building=$request->building;
            $location->area=$request->area;
            $location->save();

            return response()->json("location Added",201);
        }
        catch(Exception $e){
            return response()->json($e,500);
        }
    }

    public function update(Request $request,$id){
        try{
            $request->validate([
                'street'=> 'required',
                'building'=> 'required',
                'area'=> 'required'
            ]);
            $location=location::find($id);
            if($location){

                    $location->street = $request->street;
                    $location->building= $request->building;
                    $location->area= $request->area;
                    $location->update();

                return response()->json($location,200);
            }
            else
            return response()->json("location not found",401);
        }

        catch(Exception $e){
            return response()->json($e,500);
        }
    }

    public function destroy($id){
        $location=location::find($id);
        if($location){
            $location->delete();
            return response()->json("delete location done",200);
        }
        else{
            return response()->json("location not found",401);
        }
    }
}
