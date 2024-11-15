@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            {{-- <button onclick="modalAction('{{ url('/sertifikasi/import') }}')" class="btn btn-info">Import Sertifikasi</button>
            <a href="{{ url('/sertifikasi/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export Sertifikasi Excel</a>
            <a href="{{ url('/sertifikasi/export_pdf') }}" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Export Sertifikasi PDF</a> --}}
            <a href="{{ url('/sertifikasi/create') }}" class="btn btn-warning"> Tambah Sertifikasi</a>
            {{-- <button onclick="modalAction('{{ url('/sertifikasi/create_ajax') }}')" class="btn btn-success">Tambah Sertifikasi (Ajax)</button> --}}
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Filter:</label>
                    <div class="col-3">
                        <select class="form-control" id="jenis_id" name="jenis_id">
                            <option value="">- Semua -</option>
                            @foreach($jenis as $item)
                                <option value="{{ $item->jenis_id }}">{{ $item->nama_jenis }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Jenis Sertifikasi</small>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-striped table-hover table-sm" id="table_sertifikasi">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Sertifikasi</th>
                    <th>Tanggal</th>
                    <th>Bidang</th>
                    <th>Jenis Sertifikasi</th>
                    <th>Tanggal Berlaku</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    var dataSertifikasi;

    $(document).ready(function() {
        dataSertifikasi = $('#table_sertifikasi').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('sertifikasi/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.jenis_id = $('#jenis_id').val();
                }
            },
            columns: [
                {
                    data: "sertifikasi_id",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "nama_sertifikasi",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "tanggal",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "bidang.nama_bidang", // menampilkan nama bidang jika ada relasi
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "jenis.nama_jenis", // menampilkan nama jenis sertifikasi jika ada relasi
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "tanggal_berlaku",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#jenis_id').on('change', function() {
            dataSertifikasi.ajax.reload();
        });
    });
</script>
@endpush
