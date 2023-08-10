<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Customer::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customerData = $request->toArray();
        $customerRegister = Customer::create($customerData);

        return response()->json([
            'status' => 'created',
            'customer' => $customerRegister->toArray()
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $retrievedCustomer = Customer::find($id);
        return response()->json($retrievedCustomer->toArray());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customerUpdatingData = $request->toArray();
        Customer::where('id', $id)->update($customerUpdatingData);

        $updatedCustomer = Customer::find($id);
        return response()->json([
            'status' => 'updated',
            'customer' => $updatedCustomer->toArray(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Customer::destroy($id);
        return response()->json([], 204);
    }
}
