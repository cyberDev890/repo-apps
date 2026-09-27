<x-corona-layout>
    <x-slot name="header">
        Tambah Unit Kerja
    </x-slot>

    <div class="row">
        <div class="col-md-6 grid-margin stretch-card mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tambah Unit Kerja Baru</h4>
                    
                    <form action="{{ route('work-units.store') }}" method="POST" class="forms-sample mt-4">
                        @csrf
                        <div class="form-group">
                            <label for="code">Kode Uker (Opsional)</label>
                            <input type="text" class="form-control text-white @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" placeholder="Contoh: 0021">
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
                            <label for="type">Tipe Unit</label>
                            <select class="form-control text-white @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Pilih Tipe Unit...</option>
                                <option value="Kantor Cabang" {{ old('type') == 'Kantor Cabang' ? 'selected' : '' }}>Kantor Cabang</option>
                                <option value="Unit" {{ old('type') == 'Unit' ? 'selected' : '' }}>Unit</option>
                                <option value="Kantor Cabang Pembantu" {{ old('type') == 'Kantor Cabang Pembantu' ? 'selected' : '' }}>Kantor Cabang Pembantu</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                        <a href="{{ route('work-units.index') }}" class="btn btn-dark">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-corona-layout>
