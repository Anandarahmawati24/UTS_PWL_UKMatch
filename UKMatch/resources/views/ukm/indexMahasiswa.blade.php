@extends('layouts.template')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
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
                        <select class="form-control" id="kategori_filter" name="kategori_filter">
                            <option value="">- Semua -</option>
                            @foreach($kategori_ukm as $item)
                            <option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Filter berdasarkan kategori</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table to display UKM -->
        <table class="table table-bordered table-striped table-hover table-sm" id="table_ukm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama UKM</th>
                    <th>Email</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th> <!-- Kolom untuk aksi (Detail) -->
                </tr>
            </thead>
            <tbody>
                <!-- Data akan dimuat menggunakan DataTables -->
            </tbody>
        </table>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
<script>
           function modalAction(element) {
    let url = typeof element === "string" ? element : element.getAttribute("data-url");
    $('#myModal').load(url, function() {
        $('#myModal').modal('show');
    });
}
    var dataUkm;
    $(document).ready(function() {
        // Initialize DataTable
        dataUkm = $('#table_ukm').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('ukm/list_mahasiswa') }}",  // URL yang sesuai dengan route di controller
                "type": "POST",
                "data": function(d) {
                    d.id_kategori = $('#kategori_filter').val();  // Mengirim filter kategori
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",  // Kolom index (nomor urut)
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "nama_ukm"  // Nama UKM
                },
                {
                    data: "email"  // Email
                },
                {
                    data: "nama_kategori"  // Nama kategori UKM
                },
                {
                    data: "status",  // Status UKM
                    className: "text-center"
                },
                {
                    data: "aksi",  // Kolom Aksi (Detail)
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Reload DataTable ketika filter kategori berubah
        $('#kategori_filter').on('change', function() {
            dataUkm.ajax.reload();
        });
    });
</script>
@endpush