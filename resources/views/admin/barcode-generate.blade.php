<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate QR Code / Barcode Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Generate Barcode Siswa</h2>
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary btn-sm">← Kembali ke Data Siswa</a>
                </div>

                {{-- Alert Sukses --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Card Form Pilih Siswa --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Pilih Data Siswa</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.barcode.generate') }}" method="GET">
                            <div class="mb-3">
                                <label for="id" class="form-label">Cari atau Pilih Siswa:</label>
                                <select name="id" id="id" class="form-select" onchange="this.form.submit()">
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach($siswaList as $s)
                                        <option value="{{ $s->id }}" {{ request('id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->nama }} (NISN: {{ $s->nisn }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Card Tampilan QR Code / Barcode --}}
                @if($siswaSelected && $qrCode)
                    <div class="card shadow-sm text-center">
                        <div class="card-body py-4">
                            <h4 class="fw-bold mb-1">{{ $siswaSelected->nama }}</h4>
                            <p class="text-muted mb-2">NISN: {{ $siswaSelected->nisn }}</p>
                            
                            <div class="mb-3">
                                <span class="badge bg-info text-dark">
                                    Kelas: {{ $siswaSelected->kelas->nama_kelas ?? '-' }}
                                </span>
                                <span class="badge bg-secondary">
                                    Jurusan: {{ $siswaSelected->jurusan->nama_jurusan ?? '-' }}
                                </span>
                            </div>

                            <hr>

                            <div class="my-4 d-flex justify-content-center">
                                <div class="p-3 bg-white border rounded shadow-sm">
                                    {!! $qrCode !!}
                                </div>
                            </div>

                            <a href="{{ route('admin.barcode.download', $siswaSelected->id) }}" class="btn btn-success">
                                📥 Unduh Barcode (SVG)
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>