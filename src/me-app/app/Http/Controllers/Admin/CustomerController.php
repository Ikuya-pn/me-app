<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::searchCustomers($request->search)
                    ->select('id', 'name', 'phone', 'address')
                    ->orderBy('id', 'desc')
                    ->paginate(50);

        return Inertia::render('Admin/Customer/Index', [
            'customers' => $customers
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Customer/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'phone' => ['required', Rule::unique('customers')->ignore($request->id)],
            'memo' => ['max:1000', 'nullable'],
            'postcode' => ['max:7']
        ]);
        Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'memo' => $request->memo,
        ]);

        return to_route('admin.customer.index')
            ->with(['status' => 'success', 'message' => '顧客を登録しました。']);
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return Inertia::render('Admin/Customer/Show', [
            'customer' => $customer,
        ]);
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return Inertia::render('Admin/Customer/Edit', [
            'customer' => $customer,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'phone' => ['required', Rule::unique('customers')->ignore($request->id)],
            'memo' => ['max:1000', 'nullable'],
            'postcode' => ['max:7']
        ]);

        $updateCustomer = Customer::findOrFail($id);
        $updateCustomer->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'memo' => $request->memo,
        ]);

        return to_route('admin.customer.index')
            ->with(['status' => 'success', 'message' => '顧客を更新しました。']);;
    }

    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return to_route('admin.customer.index')
        ->with(['status' => 'danger', 'message' => '顧客を削除しました。']);;;
    }
}


