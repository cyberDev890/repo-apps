<x-corona-layout>
    <x-slot name="header">
        Edit Perangkat IT
    </x-slot>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Perangkat: {{ $device->name }}</h4>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="forms-sample" action="{{ route('devices.update', $device) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="name">Nama Perangkat *</label>
                                <input type="text" class="form-control text-white" id="name" name="name" value="{{ old('name', $device->name) }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="pengguna">Nama Pengguna (Opsional)</label>
                                <input type="text" class="form-control text-white" id="pengguna" name="pengguna" value="{{ old('pengguna', $device->pengguna) }}" placeholder="Contoh: Budi Santoso">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="category_id">Kategori *</label>
                                <select class="form-control text-white" id="category_id" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $device->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="ip_address">Alamat IP (Opsional)</label>
                                <input type="text" class="form-control text-white" id="ip_address" name="ip_address" value="{{ old('ip_address', $device->ip_address) }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="mac_address">MAC Address (Opsional)</label>
                                <input type="text" class="form-control text-white" id="mac_address" name="mac_address" value="{{ old('mac_address', $device->mac_address) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="serial_number">Serial Number (S/N)</label>
                                <input type="text" class="form-control text-white" id="serial_number" name="serial_number" value="{{ old('serial_number', $device->serial_number) }}">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="purchase_date">Tanggal Pembelian</label>
                                <input type="date" class="form-control text-white" id="purchase_date" name="purchase_date" value="{{ old('purchase_date', $device->purchase_date ? \Carbon\Carbon::parse($device->purchase_date)->format('Y-m-d') : '') }}">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="status">Status *</label>
                                <select class="form-control text-white" id="status" name="status" required>
                                    <option value="Aktif" {{ old('status', $device->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Rusak" {{ old('status', $device->status) == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                    <option value="Digudangkan" {{ old('status', $device->status) == 'Digudangkan' ? 'selected' : '' }}>Digudangkan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="work_unit_id">Unit Kerja *</label>
                                <select class="form-control text-white" id="work_unit_id" name="work_unit_id" required>
                                    <option value="">Pilih Unit Kerja...</option>
                                    @foreach($workUnits as $workUnit)
                                        <option value="{{ $workUnit->id }}" {{ old('work_unit_id', $device->work_unit_id) == $workUnit->id ? 'selected' : '' }}>{{ $workUnit->name }} ({{ $workUnit->type }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="location">Detail Lokasi Ruangan (Opsional)</label>
                                <input type="text" class="form-control text-white" id="location" name="location" value="{{ old('location', $device->location) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="specifications">Spesifikasi Detail</label>
                            <textarea class="form-control text-white" id="specifications" name="specifications" rows="4">{{ old('specifications', $device->specifications) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
                        <a href="{{ route('devices.index') }}" class="btn btn-dark">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category_id');
            const ipLabel = document.querySelector('label[for="ip_address"]');
            const ipInput = document.getElementById('ip_address');

            function updateIpRequirement() {
                if (!categorySelect || !ipLabel || !ipInput) return;
                const selectedText = categorySelect.options[categorySelect.selectedIndex]?.text.toLowerCase() || '';
                if (selectedText.includes('komputer') || selectedText.includes('laptop') || selectedText.includes('pc') || selectedText.includes('server')) {
                    ipLabel.innerHTML = 'Alamat IP *';
                    ipInput.setAttribute('required', 'required');
                } else {
                    ipLabel.innerHTML = 'Alamat IP (Opsional)';
                    ipInput.removeAttribute('required');
                }
            }

            if (categorySelect) {
                categorySelect.addEventListener('change', updateIpRequirement);
                updateIpRequirement(); // Initial check
            }
        });
    </script>
    @endpush
</x-corona-layout>