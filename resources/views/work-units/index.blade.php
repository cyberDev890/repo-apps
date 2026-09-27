<x-corona-layout>


    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Daftar Unit Kerja</h4>
                        @if(auth()->user()->role === 'admin')
                        <button type="button" class="btn btn-primary btn-icon-text" data-toggle="modal" data-target="#addWorkUnitModal">
                            <i class="mdi mdi-plus btn-icon-prepend"></i> Tambah Unit Kerja
                        </button>
                        @endif
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <form action="{{ route('work-units.index') }}" method="GET" id="search-form">
                                <div class="input-group">
                                    <input type="text" name="search" id="work-unit-search" value="{{ request('search') }}" class="form-control text-white" placeholder="Cari Unit Kerja..." autocomplete="off">
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead style="background-color: #0f1116;">
                                <tr class="text-white text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                                    <th class="font-weight-bold border-bottom-0 pb-3 pt-3">ID</th>
                                    <th class="font-weight-bold border-bottom-0 pb-3 pt-3">Kode Uker</th>
                                    <th class="font-weight-bold border-bottom-0 pb-3 pt-3">Nama Unit</th>
                                    <th class="font-weight-bold border-bottom-0 pb-3 pt-3">Kategori Uker</th>
                                    @if(auth()->user()->role === 'admin')
                                    <th class="font-weight-bold border-bottom-0 pb-3 pt-3 text-right">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($workUnits as $unit)
                                <tr>
                                    <td>{{ ($workUnits->currentPage() - 1) * $workUnits->perPage() + $loop->iteration }}</td>
                                    <td>{{ $unit->code ?? '-' }}</td>
                                    <td>{{ $unit->name }}</td>
                                    <td>
                                        <div class="badge {{ $unit->type == 'Kantor Cabang' ? 'badge-outline-primary' : ($unit->type == 'Unit' ? 'badge-outline-success' : 'badge-outline-warning') }}">
                                            {{ $unit->type }}
                                        </div>
                                    </td>
                                    @if(auth()->user()->role === 'admin')
                                    <td class="text-right">
                                        <div class="d-flex justify-content-end align-items-center">
                                            <a href="{{ route('work-units.edit', $unit) }}" class="btn btn-outline-info btn-sm mr-2" title="Edit">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <form action="{{ route('work-units.destroy', $unit) }}" method="POST" class="d-inline form-delete">
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
                    
                    <div class="mt-4" id="pagination-container">
                        {{ $workUnits->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('work-unit-search');
            const tableContainer = document.querySelector('.table-responsive');
            const paginationContainer = document.getElementById('pagination-container');
            let timeout = null;

            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    const query = this.value;
                    const url = new URL(window.location.href);
                    
                    if (query) {
                        url.searchParams.set('search', query);
                    } else {
                        url.searchParams.delete('search');
                    }
                    
                    fetch(url.toString(), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        const newTable = doc.querySelector('.table-responsive');
                        const newPagination = doc.getElementById('pagination-container');
                        
                        if (newTable && tableContainer) {
                            tableContainer.innerHTML = newTable.innerHTML;
                        }
                        
                        if (newPagination && paginationContainer) {
                            paginationContainer.innerHTML = newPagination.innerHTML;
                        }
                        
                        window.history.replaceState({}, '', url);
                    });
                }, 300); // 300ms debounce
            });

            document.addEventListener('submit', function(e) {
                if (e.target && e.target.matches('.form-delete')) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal',
                        background: '#191c24',
                        color: '#ffffff'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            e.target.submit();
                        }
                    });
                }
            });
        });
    </script>
    @if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#addWorkUnitModal').modal('show');
        });
    </script>
    @endif
    @endpush

    <!-- Modal Tambah Unit Kerja -->
    <div class="modal fade" id="addWorkUnitModal" tabindex="-1" role="dialog" aria-labelledby="addWorkUnitModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark text-white">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="addWorkUnitModalLabel">Tambah Unit Kerja Baru</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{ route('work-units.store') }}" method="POST">
            <div class="modal-body border-bottom-0">
                @csrf
                <div class="form-group">
                    <label for="code">Kode Uker</label>
                    <input type="text" class="form-control text-white @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" placeholder="Contoh: 0021" required>
                    @error('code')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Nama Unit Kerja</label>
                    <input type="text" class="form-control text-white @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Kantor Cabang Jember" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="type">Kategori Uker</label>
                    <select class="form-control text-white @error('type') is-invalid @enderror" id="type" name="type" required>
                        <option value="">Pilih Kategori Uker...</option>
                        <option value="Kantor Cabang" {{ old('type') == 'Kantor Cabang' ? 'selected' : '' }}>Kantor Cabang</option>
                        <option value="Unit" {{ old('type') == 'Unit' ? 'selected' : '' }}>Unit</option>
                        <option value="Kantor Cabang Pembantu" {{ old('type') == 'Kantor Cabang Pembantu' ? 'selected' : '' }}>Kantor Cabang Pembantu</option>
                    </select>
                    @error('type')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer border-top-0">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</x-corona-layout>
