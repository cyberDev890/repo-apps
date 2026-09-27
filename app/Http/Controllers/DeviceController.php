<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Category;
use App\Models\WorkUnit;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        $query = Device::with(['category', 'workUnit']);
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('serial_number', 'like', '%' . $search . '%')
                  ->orWhere('ip_address', 'like', '%' . $search . '%');
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        if ($request->filled('work_unit_id')) {
            $query->where('work_unit_id', $request->work_unit_id);
        }
        if ($request->filled('ip_address')) {
            $query->where('ip_address', 'like', '%' . $request->ip_address . '%');
        }

        $devices = $query->latest()->paginate(10);
        $pageTitle = 'Semua Perangkat IT';
        return view('devices.index', compact('devices', 'pageTitle'));
    }

    public function networkInventory(Request $request)
    {
        $query = Device::with(['category', 'workUnit'])
            ->whereHas('category', function($q) {
                $q->where('name', 'like', '%Router%')
                  ->orWhere('name', 'like', '%Switch%')
                  ->orWhere('name', 'like', '%Hub%')
                  ->orWhere('name', 'like', '%Access Point%')
                  ->orWhere('name', 'like', '%Firewall%');
            });
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('serial_number', 'like', '%' . $search . '%')
                  ->orWhere('ip_address', 'like', '%' . $search . '%');
            });
        }
        
        $devices = $query->latest()->paginate(10);
        $pageTitle = 'Infrastruktur Jaringan';
        return view('devices.index', compact('devices', 'pageTitle'));
    }

    public function computerInventory(Request $request)
    {
        $query = Device::with(['category', 'workUnit'])
            ->whereHas('category', function($q) {
                $q->where('name', 'like', '%Komputer%')
                  ->orWhere('name', 'like', '%PC%')
                  ->orWhere('name', 'like', '%Server%');
            });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('serial_number', 'like', '%' . $search . '%');
            });
        }

        $devices = $query->latest()->paginate(10);
        $pageTitle = 'Komputer';
        return view('devices.index', compact('devices', 'pageTitle'));
    }

    public function laptopInventory(Request $request)
    {
        $query = Device::with(['category', 'workUnit'])
            ->whereHas('category', function($q) {
                $q->where('name', 'like', '%Laptop%');
            });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('serial_number', 'like', '%' . $search . '%');
            });
        }

        $devices = $query->latest()->paginate(10);
        $pageTitle = 'Laptop';
        return view('devices.index', compact('devices', 'pageTitle'));
    }

    public function printerInventory(Request $request)
    {
        $query = Device::with(['category', 'workUnit'])
            ->whereHas('category', function($q) {
                $q->where('name', 'like', '%Printer%');
            });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('serial_number', 'like', '%' . $search . '%');
            });
        }

        $devices = $query->latest()->paginate(10);
        $pageTitle = 'Printer';
        return view('devices.index', compact('devices', 'pageTitle'));
    }

    public function peripheralInventory(Request $request)
    {
        $query = Device::with(['category', 'workUnit'])
            ->whereHas('category', function($q) {
                $q->where('name', 'not like', '%Router%')
                  ->where('name', 'not like', '%Switch%')
                  ->where('name', 'not like', '%Hub%')
                  ->where('name', 'not like', '%Access Point%')
                  ->where('name', 'not like', '%Firewall%')
                  ->where('name', 'not like', '%Laptop%')
                  ->where('name', 'not like', '%Komputer%')
                  ->where('name', 'not like', '%PC%')
                  ->where('name', 'not like', '%Server%')
                  ->where('name', 'not like', '%Printer%');
            });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('serial_number', 'like', '%' . $search . '%');
            });
        }

        $devices = $query->latest()->paginate(10);
        $pageTitle = 'Peripheral & Lainnya';
        return view('devices.index', compact('devices', 'pageTitle'));
    }

    public function autocomplete(Request $request)
    {
        $search = $request->get('q');
        if (!$search) {
            return response()->json([]);
        }
        
        $devices = Device::where('name', 'like', '%' . $search . '%')
                         ->orWhere('serial_number', 'like', '%' . $search . '%')
                         ->orWhere('ip_address', 'like', '%' . $search . '%')
                         ->limit(8)
                         ->get(['id', 'name', 'serial_number', 'ip_address']);
                         
        return response()->json($devices);
    }

    public function create()
    {
        $categories = Category::where('type', 'perangkat')->get();
        $workUnits = WorkUnit::all();
        return view('devices.create', compact('categories', 'workUnits'));
    }

    public function store(Request $request)
    {
        $isComputerOrLaptop = false;
        if ($request->has('category_id')) {
            $category = Category::find($request->category_id);
            if ($category && (stripos($category->name, 'Komputer') !== false || stripos($category->name, 'Laptop') !== false || stripos($category->name, 'PC') !== false || stripos($category->name, 'Server') !== false)) {
                $isComputerOrLaptop = true;
            }
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'work_unit_id' => 'required|exists:work_units,id',
            'name' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Rusak,Digudangkan',
            'pengguna' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'ip_address' => $isComputerOrLaptop ? 'required|string|max:255' : 'nullable|string|max:255',
        ]);

        Device::create($request->all());
        return back()->with('success', 'Perangkat berhasil ditambahkan.');
    }

    public function show(Device $device)
    {
        return view('devices.show', compact('device'));
    }

    public function edit(Device $device)
    {
        $categories = Category::where('type', 'perangkat')->get();
        $workUnits = WorkUnit::all();
        return view('devices.edit', compact('device', 'categories', 'workUnits'));
    }

    public function update(Request $request, Device $device)
    {
        $isComputerOrLaptop = false;
        if ($request->has('category_id')) {
            $category = Category::find($request->category_id);
            if ($category && (stripos($category->name, 'Komputer') !== false || stripos($category->name, 'Laptop') !== false || stripos($category->name, 'PC') !== false || stripos($category->name, 'Server') !== false)) {
                $isComputerOrLaptop = true;
            }
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'work_unit_id' => 'required|exists:work_units,id',
            'name' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Rusak,Digudangkan',
            'pengguna' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'ip_address' => $isComputerOrLaptop ? 'required|string|max:255' : 'nullable|string|max:255',
        ]);

        $device->update($request->all());
        return back()->with('success', 'Perangkat berhasil diperbarui.');
    }

    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('devices.index')->with('success', 'Perangkat berhasil dihapus.');
    }

    public function export()
    {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=devices.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        
        $devices = Device::with('category')->get();
        
        $callback = function() use($devices) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Nama Perangkat', 'Kategori', 'Merek/Model', 'Serial Number', 'IP Address', 'Mac Address', 'Lokasi', 'Status']);
            
            foreach ($devices as $device) {
                fputcsv($file, [$device->id, $device->name, $device->category->name ?? '', $device->brand, $device->serial_number, $device->ip_address, $device->mac_address, $device->location, $device->status]);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
