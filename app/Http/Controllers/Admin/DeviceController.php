<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::with('category')->withCount('symptoms')->paginate(20);
        return view('admin.devices.index', compact('devices'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.devices.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:100',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);
        $data['slug'] = Str::slug($data['name']);
        Device::create($data);
        return redirect()->route('admin.devices.index')->with('success', 'Perangkat berhasil ditambahkan.');
    }

    public function edit(Device $device)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.devices.edit', compact('device', 'categories'));
    }

    public function update(Request $request, Device $device)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:100',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);
        $data['slug'] = Str::slug($data['name']);
        $device->update($data);
        return redirect()->route('admin.devices.index')->with('success', 'Perangkat berhasil diperbarui.');
    }

    public function destroy(Device $device)
    {
        $device->delete();
        return back()->with('success', 'Perangkat berhasil dihapus.');
    }
}
