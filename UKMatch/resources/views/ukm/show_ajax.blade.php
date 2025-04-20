<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail UKM</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                <h5><i class="icon fas fa-info-circle"></i> Informasi UKM</h5>
                Berikut adalah detail informasi UKM yang Anda pilih:
            </div>
            <table class="table table-sm table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>ID UKM:</th>
                        <td>{{ $ukm->id_ukm }}</td>
                    </tr>
                    <tr>
                        <th>Nama UKM:</th>
                        <td>{{ $ukm->nama_ukm }}</td>
                    </tr>
                    <tr>
                        <th>Kategori:</th>
                        <td>{{ $ukm->kategori->nama_kategori ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $ukm->email }}</td>
                    </tr>
                    <tr>
                        <th>Alamat:</th>
                        <td>{{ $ukm->alamat }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Berdiri:</th>
                        <td>{{ $ukm->tanggal_berdiri }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi:</th>
                        <td>{{ $ukm->deskripsi }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>{{ $ukm->status }}</td>
                    </tr>
                    <tr>
                        <th>Created at:</th>
                        <td>{{ $ukm->created_at }}</td>
                    </tr>
                    <tr>
                        <th>Updated at:</th>
                        <td>{{ $ukm->updated_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>