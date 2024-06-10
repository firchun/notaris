@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header flex-column flex-md-row">
                    <div class="head-label ">
                        <h5 class="card-title mb-0">{{ $title ?? 'Title' }}</h5>
                    </div>
                    <div class="dt-action-buttons text-end pt-3 pt-md-0">
                        <div class=" btn-group " role="group">
                            <form action="{{ url('/read-all') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <button class="btn btn-success " type="submit">
                                    <span>
                                        <i class="bx bx-bell me-sm-1"> </i>
                                        <span class="d-none d-sm-inline-block">Tandai semua telah dibaca</span>
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table id="datatable-layanans" class="table table-hover table-bordered display">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Waktu</th>
                                <th>Isi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notifikasi as $item)
                                <tr class="table-{{ $item->jenis }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->created_at->format('d F Y') }}</td>
                                    <td><a href="{{ url('/read-one', $item->id) }}">{{ $item->isi_notifikasi }}</a></td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $item->dibaca == 1 ? 'success' : 'danger' }}">{{ $item->dibaca == 1 ? 'Dibaca' : 'Belum' }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
