@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Form Pengajuan Perbaikan / Kalibrasi Alat</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('maintenance.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="equipment_id" class="form-label">Pilih Alat</label>
                            <select name="equipment_id" id="equipment_id" class="form-select @error('equipment_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Alat --</option>
                                @foreach($equipments as $equipment)
                                    <option value="{{ $equipment->id }}" 
                                        {{ (request('equipment_id') == $equipment->id || old('equipment_id') == $equipment->id) ? 'selected' : '' }}>
                                        {{ $equipment->nama_alat }} ({{ $equipment->lab->nama_lab ?? 'Tanpa Lab' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('equipment_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="issue_description" class="form-label">Deskripsi Masalah</label>
                            <textarea name="issue_description" id="issue_description" rows="4" 
                                class="form-control @error('issue_description') is-invalid @enderror" 
                                placeholder="Contoh: Alat perlu kalibrasi tahunan atau deskripsi kerusakan lainnya..." required>{{ old('issue_description') }}</textarea>
                            @error('issue_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="urgency" class="form-label">Urgency</label>
                                <select name="urgency" id="urgency" class="form-select">
                                    <option value="Low" {{ old('urgency') == 'Low' ? 'selected' : '' }}>Low</option>
                                    <option value="Medium" {{ old('urgency') == 'Medium' ? 'selected' : '' }} selected>Medium</option>
                                    <option value="High" {{ old('urgency') == 'High' ? 'selected' : '' }}>High</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="damage_level" class="form-label">Tingkat Kerusakan</label>
                                <select name="damage_level" id="damage_level" class="form-select">
                                    <option value="Ringan" {{ old('damage_level') == 'Ringan' ? 'selected' : '' }} selected>Ringan (Kalibrasi Rutin)</option>
                                    <option value="Sedang" {{ old('damage_level') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="Berat" {{ old('damage_level') == 'Berat' ? 'selected' : '' }}>Berat</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="foto_kerusakan" class="form-label">Foto Kondisi Alat (Opsional)</label>
                            <input type="file" name="foto_kerusakan" id="foto_kerusakan" class="form-control @error('foto_kerusakan') is-invalid @enderror">
                            <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                            @error('foto_kerusakan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary px-4">Kirim Pengajuan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection