<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function create()
    {
        return view('customer.create', ['title' => 'Add Customer']);
    }

    public function store(Request $request)
    {
        Customer::create(
            [
                'name'    => $request->name,
                'phone'   => $request->phone,
                'address' => $request->address,
            ]
        );

        return redirect('/customer/create')->with('success', 'Customer Created successfully!');
    }

    public function index()
    {
        $customers = \App\Models\Customer::all();
        return view('customer.index', ['title' => 'List Of Customers', 'customers' => $customers]);
    }

    public function delete(Request $request)
    {
        $customer = Customer::find($request->id);
        if ($customer) {
            $customer->delete();
            return redirect('/customer/index')->with('success', 'Customer Deleted Successfully');
        }
        return redirect('/customer/index')->with('error', 'Customer not found');
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return redirect('/customer')->with('error', 'Customer not found');
        }
        return view('customer.edit', ['title' => 'Edit Customer', 'customer' => $customer]);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return redirect('/customer')->with('error', 'Customer not found!');
        }

        $data = $request->only(['name', 'phone', 'address']);

        $customer->update($data);

        return redirect('/customer')->with('success', 'Customer updated successfully!');
    }
}
