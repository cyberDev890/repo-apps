<x-corona-layout>
    <x-slot name="header">
        Edit Dokumen / Berkas
    </x-slot>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Dokumen: {{ $document->title }}</h4>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="forms-sample" action="{{ route('documents.update', $document) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="title">Judul Berkas/Dokumen *</label>
                                <input type="text" class="form-control text-white" id="title" name="title" value="{{ old('title', $document->title) }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="category_id">Kategori *</label>
                                <select class="form-control text-white" id="category_id" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $document->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="archive_code">Nomor Arsip / Kode *</label>
                                <input type="text" class="form-control text-white" id="archive_code" name="archive_code" value="{{ old('archive_code', $document->archive_code) }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="entry_date">Tanggal Masuk</label>
                                <input type="date" class="form-control text-white" id="entry_date" name="entry_date" value="{{ old('entry_date', $document->entry_date ? \Carbon\Carbon::parse($document->entry_date)->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="physical_location">Lokasi Fisik Arsip *</label>
                                <input type="text" class="form-control text-white" id="physical_location" name="physical_location" value="{{ old('physical_location', $document->physical_location) }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Ganti Foto Dokumen (Opsional, JPG/PNG, maks 5MB)</label>
                                <input type="file" name="photo" class="file-upload-default" accept="image/*" id="photoInput">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info text-white" disabled placeholder="Biarkan kosong jika tidak ingin mengubah foto">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" type="button" onclick="document.getElementById('photoInput').click()">Pilih File</button>
                                    </span>
                                </div>
                                @if($document->photo_path)
                                    <small class="text-info mt-2 d-block">Dokumen ini sudah memiliki foto. Upload foto baru akan menimpa foto lama.</small>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Keterangan / Ringkasan Isi</label>
                            <textarea class="form-control text-white" id="description" name="description" rows="4">{{ old('description', $document->description) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
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