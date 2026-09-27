<x-corona-layout>
    <x-slot name="header">
        Tambah Perangkat IT
    </x-slot>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Perangkat Baru</h4>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="forms-sample" action="{{ route('devices.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="name">Nama Perangkat *</label>
                                <input type="text" class="form-control text-white" id="name" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="pengguna">Nama Pengguna (Opsional)</label>
                                <input type="text" class="form-control text-white" id="pengguna" name="pengguna" value="{{ old('pengguna') }}" placeholder="Contoh: Budi Santoso">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="category_id">Kategori *</label>
                                <select class="form-control text-white" id="category_id" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="ip_address">Alamat IP (Opsional)</label>
                                <input type="text" class="form-control text-white" id="ip_address" name="ip_address" value="{{ old('ip_address') }}" placeholder="192.168.1.x">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="mac_address">MAC Address (Opsional)</label>
                                <input type="text" class="form-control text-white" id="mac_address" name="mac_address" value="{{ old('mac_address') }}" placeholder="00:1A:2B:3C:4D:5E">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="serial_number">Serial Number (S/N)</label>
                                <input type="text" class="form-control text-white" id="serial_number" name="serial_number" value="{{ old('serial_number') }}">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="purchase_date">Tanggal Pembelian</label>
                                <input type="date" class="form-control text-white" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="status">Status *</label>
                                <select class="form-control text-white" id="status" name="status" required>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Rusak">Rusak</option>
                                    <option value="Digudangkan">Digudangkan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="work_unit_id">Unit Kerja *</label>
                                <select class="form-control text-white" id="work_unit_id" name="work_unit_id" required>
                                    <option value="">Pilih Unit Kerja...</option>
                                    @foreach($workUnits as $workUnit)
                                        <option value="{{ $workUnit->id }}" {{ old('work_unit_id') == $workUnit->id ? 'selected' : '' }}>{{ $workUnit->name }} ({{ $workUnit->type }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="location">Detail Lokasi Ruangan (Opsional)</label>
                                <input type="text" class="form-control text-white" id="location" name="location" value="{{ old('location') }}" placeholder="Misal: Ruang Server, Meja 5">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="specifications">Spesifikasi Detail</label>
                            <textarea class="form-control text-white" id="specifications" name="specifications" rows="4">{{ old('specifications') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Simpan Perangkat</button>
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