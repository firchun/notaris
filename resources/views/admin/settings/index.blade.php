@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="card">
        <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
                <span class="card-title">{{ $title }}</span>
            </div>
            <div class="card-body">
                <input type="hidden" name="id" id="idSetting" value="{{ $setting ? $setting->id : null }}">
                <div class="mb-3">
                    <label for="formTentangKami">Tentang Kami</label>
                    <textarea class="form-control" id="formTentangKami" name="tentang_kami">{{ $setting ? $setting->tentang_kami : '-' }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="formNomor">Nomor HP/WA</label>
                    <input type="text" id="formNomor" name="no_hp" class="form-control" placeholder="Nomor HP/WA"
                        value="{{ $setting ? $setting->no_hp : '-' }}">
                </div>
                <div class="mb-3">
                    <label for="formEmail">Alamat Email</label>
                    <input type="email" id="formEmail" name="email" class="form-control" placeholder="Email address"
                        value="{{ $setting ? $setting->email : '-' }}">
                </div>
                <div class="mb-3">
                    <label for="formAlamat">Alamat Kantor</label>
                    <textarea class="form-control" id="formAlamat" name="alamat">{{ $setting ? $setting->alamat : '-' }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" id="btnSaveSetting">Simpan perubahan</button>
            </div>
        </form>
    </div>
@endsection
