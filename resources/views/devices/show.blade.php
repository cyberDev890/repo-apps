<x-corona-layout>
    <x-slot name="header">
        Detail Perangkat IT
    </x-slot>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Informasi Perangkat: {{ $device->name }}</h4>
                        <div>
                            <a href="{{ route('devices.index') }}" class="btn btn-dark">Kembali</a>
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('devices.edit', $device) }}" class="btn btn-primary ml-2">Edit Data</a>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-borderless text-white">
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold" style="width: 35%;">Nama Perangkat</td>
                                            <td>: {{ $device->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Kategori</td>
                                            <td>: {{ $device->category->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Status</td>
                                            <td>: 
                                                <div class="badge {{ $device->status == 'aktif' ? 'badge-outline-success' : ($device->status == 'rusak' ? 'badge-outline-danger' : 'badge-outline-warning') }}">
                                                    {{ ucfirst($device->status) }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Serial Number (S/N)</td>
                                            <td>: {{ $device->serial_number ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Tanggal Beli</td>
                                            <td>: {{ $device->purchase_date ? \Carbon\Carbon::parse($device->purchase_date)->format('d F Y') : '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-borderless text-white">
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold" style="width: 35%;">Alamat IP</td>
                                            <td>: <span class="font-monospace">{{ $device->ip_address ?: '-' }}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">MAC Address</td>
                                            <td>: <span class="font-monospace">{{ $device->mac_address ?: '-' }}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Lokasi Fisik</td>
                                            <td>: {{ $device->location ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold align-top">Spesifikasi</td>
                                            <td class="text-wrap" style="white-space: pre-wrap;">: {{ $device->specifications ?: '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-corona-layout>
