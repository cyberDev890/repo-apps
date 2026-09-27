<x-corona-layout>
    <x-slot name="header">
        Detail Dokumen / Berkas
    </x-slot>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Informasi Dokumen: {{ $document->title }}</h4>
                        <div>
                            <a href="{{ route('documents.index') }}" class="btn btn-dark">Kembali</a>
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('documents.edit', $document) }}" class="btn btn-primary ml-2">Edit Data</a>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table table-borderless text-white">
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold" style="width: 35%;">Judul Berkas</td>
                                            <td>: {{ $document->title }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Kategori</td>
                                            <td>: {{ $document->category->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Nomor Arsip (Kode)</td>
                                            <td>: <span class="font-monospace text-info">{{ $document->archive_code }}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Tanggal Masuk</td>
                                            <td>: {{ $document->entry_date ? \Carbon\Carbon::parse($document->entry_date)->format('d F Y') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Lokasi Fisik</td>
                                            <td>: {{ $document->physical_location }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold align-top">Keterangan</td>
                                            <td class="text-wrap" style="white-space: pre-wrap;">: {{ $document->description ?: '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-5 d-flex flex-column align-items-center justify-content-center border-left border-secondary">
                            <h5 class="text-center mb-3">Foto Dokumen</h5>
                            @if($document->photo_path)
                                <div class="mb-3 text-center">
                                    <img src="{{ Storage::url($document->photo_path) }}" alt="Foto Dokumen" class="img-fluid rounded" style="max-height: 300px; max-width: 100%; object-fit: contain;">
                                </div>
                                <a href="{{ route('documents.download-photo', $document) }}" class="btn btn-success btn-icon-text">
                                    <i class="mdi mdi-download btn-icon-prepend"></i> Unduh Foto
                                </a>
                            @else
                                <div class="text-center p-4 border border-secondary rounded mb-3 w-100">
                                    <i class="mdi mdi-image-off text-muted" style="font-size: 4rem;"></i>
                                    <p class="text-muted mt-2">Tidak ada foto dokumen</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-corona-layout>