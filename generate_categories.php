<?php
$views = [
    'resources/views/categories/index.blade.php' => <<<EOT
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
                        <td class="p-3">{{ \$category->id }}</td>
                        <td class="p-3 font-medium">{{ \$category->name }}</td>
                        <td class="p-3">{{ ucfirst(\$category->type) }}</td>
                        @if(auth()->user()->role === 'admin')
                        <td class="p-3 text-right flex justify-end space-x-2">
                            <a href="{{ route('categories.edit', \$category) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('categories.destroy', \$category) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                @csrf @method('DELETE') <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @empty <tr><td colspan="4" class="p-3 text-center">Data tidak ditemukan.</td></tr> @endforelse
                </tbody>
            </table>
        </div><div class="mt-4">{{ \$categories->links() }}</div></div>
    </div></div>
</x-app-layout>
EOT,
    'resources/views/categories/create.blade.php' => <<<EOT
<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">Tambah Kategori</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="glass-panel p-6 max-w-xl">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Nama Kategori</label>
                <input type="text" name="name" class="input-field" value="{{ old('name') }}" required></div>
                <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Tipe</label>
                <select name="type" class="input-field" required>
                    <option value="perangkat">Perangkat IT</option>
                    <option value="berkas">Berkas / Dokumen</option>
                </select></div>
                <button type="submit" class="btn-primary">Simpan</button>
            </form>
        </div>
    </div></div>
</x-app-layout>
EOT,
    'resources/views/categories/edit.blade.php' => <<<EOT
<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">Edit Kategori</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="glass-panel p-6 max-w-xl">
            <form action="{{ route('categories.update', \$category) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Nama Kategori</label>
                <input type="text" name="name" class="input-field" value="{{ old('name', \$category->name) }}" required></div>
                <div class="mb-4"><label class="block text-sm text-slate-700 dark:text-slate-300">Tipe</label>
                <select name="type" class="input-field" required>
                    <option value="perangkat" {{ \$category->type == 'perangkat' ? 'selected' : '' }}>Perangkat IT</option>
                    <option value="berkas" {{ \$category->type == 'berkas' ? 'selected' : '' }}>Berkas / Dokumen</option>
                </select></div>
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div></div>
</x-app-layout>
EOT,
];

foreach ($views as $path => $content) {
    @mkdir(dirname($path), 0777, true);
    file_put_contents($path, $content);
}
echo "Categories generated.";
