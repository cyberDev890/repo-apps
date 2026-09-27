<x-corona-layout>
    <x-slot name="header">
        Dashboard Inventaris
    </x-slot>

    <div class="row">
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ $totalDevices }}</h3>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-primary">
                                <span class="mdi mdi-laptop icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal mt-3">Total Perangkat</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ $totalDocuments }}</h3>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-info">
                                <span class="mdi mdi-file-document-box icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal mt-3">Total Dokumen</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ $activeDevices }}</h3>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success">
                                <span class="mdi mdi-check-circle icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal mt-3">Perangkat Aktif (Utilisasi IP: {{ $ipUtilization }}%)</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Statistik Berdasarkan Kategori</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Kategori</th>
                                    <th>Tipe</th>
                                    <th>Jumlah Item</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categoriesStats as $cat)
                                <tr>
                                    <td>{{ $cat->name }}</td>
                                    <td>
                                        <div class="badge {{ $cat->type == 'perangkat' ? 'badge-outline-primary' : 'badge-outline-warning' }}">
                                            {{ ucfirst($cat->type) }}
                                        </div>
                                    </td>
                                    <td>{{ $cat->type == 'perangkat' ? $cat->devices_count : $cat->documents_count }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada data.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-corona-layout>
