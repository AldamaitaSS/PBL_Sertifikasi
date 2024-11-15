@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            {{-- <button onclick="modalAction('{{ url('/pelatihan/import') }}')" class="btn btn-info">Import User</button>
            <a href="{{ url('/pelatihan/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export User Excel</a>
            <a href="{{ url('/pelatihan/export_pdf') }}" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Export User PDF</a> --}}
            <a href="{{ url('/pelatihan/create') }}" class="btn btn-warning"> Tambah Pelatihan</a>
            {{-- <button onclick="modalAction('{{ url('/user/create_ajax') }}')" class="btn btn-success">Tambah User (Ajax)</button> --}}
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{session('success')}}</div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger">{{session('error')}}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="level_pelatihan_id" name="level_pelatihan_id" required>
                                <option value="">- Semua -</option>
                                @foreach($pelatihan as $item)
                                    <option value="{{ $item->level_pelatihan_id }}">{{ $item->level_pelatihan_id }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Level Pelatihan</small>
                        </div>
                    </div>
                </div>
            </div>

        <table class="table table-bordered table-striped table-hover table-sm" id="table_pelatihan">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Pelatihan</th>
                    <th>Tanggal</th>
                    <th>Bidang</th>
                    <th>Level Pelatihan</th>
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
        $('#myModal').load(url,function() {
            $('#myModal').modal('show');
        });
    }

    var dataPelatihan;

    $(document).ready(function() {
        dataPelatihan = $('#table_pelatihan').DataTable({
            // serverSide: true, jika ingin menggunakan server side processing
            serverSide: true,
            ajax: {
                "url": "{{ url('pelatihan/list') }}",
                "dataType": "json",
                "type": "POST",

                "data": function(d) {
                    d.level_pelatihan_id = $('#level_pelatihan_id').val();
                }
            },
            columns: [
                {
                    data: "level_pelatihan_id",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "nama_pelatihan",
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
                    // mengambil data level hasil dari ORM berelasi
                    data: "bidang.nama_bidang",
                    className: "",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "level.level_nama", // menampilkan nama level pelatihan jika ada relasi
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

        $('#level_id').on('change',function() {
            dataUser.ajax.reload();
        })

    });
</script>
@endpush