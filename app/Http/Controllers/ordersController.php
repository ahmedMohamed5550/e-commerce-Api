<?php

namespace App\Http\Controllers;

use App\Models\location;
use App\Models\orderItemList;
use App\Models\orders;
use App\Models\products;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ordersController extends Controller
{
    public function index(){
        $orders=orders::with('user')->paginate(20);
        return response()->json($orders,200);
        // if($orders){
        //     foreach($orders as $order){
        //         foreach($order->items as $order_items){
        //             $products=products::where('id',$order_items->product_id)->pluck('name');
        //             $order_items->product_name=$products['0'];
        //         }
        //     }
        //     return response()->json($orders,200);
        // }
        // else return response()->json("Not Order",401);

        // $orders=orders::with('user')->paginate(20);
        // if($orders){
        //     foreach($orders as $order){
        //         foreach($order->item as $order_items){
        //             $products=products::where('id',$order_items->product_id)->pluck('name');
        //             $order_items->product_name=$products['0'];
        //         }
        //     }
        //     return response()->json($orders,200);
        // }
        // else
        // return response()->json("Not Order",401);
    }

    public function show($id){
        $orders=orders::find($id);
        if($orders){
            return response()->json($orders,200);
        }
        else
        return response()->json("Not Found",401);
    }

    public function store(Request $request){
        $request->validate([
            'order_items' =>'required',
            'quntatity' =>'required',
            'total_price' =>'required',
            'date_of_delivery' =>'required'
        ]);
        try{
        $location=location::where('user_id',Auth::id())->first();

        $orders=new orders();
        $orders->user_id =Auth::id();
        $orders->location_id = $location->id;
        $orders->total_price = $request->total_price;
        $orders->date_of_delivery= $request->date_of_delivery;
        $orders->save();

        foreach($request->order_items as $order_items){
            $items=new orderItemList();
            $items->order_id = $orders->id;
            $items->quntatity=$order_items['quntatity'];
            $items->price=$order_items['price'];
            $items->product_id=$order_items['product_id'];
            $items->save();
            $products=products::where('id',$order_items['product_id'])->first();
            $products->amount=$order_items['quntatity'];
            $products->save();
        }
        return response()->json("order is added",200);
    }
    catch(Exception $e){
        return response()->json($e,500);
    }

    }

    // function to get order items
    public function get_order_items($id){
        $orderItemList=orderItemList::where('order_id',$id);
        if($orderItemList){
            foreach($orderItemList as $order_items){
                $products=products::where('id',$order_items->product_id)->pluck('name');
                $order_items->product_name=$products['0'];
            }
            return response()->json($orderItemList,200);
        }
        else return response()->json("no order items",401);
    }


    // function to get user orders
    public function get_user_orders($id){
        $orders=orders::with('items')->where('user_id',$id)->get();

            if($orders){
                foreach($orders as $order){
                    foreach($order->items as $order_items)
                    $products=products::where('id',$order_items->product_id)->pluck('name');
                    // $products->all();
                    $order_items->product_name=$products['0'];
                }
            return response()->json($orders,200);
            }
            else return response()->json("no order found",401);
    }

    // function to change status

    public function changeOrderStatus(Request $request,$id){
        $orders=orders::find($id);
        if($orders){
            $orders->update(['status'=> $request->status]);
            return response()->json("status changed successfully",200);
        }
        else return response()->json("no order found",401);
    }




}
