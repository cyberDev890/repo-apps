<?php
$views = [
    'resources/views/categories/index.blade.php' => <<<'EOT'
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">{{ __('Kategori Aset') }}</h2>
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('categories.create') }}" class="btn-primary">Tambah Kategori</a>
            @endif
        </div>
    </x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success')) <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-4">{{ session('success') }}</div> @endif
        <div class="glass-panel p-6"><div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead><tr class="border-b border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300">
                    <th class="p-3">ID</th><th class="p-3">Nama</th><th class="p-3">Tipe</th>
                    @if(auth()->user()->role === 'admin') <th class="p-3 text-right">Aksi</th> @endif
                </tr></thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr class="border-b border-slate-100 dark:border-slate-800/50 text-slate-700 dark:text-slate-300">
                        <td class="p-3">{{ $category->id }}</td>
                        <td class="p-3 font-medium">{{ $category->name }}</td>
                        <td class="p-3">{{ ucfirst($category->type) }}</td>
                        @if(auth()->user()->role === 'admin')
                        <td class="p-3 text-right flex justify-end space-x-2">
                            <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                @csrf @method('DELETE') <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @empty <tr><td colspan="4" class="p-3 text-center">Data tidak ditemukan.</td></tr> @endforelse
                </tbody>
            </table>
        </div><div class="mt-4">{{ $categories->links() }}</div></div>
    </div></div>
</x-app-layout>
EOT,
    'resources/views/devices/index.blade.php' => <<<'EOT'
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">{{ __('Inventaris Perangkat IT') }}</h2>
            @if(auth()->user()->role === 'admin')
            <div class="space-x-2">
                <a href="{{ route('devices.export') }}" class="bg-slate-600 hover:bg-slate-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition-all">Export CSV</a>
                <a href="{{ route('devices.create') }}" class="btn-primary">Tambah Perangkat</a>
            </div>
            @endif
        </div>
    </x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success')) <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-4">{{ session('success') }}</div> @endif
        @if($errors->any()) <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div> @endif
        
        <div class="glass-panel p-4 mb-6">
            <form method="GET" action="{{ route('devices.index') }}" class="flex flex-wrap gap-4 items-end">
                <div><label class="block text-sm text-slate-700 dark:text-slate-300">Status</label>
                <select name="status" class="input-field mt-1"><option value="">Semua Status</option><option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option><option value="Rusak" {{ request('status') == 'Rusak' ? 'selected' : '' }}>Rusak</option><option value="Digudangkan" {{ request('status') == 'Digudangkan' ? 'selected' : '' }}>Digudangkan</option></select></div>
                <div><label class="block text-sm text-slate-700 dark:text-slate-300">Lokasi</label>
                <input type="text" name="location" class="input-field mt-1" value="{{ request('location') }}" placeholder="Cari Lokasi"></div>
                <div><label class="block text-sm text-slate-700 dark:text-slate-300">IP / Subnet</label>
                <input type="text" name="ip_address" class="input-field mt-1" value="{{ request('ip_address') }}" placeholder="Cari IP Address"></div>
                <div><button type="submit" class="bg-slate-800 hover:bg-slate-700 text-white py-2 px-4 rounded-lg">Filter</button>
                <a href="{{ route('devices.index') }}" class="text-sm text-slate-500 ml-2">Reset</a></div>
            </form>
        </div>

        <div class="glass-panel p-6"><div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead><tr class="border-b border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300">
                    <th class="p-3">Nama</th><th class="p-3">Merek</th><th class="p-3">SN</th><th class="p-3">IP Address</th><th class="p-3">Status</th>
                    @if(auth()->user()->role === 'admin') <th class="p-3 text-right">Aksi</th> @endif
                </tr></thead>
                <tbody>
                    @forelse($devices as $device)
                    <tr class="border-b border-slate-100 dark:border-slate-800/50 text-slate-700 dark:text-slate-300">
                        <td class="p-3 font-medium">{{ $device->name }}<br><span class="text-xs text-slate-500">{{ $device->category->name ?? '-' }}</span></td>
                        <td class="p-3">{{ $device->brand }}</td>
                        <td class="p-3">{{ $device->serial_number }}</td>
                        <td class="p-3">{{ $device->ip_address }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs {{ $device->status == 'Aktif' ? 'bg-emerald-100 text-emerald-800' : ($device->status == 'Rusak' ? 'bg-red-100 text-red-800' : 'bg-slate-100 text-slate-800') }}">{{ $device->status }}</span>
                        </td>
                        @if(auth()->user()->role === 'admin')
                        <td class="p-3 text-right flex justify-end space-x-2">
                            <a href="{{ route('devices.edit', $device) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('devices.destroy', $device) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                @csrf @method('DELETE') <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @empty <tr><td colspan="6" class="p-3 text-center">Data tidak ditemukan.</td></tr> @endforelse
                </tbody>
            </table>
        </div><div class="mt-4">{{ $devices->links() }}</div></div>
    </div></div>
</x-app-layout>
EOT,
    'resources/views/devices/create.blade.php' => <<<'EOT'
<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">Tambah Perangkat IT</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="glass-panel p-6 max-w-2xl">
            @if($errors->any()) <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div> @endif
            <form action="{{ route('devices.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Nama Perangkat *</label>
                    <input type="text" name="name" class="input-field" value="{{ old('name') }}" required></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Kategori *</label>
                    <select name="category_id" class="input-field" required>
                        @foreach($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach
                    </select></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Merek / Model</label>
                    <input type="text" name="brand" class="input-field" value="{{ old('brand') }}"></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Serial Number (SN)</label>
                    <input type="text" name="serial_number" class="input-field" value="{{ old('serial_number') }}"></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">IP Address (Unik jika Aktif)</label>
                    <input type="text" name="ip_address" class="input-field" value="{{ old('ip_address') }}"></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">MAC Address</label>
                    <input type="text" name="mac_address" class="input-field" value="{{ old('mac_address') }}"></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Lokasi / Ruangan</label>
                    <input type="text" name="location" class="input-field" value="{{ old('location') }}"></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Status *</label>
                    <select name="status" class="input-field" required>
                        <option value="Aktif">Aktif</option><option value="Rusak">Rusak</option><option value="Digudangkan">Digudangkan</option>
                    </select></div>
                </div>
                <div class="mt-4"><button type="submit" class="btn-primary">Simpan Perangkat</button></div>
            </form>
        </div>
    </div></div>
</x-app-layout>
EOT,
    'resources/views/devices/edit.blade.php' => <<<'EOT'
<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">Edit Perangkat IT</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="glass-panel p-6 max-w-2xl">
            @if($errors->any()) <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div> @endif
            <form action="{{ route('devices.update', $device) }}" method="POST">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Nama Perangkat *</label>
                    <input type="text" name="name" class="input-field" value="{{ old('name', $device->name) }}" required></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Kategori *</label>
                    <select name="category_id" class="input-field" required>
                        @foreach($categories as $category)<option value="{{ $category->id }}" {{ $device->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>@endforeach
                    </select></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Merek / Model</label>
                    <input type="text" name="brand" class="input-field" value="{{ old('brand', $device->brand) }}"></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Serial Number (SN)</label>
                    <input type="text" name="serial_number" class="input-field" value="{{ old('serial_number', $device->serial_number) }}"></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">IP Address (Unik jika Aktif)</label>
                    <input type="text" name="ip_address" class="input-field" value="{{ old('ip_address', $device->ip_address) }}"></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">MAC Address</label>
                    <input type="text" name="mac_address" class="input-field" value="{{ old('mac_address', $device->mac_address) }}"></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Lokasi / Ruangan</label>
                    <input type="text" name="location" class="input-field" value="{{ old('location', $device->location) }}"></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Status *</label>
                    <select name="status" class="input-field" required>
                        <option value="Aktif" {{ $device->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Rusak" {{ $device->status == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="Digudangkan" {{ $device->status == 'Digudangkan' ? 'selected' : '' }}>Digudangkan</option>
                    </select></div>
                </div>
                <div class="mt-4"><button type="submit" class="btn-primary">Simpan Perubahan</button></div>
            </form>
        </div>
    </div></div>
</x-app-layout>
EOT,
    'resources/views/documents/index.blade.php' => <<<'EOT'
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">{{ __('Inventaris Berkas & Dokumen') }}</h2>
            @if(auth()->user()->role === 'admin')
            <div class="space-x-2">
                <a href="{{ route('documents.export') }}" class="bg-slate-600 hover:bg-slate-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition-all">Export CSV</a>
                <a href="{{ route('documents.create') }}" class="btn-primary">Tambah Dokumen</a>
            </div>
            @endif
        </div>
    </x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success')) <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-4">{{ session('success') }}</div> @endif
        <div class="glass-panel p-6"><div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead><tr class="border-b border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300">
                    <th class="p-3">Judul Berkas</th><th class="p-3">Nomor Arsip (Kode)</th><th class="p-3">Lokasi Fisik</th><th class="p-3">Tanggal Masuk</th><th class="p-3">QR Code</th>
                    @if(auth()->user()->role === 'admin') <th class="p-3 text-right">Aksi</th> @endif
                </tr></thead>
                <tbody>
                    @forelse($documents as $doc)
                    <tr class="border-b border-slate-100 dark:border-slate-800/50 text-slate-700 dark:text-slate-300">
                        <td class="p-3 font-medium">{{ $doc->title }}<br><span class="text-xs text-slate-500">{{ $doc->category->name ?? '-' }}</span></td>
                        <td class="p-3 font-mono text-sm">{{ $doc->archive_code }}</td>
                        <td class="p-3">{{ $doc->physical_location }}</td>
                        <td class="p-3">{{ $doc->entry_date ? \Carbon\Carbon::parse($doc->entry_date)->format('d M Y') : '-' }}</td>
                        <td class="p-3"><a href="{{ route('documents.show', $doc) }}" class="text-indigo-600 hover:underline">Lihat QR</a></td>
                        @if(auth()->user()->role === 'admin')
                        <td class="p-3 text-right flex justify-end space-x-2">
                            <a href="{{ route('documents.edit', $doc) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('documents.destroy', $doc) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                @csrf @method('DELETE') <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @empty <tr><td colspan="6" class="p-3 text-center">Data tidak ditemukan.</td></tr> @endforelse
                </tbody>
            </table>
        </div><div class="mt-4">{{ $documents->links() }}</div></div>
    </div></div>
</x-app-layout>
EOT,
    'resources/views/documents/create.blade.php' => <<<'EOT'
<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">Tambah Dokumen</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="glass-panel p-6 max-w-2xl">
            @if($errors->any()) <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div> @endif
            <form action="{{ route('documents.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Judul Berkas *</label>
                    <input type="text" name="title" class="input-field" value="{{ old('title') }}" required></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Kategori *</label>
                    <select name="category_id" class="input-field" required>
                        @foreach($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach
                    </select></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Nomor Arsip (Unik) *</label>
                    <input type="text" name="archive_code" class="input-field font-mono" value="{{ old('archive_code') }}" required></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Tanggal Masuk</label>
                    <input type="date" name="entry_date" class="input-field" value="{{ old('entry_date') }}"></div>
                    <div class="mb-4 md:col-span-2"><label class="block text-sm text-slate-700 dark:text-slate-300">Lokasi Fisik (Misal: Lemari A, Rak 2)</label>
                    <input type="text" name="physical_location" class="input-field" value="{{ old('physical_location') }}"></div>
                    <div class="mb-4 md:col-span-2"><label class="block text-sm text-slate-700 dark:text-slate-300">Keterangan</label>
                    <textarea name="description" class="input-field" rows="3">{{ old('description') }}</textarea></div>
                </div>
                <div class="mt-4"><button type="submit" class="btn-primary">Simpan Dokumen</button></div>
            </form>
        </div>
    </div></div>
</x-app-layout>
EOT,
    'resources/views/documents/edit.blade.php' => <<<'EOT'
<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">Edit Dokumen</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="glass-panel p-6 max-w-2xl">
            @if($errors->any()) <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div> @endif
            <form action="{{ route('documents.update', $document) }}" method="POST">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Judul Berkas *</label>
                    <input type="text" name="title" class="input-field" value="{{ old('title', $document->title) }}" required></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Kategori *</label>
                    <select name="category_id" class="input-field" required>
                        @foreach($categories as $category)<option value="{{ $category->id }}" {{ $document->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>@endforeach
                    </select></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Nomor Arsip (Unik) *</label>
                    <input type="text" name="archive_code" class="input-field font-mono" value="{{ old('archive_code', $document->archive_code) }}" required></div>
                    <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Tanggal Masuk</label>
                    <input type="date" name="entry_date" class="input-field" value="{{ old('entry_date', $document->entry_date ? \Carbon\Carbon::parse($document->entry_date)->format('Y-m-d') : '') }}"></div>
                    <div class="mb-4 md:col-span-2"><label class="block text-sm text-slate-700 dark:text-slate-300">Lokasi Fisik</label>
                    <input type="text" name="physical_location" class="input-field" value="{{ old('physical_location', $document->physical_location) }}"></div>
                    <div class="mb-4 md:col-span-2"><label class="block text-sm text-slate-700 dark:text-slate-300">Keterangan</label>
                    <textarea name="description" class="input-field" rows="3">{{ old('description', $document->description) }}</textarea></div>
                </div>
                <div class="mt-4"><button type="submit" class="btn-primary">Simpan Perubahan</button></div>
            </form>
        </div>
    </div></div>
</x-app-layout>
EOT,
    'resources/views/documents/show.blade.php' => <<<'EOT'
<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">Detail Dokumen & QR Code</h2></x-slot>
    <div class="py-12"><div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="glass-panel p-8 flex flex-col md:flex-row gap-8 items-center md:items-start">
            <div class="bg-white p-4 rounded-xl shadow-md flex-shrink-0">
                {!! $qrCode !!}
                <p class="text-center mt-2 font-mono text-sm text-slate-700">{{ $document->archive_code }}</p>
                <button onclick="window.print()" class="mt-4 w-full bg-slate-800 text-white py-2 rounded text-sm hover:bg-slate-700">Cetak Label</button>
            </div>
            <div class="flex-1 w-full">
                <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mb-2">{{ $document->title }}</h3>
                <p class="text-slate-500 mb-6">{{ $document->category->name ?? '-' }}</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-2 text-sm">
                    <div class="text-slate-500">Nomor Arsip</div><div class="font-semibold text-slate-800 dark:text-slate-200">{{ $document->archive_code }}</div>
                    <div class="text-slate-500">Lokasi Fisik</div><div class="font-semibold text-slate-800 dark:text-slate-200">{{ $document->physical_location ?: '-' }}</div>
                    <div class="text-slate-500">Tanggal Masuk</div><div class="font-semibold text-slate-800 dark:text-slate-200">{{ $document->entry_date ? \Carbon\Carbon::parse($document->entry_date)->format('d F Y') : '-' }}</div>
                    <div class="text-slate-500 col-span-1 md:col-span-2 mt-4">Keterangan:</div>
                    <div class="col-span-1 md:col-span-2 text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-800/50 p-4 rounded border border-slate-200 dark:border-slate-700">{{ $document->description ?: 'Tidak ada keterangan.' }}</div>
                </div>
                <div class="mt-8 flex gap-2">
                    <a href="{{ route('documents.index') }}" class="btn-primary">Kembali</a>
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('documents.edit', $document) }}" class="bg-amber-500 hover:bg-amber-600 text-white py-2 px-4 rounded shadow">Edit Data</a>
                    @endif
                </div>
            </div>
        </div>
    </div></div>
</x-app-layout>
EOT,
];

foreach ($views as $path => $content) {
    @mkdir(dirname($path), 0777, true);
    file_put_contents($path, $content);
}
echo "All views generated.";
