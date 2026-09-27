<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDevices = Device::count();
        $totalDocuments = Document::count();
        $activeDevices = Device::where('status', 'Aktif')->count();
        
        $categoriesStats = Category::withCount(['devices', 'documents'])->get();
        
        // Simple IP Utilization calculation (assuming a /24 subnet)
        $ipUtilization = ($activeDevices > 0) ? round(($activeDevices / 254) * 100, 2) : 0;

        return view('dashboard', compact('totalDevices', 'totalDocuments', 'activeDevices', 'categoriesStats', 'ipUtilization'));
    }
}
