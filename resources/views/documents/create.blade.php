<x-corona-layout>
    <x-slot name="header">
        Tambah Dokumen / Berkas
    </x-slot>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Dokumen Baru</h4>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="forms-sample" action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="title">Judul Berkas/Dokumen *</label>
                                <input type="text" class="form-control text-white" id="title" name="title" value="{{ old('title') }}" required>
                            </div>
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
                                <label for="archive_code">Nomor Arsip / Kode *</label>
                                <input type="text" class="form-control text-white" id="archive_code" name="archive_code" value="{{ old('archive_code') }}" required placeholder="Misal: BRI/2026/01/001">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="entry_date">Tanggal Masuk</label>
                                <input type="date" class="form-control text-white" id="entry_date" name="entry_date" value="{{ old('entry_date') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="physical_location">Lokasi Fisik Arsip *</label>
                                <input type="text" class="form-control text-white" id="physical_location" name="physical_location" value="{{ old('physical_location') }}" required placeholder="Misal: Lemari A, Rak 2">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Unggah Foto Dokumen (Opsional, JPG/PNG, maks 5MB)</label>
                                <input type="file" name="photo" class="file-upload-default" accept="image/*" id="photoInput">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info text-white" disabled placeholder="Pilih foto dokumen">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" type="button" onclick="document.getElementById('photoInput').click()">Pilih File</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Keterangan / Ringkasan Isi</label>
                            <textarea class="form-control text-white" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Simpan Dokumen</button>
                        <a href="{{ route('documents.index') }}" class="btn btn-dark">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.getElementById('photoInput').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var infoField = this.parentNode.querySelector('.file-upload-info');
            if (infoField) infoField.value = fileName;
        });
    </script>
    @endpush
</x-corona-layout>