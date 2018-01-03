<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Customer::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "gender" => "required",
            "email" => "required|email|unique:customers,email",
            "phone" => "required",
            "address" => "required",
        ]);

        $customer = Customer::create($request->all());
        return response()->json($customer, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        if(!empty($customer))
            return response()->json($customer, 200);
        throw new \Exception("Id is not found!");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "name" => "required",
            "gender" => "required",
            "email" => "required|email|unique:customers,email",
            "phone" => "required",
            "address" => "required",
        ]);

        $customer = Customer::find($id)->update($request->all());
        if($customer){
            $customer = Customer::find($id);
            return response()->json($customer, 200);
        }else{
            return response()->json($customer, 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if(!empty($customer)){
            try {
                $customer->delete();
                return response()->json(null, 204);
            } catch (\Exception $exception) {
                throw $exception;
            }
        }else{
            throw new \Exception("Id is not found!");
        }
    }
}
