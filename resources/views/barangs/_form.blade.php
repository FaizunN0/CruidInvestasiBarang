  {{-- jika ada yang salah atau eror atau yang lain maka iti fitur bukan bug 😅 --}}
<div class="mb-3">
    <label class="form-label">Kode Barang</label>
    <input type="text" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang ?? '') }}"
        class="form-control @error('kode_barang') is-invalid @enderror">
    @error('kode_barang')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nama Barang</label>
    <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang ?? '') }}"
        class="form-control @error('nama_barang') is-invalid @enderror">
    @error('nama_barang')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Jumlah</label>
    <input type="number" name="jumlah" value="{{ old('jumlah', $barang->jumlah ?? '') }}"
        class="form-control @error('jumlah') is-invalid @enderror">
    @error('jumlah')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Satuan</label>
    <input type="text" name="satuan" value="{{ old('satuan', $barang->satuan ?? '') }}"
        class="form-control @error('satuan') is-invalid @enderror">
    @error('satuan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Lokasi</label>
    <input type="text" name="lokasi" value="{{ old('lokasi', $barang->lokasi ?? '') }}"
        class="form-control @error('lokasi') is-invalid @enderror">
    @error('lokasi')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex justify-content-between mt-4">
    <button type="submit" class="btn btn-primary">
        {{ $buttonText }}
    </button>
    <a href="{{ route('barangs.index') }}" class="btn btn-secondary">
        ← Batal
    </a>
</div>
