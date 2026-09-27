<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with('category');
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhere('archive_code', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
        }
        $documents = $query->latest()->paginate(10);
        return view('documents.index', compact('documents'));
    }

    public function autocomplete(Request $request)
    {
        $search = $request->get('q');
        $results = Document::where('title', 'like', '%' . $search . '%')
                           ->orWhere('archive_code', 'like', '%' . $search . '%')
                           ->take(10)
                           ->get(['id', 'title', 'archive_code']);
        return response()->json($results);
    }

    public function create()
    {
        $categories = Category::where('type', 'berkas')->get();
        return view('documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'archive_code' => 'required|string|unique:documents',
            'entry_date' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->except('photo');
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('documents', 'public');
        }

        Document::create($data);
        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        $categories = Category::where('type', 'berkas')->get();
        return view('documents.edit', compact('document', 'categories'));
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'archive_code' => 'required|string|unique:documents,archive_code,' . $document->id,
            'entry_date' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->except('photo');
        if ($request->hasFile('photo')) {
            if ($document->photo_path) {
                Storage::disk('public')->delete($document->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('documents', 'public');
        }

        $document->update($data);
        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document)
    {
        if ($document->photo_path) {
            Storage::disk('public')->delete($document->photo_path);
        }
        $document->delete();
        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }

    public function export()
    {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=documents.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        
        $documents = Document::with('category')->get();
        
        $callback = function() use($documents) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Judul/Nama Berkas', 'Kategori', 'Nomor Arsip', 'Lokasi Fisik', 'Tanggal Masuk', 'Keterangan']);
            
            foreach ($documents as $doc) {
                fputcsv($file, [$doc->id, $doc->title, $doc->category->name ?? '', $doc->archive_code, $doc->physical_location, $doc->entry_date, $doc->description]);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function downloadPhoto(Document $document)
    {
        if ($document->photo_path && Storage::disk('public')->exists($document->photo_path)) {
            return Storage::disk('public')->download($document->photo_path);
        }
        return redirect()->back()->with('error', 'Foto tidak ditemukan.');
    }
}
