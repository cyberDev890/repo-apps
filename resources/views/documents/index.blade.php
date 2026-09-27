<x-corona-layout>
    <x-slot name="header">
        Berkas & Dokumen
    </x-slot>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Daftar Dokumen</h4>
                        @if(auth()->user()->role === 'admin')
                        <div>
                            <a href="{{ route('documents.export') }}" class="btn btn-outline-secondary btn-icon-text mr-2">
                                <i class="mdi mdi-download btn-icon-prepend"></i> Export CSV
                            </a>
                            <a href="{{ route('documents.create') }}" class="btn btn-primary btn-icon-text">
                                <i class="mdi mdi-plus btn-icon-prepend"></i> Tambah Dokumen
                            </a>
                        </div>
                        @endif
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6 position-relative">
                            <form action="{{ route('documents.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" id="document-search" value="{{ request('search') }}" class="form-control text-white" placeholder="Cari Dokumen..." autocomplete="off">
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
                                    <th>Judul Berkas</th>
                                    <th>Nomor Arsip (Kode)</th>
                                    <th>Lokasi Fisik</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Detail</th>
                                    @if(auth()->user()->role === 'admin')
                                    <th class="text-right">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $doc)
                                <tr>
                                    <td>
                                        <span class="font-weight-bold">{{ $doc->title }}</span><br>
                                        <small class="text-muted">{{ $doc->category->name ?? '-' }}</small>
                                    </td>
                                    <td><span class="font-monospace text-muted">{{ $doc->archive_code }}</span></td>
                                    <td>{{ $doc->physical_location }}</td>
                                    <td>{{ $doc->entry_date ? \Carbon\Carbon::parse($doc->entry_date)->format('d M Y') : '-' }}</td>
                                    <td>
                                        <a href="{{ route('documents.show', $doc) }}" class="btn btn-outline-info btn-sm">Lihat Detail</a>
                                    </td>
                                    @if(auth()->user()->role === 'admin')
                                    <td class="text-right">
                                        <div class="d-flex justify-content-end align-items-center">
                                            <a href="{{ route('documents.edit', $doc) }}" class="btn btn-outline-info btn-sm mr-2" title="Edit">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <form action="{{ route('documents.destroy', $doc) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');" class="d-inline">
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
                                    <td colspan="6" class="text-center text-muted">Data tidak ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $documents->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('document-search');
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
                    fetch(`/documents/search/autocomplete?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            resultsContainer.innerHTML = '';
                            if (data.length > 0) {
                                data.forEach(item => {
                                    const a = document.createElement('a');
                                    a.href = `/documents/${item.id}`;
                                    a.className = 'list-group-item list-group-item-action text-white bg-dark border-secondary';
                                    
                                    let subtext = item.archive_code || '';
                                    if (subtext) subtext = ' - <small class="text-muted">' + subtext + '</small>';
                                    
                                    a.innerHTML = `<strong>${item.title}</strong>${subtext}`;
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