<x-corona-layout>
    <x-slot name="header">
        Kategori Aset
    </x-slot>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Daftar Kategori</h4>
                        @if(auth()->user()->role === 'admin')
                        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-icon-text">
                            <i class="mdi mdi-plus btn-icon-prepend"></i> Tambah Kategori
                        </a>
                        @endif
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6 position-relative">
                            <form action="{{ route('categories.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" id="category-search" value="{{ request('search') }}" class="form-control text-white" placeholder="Cari Kategori..." autocomplete="off">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">Cari</button>
                                    </div>
                                </div>
                            </form>
                            <div id="autocomplete-results" class="list-group position-absolute w-100 shadow mt-1" style="z-index: 1000; display: none;"></div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Tipe</th>
                                    @if(auth()->user()->role === 'admin')
                                    <th class="text-right">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <div class="badge {{ $category->type == 'perangkat' ? 'badge-outline-primary' : 'badge-outline-warning' }}">
                                            {{ ucfirst($category->type) }}
                                        </div>
                                    </td>
                                    @if(auth()->user()->role === 'admin')
                                    <td class="text-right">
                                        <div class="d-flex justify-content-end align-items-center">
                                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-info btn-sm mr-2" title="Edit">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');" class="d-inline">
                                                @csrf @method('DELETE') 
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Data tidak ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $categories->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('category-search');
            const resultsContainer = document.getElementById('autocomplete-results');
            let timeout = null;

            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                const query = this.value;

                if (query.length < 2) {
                    resultsContainer.style.display = 'none';
                    return;
                }

                timeout = setTimeout(() => {
                    fetch(`/categories/search/autocomplete?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            resultsContainer.innerHTML = '';
                            if (data.length > 0) {
                                data.forEach(item => {
                                    const a = document.createElement('a');
                                    a.href = `/categories/${item.id}/edit`;
                                    a.className = 'list-group-item list-group-item-action text-white bg-dark border-secondary';
                                    
                                    let subtext = item.type || '';
                                    if (subtext) subtext = ' - <small class="text-muted">' + subtext + '</small>';
                                    
                                    a.innerHTML = `<strong>${item.name}</strong>${subtext}`;
                                    resultsContainer.appendChild(a);
                                });
                                resultsContainer.style.display = 'block';
                            } else {
                                resultsContainer.style.display = 'none';
                            }
                        });
                }, 300);
            });

            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                    resultsContainer.style.display = 'none';
                }
            });
        });
    </script>
    @endpush
</x-corona-layout>