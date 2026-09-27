<x-corona-layout>
    <x-slot name="header">
        Tambah Kategori Aset
    </x-slot>

    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Kategori Baru</h4>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="forms-sample" action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Kategori *</label>
                            <input type="text" class="form-control text-white" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama kategori" required>
                        </div>
                        <div class="form-group">
                            <label for="type">Tipe Kategori *</label>
                            <select class="form-control text-white" id="type" name="type" required>
                                <option value="perangkat" {{ old('type') == 'perangkat' ? 'selected' : '' }}>Perangkat IT</option>
                                <option value="dokumen" {{ old('type') == 'dokumen' ? 'selected' : '' }}>Berkas & Dokumen</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Simpan Kategori</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-dark">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-corona-layout>