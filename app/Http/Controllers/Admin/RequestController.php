<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\RequestModel;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = RequestModel::with(['client', 'provider', 'category', 'specialization']);

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->latest()->paginate(10);

        return view('admin.requests.index', compact('requests'));
    }
    public function create()
    {
        return view('admin.requests.add', [
            'clients' => User::where('role', 'user')->get(),
            'providers' => User::where('role', 'worker')->get(),
            'categories' => Category::all(),
            'specializations' => Specialization::all(),
        ]);

    }
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'provider_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'specialization_id' => 'nullable|exists:specializations,id',
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        RequestModel::create($request->all());

        return redirect()->route('request.index')->with('success', 'Request created successfully.');
    }
    public function edit($id)
    {

        $requestItem = RequestModel::findOrFail($id);
        return view('admin.requests.edit', [
            'requestItem' => $requestItem,
            'clients' => User::where('role', 'user')->get(),
            'providers' => User::where('role', 'worker')->get(),
            'categories' => Category::all(),
            'specializations' => Specialization::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $requestItem = RequestModel::findOrFail($id);

        $data = $request->validate([
            'client_id' => 'required|exists:users,id',
            'provider_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'specialization_id' => 'required|exists:specializations,id',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,accepted,in_progress,completed,cancelled',
        ]);

        $requestItem->update($data);

        return redirect()->route('request.index')->with('success', 'Request updated successfully');
    }
    public function delete($id)
    {
        $requestItem = RequestModel::findOrFail($id);
        $requestItem->delete();
        return redirect()->route('request.index')->with('success', 'Request deleted successfully.');

    }
}
