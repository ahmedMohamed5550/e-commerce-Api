<?php

namespace App\Http\Controllers;

use App\Models\products;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class productsController extends Controller
{
    public function index(){
        try{
            $products=products::paginate(10);
            return response()->json($products,200);
        }
        catch(Exception $e){
            return response()->json($e,401);
        }
    }

    public function show($id){
        try{
            $products=products::find($id);
            if($products){
                return response()->json($products,200);
            }
            else
            return response()->json("product not found",401);
        }
        catch(Exception $e){
            return response()->json($e,401);
        }

    }

    public function store(Request $request){
        try{
            $request->validate([
                'category_id'=> 'required|numeric',
                'brand_id'=> 'required|numeric',
                "name" => 'required',
                "price" => 'required|numeric',
                "amount" => 'required|numeric',
                "discount" => 'numeric',
                "image" => 'required|file|mimes:png,jpg,word,pdf,jif'
            ]);

            if($request->hasFile('image')){
                $path='assets/uploads/products/' . $request->image;
                if(Storage::exists($path)){
                    Storage::delete($path);
                }
                $file=$request->file('image');
                $ext=$file->getClientOriginalExtension();
                $file_name=time().'.'.$ext;
                try{
                    $file->move('assets/uploads/products',$file_name);
                }
                catch(Exception $e){
                    dd($e);
                }
            }

            $products=products::create([
                'category_id'=>$request->category_id,
                'brand_id'=>$request->brand_id,
                'name' => $request->name,
                'is_trendy'=> $request->is_trendy,
                'is_available'=> $request->is_available,
                'price'=> $request->price,
                'amount'=> $request->amount,
                'discount'=> $request->discount,
                'image' =>$file_name
            ]);
            return response()->json($products,200);
        }
        catch(Exception $e){
            return response()->json($e,500);
        }
    }

    public function update(Request $request,$id){
        try{
            $request->validate([
                'category_id'=> 'required|numeric',
                'brand_id'=> 'required|numeric',
                "name" => 'required',
                "price" => 'required|numeric',
                "amount" => 'required|numeric',
                "discount" => 'required|numeric',
                "image" => 'file|mimes:png,jpg,word,pdf,jif'
            ]);
            $products=products::find($id);

            if($request->hasFile('image')){
                $path='assets/uploads/products/' . $products->image;
                if(Storage::exists($path)){
                    Storage::delete($path);
                }
                $file=$request->file('image');
                $ext=$file->getClientOriginalExtension();
                $file_name=time().'.'.$ext;
                try{
                    $file->move('assets/uploads/products',$file_name);
                }
                catch(Exception $e){
                    dd($e);
                }
            }

            if($products){
                    $products->category_id=$request->category_id;
                    $products->brand_id=$request->brand_id;
                    $products->name = $request->name;
                    $products->is_trendy= $request->is_trendy;
                    $products->is_available= $request->is_available;
                    $products->price= $request->price;
                    $products->amount= $request->amount;
                    $products->discount= $request->discount;
                    $products->image =$file_name;
                    $products->update();

                return response()->json($products,200);
            }
            else
            return response()->json("category not found",401);
        }

        catch(Exception $e){
            return response()->json($e,500);
        }
    }

    public function destroy($id){
        $products=products::find($id);
        if($products){
            $products->delete();
            return response()->json("delete product done",200);
        }
        else{
            return response()->json("product not found",401);
        }

    }


    public function search($name){
        $products=products::where('name','like',"%".$name."%")->get();
        if($products){
            return response()->json($products,200);
        }
        else{
            return response()->json("This product Not found",200);
        }
    }
}
