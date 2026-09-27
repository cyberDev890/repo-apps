<x-corona-layout>


    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">{{ $pageTitle ?? 'Daftar Perangkat IT' }}</h4>
                        @if(auth()->user()->role === 'admin')
                        <div>
                            <a href="{{ route('devices.export') }}" class="btn btn-outline-secondary btn-icon-text mr-2">
                                <i class="mdi mdi-download btn-icon-prepend"></i> Export CSV
                            </a>
                            <button type="button" class="btn btn-primary btn-icon-text" data-toggle="modal" data-target="#addDeviceModal">
                                <i class="mdi mdi-plus btn-icon-prepend"></i> Tambah Perangkat
                            </button>
                        </div>
                        @endif
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <form action="{{ request()->url() }}" method="GET" id="search-form">
                                <div class="input-group">
                                    <input type="text" name="search" id="device-search" value="{{ request('search') }}" class="form-control text-white" placeholder="Cari Perangkat (Nama, SN, IP)..." autocomplete="off">
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover" style="white-space: nowrap;">
                            <thead style="background-color: #0f1116;">
                                <tr class="text-white text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                                    <th class="font-weight-bold border-bottom-0 pb-3 pt-3">Nama Pengguna</th>
                                    @if(isset($pageTitle) && in_array($pageTitle, ['Komputer', 'Laptop']))
                                    <th class="font-weight-bold border-bottom-0 pb-3 pt-3">Jabatan</th>
                                    @endif
                                    <th class="font-weight-bold border-bottom-0 pb-3 pt-3">Nama Perangkat</th>
                                    <th class="font-weight-bold border-bottom-0 pb-3 pt-3">Serial Number</th>
                                    <th class="font-weight-bold border-bottom-0 pb-3 pt-3">Kode Uker</th>
                                    <th class="font-weight-bold border-bottom-0 pb-3 pt-3">Lokasi</th>
                                    <th class="font-weight-bold border-bottom-0 pb-3 pt-3">Status</th>
                                    <th class="font-weight-bold border-bottom-0 pb-3 pt-3">Spesifikasi</th>
                                    @if(auth()->user()->role === 'admin')
                                    <th class="font-weight-bold border-bottom-0 pb-3 pt-3 text-right">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($devices as $device)
                                <tr>
                                    <td>{{ $device->pengguna ?: '-' }}</td>
                                    @if(isset($pageTitle) && in_array($pageTitle, ['Komputer', 'Laptop']))
                                    <td>{{ $device->jabatan ?: '-' }}</td>
                                    @endif
                                    <td>
                                        <span class="font-weight-bold">{{ $device->name }}</span><br>
                                        <small class="text-muted">{{ $device->category->name ?? '-' }}</small>
                                    </td>
                                    <td>{{ $device->serial_number ?: '-' }}</td>
                                    <td>{{ $device->workUnit ? $device->workUnit->code : '-' }}</td>
                                    <td>{{ $device->location ?: '-' }}</td>
                                    <td>
                                        <div class="badge {{ $device->status == 'aktif' ? 'badge-outline-success' : ($device->status == 'rusak' ? 'badge-outline-danger' : 'badge-outline-warning') }}">
                                            {{ ucfirst($device->status) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $device->specifications }}">
                                            {{ $device->specifications ?: '-' }}
                                        </div>
                                    </td>
                                    @if(auth()->user()->role === 'admin')
                                    <td class="text-right">
                                        <div class="d-flex justify-content-end align-items-center">
                                            <button type="button" class="btn btn-outline-info btn-sm mr-2" data-toggle="modal" data-target="#editDeviceModal-{{ $device->id }}" title="Edit">
                                                <i class="mdi mdi-pencil"></i>
                                            </button>
                                            <form action="{{ route('devices.destroy', $device) }}" method="POST" class="d-inline form-delete">
                                                @csrf @method('DELETE') 
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    @endif
                                </tr>

                                <!-- Modal Edit Perangkat -->
                                <div class="modal fade" id="editDeviceModal-{{ $device->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content bg-dark text-white">
                                      <div class="modal-header border-bottom-0">
                                        <h5 class="modal-title">Edit Perangkat IT</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <form action="{{ route('devices.update', $device) }}" method="POST">
                                        <div class="modal-body border-bottom-0">
                                            @csrf @method('PUT')
                                            <div class="form-group">
                                                <label>Nama Pengguna *</label>
                                                <input type="text" class="form-control text-white" name="pengguna" value="{{ $device->pengguna }}" required>
                                            </div>
                                            @if(isset($pageTitle) && in_array($pageTitle, ['Komputer', 'Laptop']))
                                            <div class="form-group">
                                                <label>Jabatan *</label>
                                                <input type="text" class="form-control text-white" name="jabatan" value="{{ $device->jabatan }}" required>
                                            </div>
                                            @endif
                                            <div class="form-group">
                                                <label>Nama Perangkat *</label>
                                                <input type="text" class="form-control text-white" name="name" value="{{ $device->name }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Serial Number (S/N)</label>
                                                <input type="text" class="form-control text-white" name="serial_number" value="{{ $device->serial_number }}">
                                            </div>
                                            <div class="form-group d-none">
                                                <label>Kategori *</label>
                                                <select class="form-control text-white" name="category_id" required>
                                                    @foreach(\App\Models\Category::all() as $category)
                                                        <option value="{{ $category->id }}" {{ $device->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @php
                                                $isComputerOrLaptop = $device->category && (stripos($device->category->name, 'Komputer') !== false || stripos($device->category->name, 'Laptop') !== false || stripos($device->category->name, 'PC') !== false || stripos($device->category->name, 'Server') !== false);
                                            @endphp
                                            <div class="form-group">
                                                <label>Alamat IP {{ $isComputerOrLaptop ? '*' : '(Opsional)' }}</label>
                                                <input type="text" class="form-control text-white" name="ip_address" value="{{ $device->ip_address }}" {{ $isComputerOrLaptop ? 'required' : '' }}>
                                            </div>
                                            <div class="form-group">
                                                <label>Unit Kerja *</label>
                                                <select class="form-control text-white select2-workunit" name="work_unit_id" required style="width: 100%;">
                                                    <option value="">Pilih Unit Kerja...</option>
                                                    @foreach(\App\Models\WorkUnit::all() as $workUnit)
                                                        <option value="{{ $workUnit->id }}" {{ $device->work_unit_id == $workUnit->id ? 'selected' : '' }}>{{ $workUnit->name }} ({{ $workUnit->code }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Lokasi *</label>
                                                <input type="text" class="form-control text-white" name="location" value="{{ $device->location }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Status *</label>
                                                <select class="form-control text-white" name="status" required>
                                                    <option value="Aktif" {{ strtolower($device->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="Rusak" {{ strtolower($device->status) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                                    <option value="Digudangkan" {{ strtolower($device->status) == 'digudangkan' ? 'selected' : '' }}>Digudangkan</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Spesifikasi Detail</label>
                                                <textarea class="form-control text-white" name="specifications" rows="4">{{ $device->specifications }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Data tidak ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4" id="pagination-container">
                        {{ $devices->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            background-color: #2A3038;
            border: 1px solid #2c2e33;
            height: calc(2.25rem + 2px);
            padding: 0.375rem 0.75rem;
            color: #ffffff;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #ffffff;
            line-height: 1.5;
            padding-left: 0;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
        }
        .select2-dropdown {
            background-color: #2A3038;
            border: 1px solid #2c2e33;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            background-color: #191c24;
            color: #ffffff;
            border: 1px solid #2c2e33;
        }
        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #0090e7;
            color: white;
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #191c24;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $(document).on('shown.bs.modal', '.modal', function() {
                $(this).find('.select2-workunit').select2({
                    dropdownParent: $(this),
                    width: '100%'
                });
            });

            const searchInput = document.getElementById('device-search');
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
            $('#addDeviceModal').modal('show');
        });
    </script>
    @endif
    @endpush

    <!-- Modal Tambah Perangkat -->
    <div class="modal fade" id="addDeviceModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark text-white">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title">Tambah Perangkat IT Baru</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{ route('devices.store') }}" method="POST">
            <div class="modal-body border-bottom-0">
                @csrf
                <div class="form-group">
                    <label>Nama Pengguna *</label>
                    <input type="text" class="form-control text-white @error('pengguna') is-invalid @enderror" name="pengguna" value="{{ old('pengguna') }}" required>
                    @error('pengguna')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                </div>
                @if(isset($pageTitle) && in_array($pageTitle, ['Komputer', 'Laptop']))
                <div class="form-group">
                    <label>Jabatan *</label>
                    <input type="text" class="form-control text-white @error('jabatan') is-invalid @enderror" name="jabatan" value="{{ old('jabatan') }}" required>
                    @error('jabatan')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                </div>
                @endif
                <div class="form-group">
                    <label>Nama Perangkat *</label>
                    <input type="text" class="form-control text-white @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                    @error('name')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                </div>
                <div class="form-group">
                    <label>Serial Number (S/N)</label>
                    <input type="text" class="form-control text-white @error('serial_number') is-invalid @enderror" name="serial_number" value="{{ old('serial_number') }}">
                    @error('serial_number')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                </div>
                <div class="form-group d-none">
                    <label>Kategori *</label>
                    <select class="form-control text-white @error('category_id') is-invalid @enderror" name="category_id" required>
                        @php
                            $searchQuery = isset($pageTitle) && in_array($pageTitle, ['Komputer', 'Laptop', 'Printer']) ? $pageTitle : 'Komputer';
                            if (isset($pageTitle) && $pageTitle == 'Infrastruktur Jaringan') $searchQuery = 'Router';
                            $defaultCat = \App\Models\Category::where('name', 'like', '%' . $searchQuery . '%')->first();
                            $defaultCatId = $defaultCat ? $defaultCat->id : 1;
                            $isComputerOrLaptopAdd = $defaultCat && (stripos($defaultCat->name, 'Komputer') !== false || stripos($defaultCat->name, 'Laptop') !== false || stripos($defaultCat->name, 'PC') !== false || stripos($defaultCat->name, 'Server') !== false);
                        @endphp
                        @foreach(\App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}" {{ $defaultCatId == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                </div>
                <div class="form-group">
                    <label>Alamat IP {{ $isComputerOrLaptopAdd ? '*' : '(Opsional)' }}</label>
                    <input type="text" class="form-control text-white @error('ip_address') is-invalid @enderror" name="ip_address" value="{{ old('ip_address') }}" {{ $isComputerOrLaptopAdd ? 'required' : '' }}>
                    @error('ip_address')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                </div>
                <div class="form-group">
                    <label>Unit Kerja *</label>
                    <select class="form-control text-white select2-workunit @error('work_unit_id') is-invalid @enderror" name="work_unit_id" required style="width: 100%;">
                        <option value="">Pilih Unit Kerja...</option>
                        @foreach(\App\Models\WorkUnit::all() as $workUnit)
                            <option value="{{ $workUnit->id }}">{{ $workUnit->name }} ({{ $workUnit->code }})</option>
                        @endforeach
                    </select>
                    @error('work_unit_id')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                </div>
                <div class="form-group">
                    <label>Lokasi *</label>
                    <input type="text" class="form-control text-white @error('location') is-invalid @enderror" name="location" value="{{ old('location') }}" required>
                    @error('location')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                </div>
                <div class="form-group">
                    <label>Status *</label>
                    <select class="form-control text-white @error('status') is-invalid @enderror" name="status" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Rusak">Rusak</option>
                        <option value="Digudangkan">Digudangkan</option>
                    </select>
                    @error('status')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                </div>
                <div class="form-group">
                    <label>Spesifikasi Detail</label>
                    <textarea class="form-control text-white @error('specifications') is-invalid @enderror" name="specifications" rows="4">{{ old('specifications') }}</textarea>
                    @error('specifications')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
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