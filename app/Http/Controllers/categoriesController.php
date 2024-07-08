<?php

namespace App\Http\Controllers;

use App\Models\category;
use Exception;
use Faker\Core\File;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\File as HttpFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class categoriesController extends Controller
{
    public function index(){
        $category=category::paginate(10);
        return response()->json($category,200);
    }

    public function show($id){
        $category=category::find($id);
        if($category){
            return response()->json($category,200);
        }
        else
        return response()->json("category not found",401);
    }

    public function store(Request $request){
        try{
            $request->validate([
                "name" => 'string|required|unique:category,name',
                "image" => 'required|file|mimes:png,jpg,word,pdf,jif'
            ]);

            if($request->hasFile('image')){
                $path='assets/uploads/category/' . $request->image;
                if(Storage::exists($path)){
                    Storage::delete($path);
                }
                $file=$request->file('image');
                $ext=$file->getClientOriginalExtension();
                $file_name=time().'.'.$ext;
                try{
                    $file->move('assets/uploads/category',$file_name);
                }
                catch(Exception $e){
                    dd($e);
                }
            }


            $category=category::create([
                "name"=>$request->name,
                "image" =>$file_name
            ]);
            return response()->json($category,200);
        }
        catch(Exception $e){
            return response()->json($e,500);
        }
    }

    public function update(Request $request,$id){
        try{
            $request->validate([
                // "name" => 'required'
            ]);
            $category=category::find($id);

            if($request->hasFile('image')){
                $path='assets/uploads/category/' . $category->image;
                if(Storage::exists($path)){
                    Storage::delete($path);
                }
                $file=$request->file('image');
                $ext=$file->getClientOriginalExtension();
                $file_name=time().'.'.$ext;
                try{
                    $file->move('assets/uploads/category',$file_name);
                }
                catch(Exception $e){
                    dd($e);
                }
            }

            if($category){
                    $category->name = $request->name;
                    $category->image = $file_name;
                    $category->update();
                return response()->json($category,200);
            }
            else
            return response()->json("category not found",401);
        }

        catch(Exception $e){
            return response()->json($e,500);
        }
    }

    public function destroy($id){
        $category=category::find($id);
        if($category){
            $category->delete();
            return response()->json("delete category done",200);
        }
        else{
            return response()->json("category not found",401);
        }

    }


}
