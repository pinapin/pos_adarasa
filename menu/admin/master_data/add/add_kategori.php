<div class="modal-header bg-primary">
    <h6 class="modal-title">Tambah Kategori</h6>
    <button type="button" class="close" data-dismiss="modal">×</button>
</div>
<form id="inp">
    <div class="modal-body">

        <div class="form-group">
            <label>Kategori:</label>
            <input type="text" class="form-control" name="kategori">
        </div>





    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
        <button class="btn bg-primary">Simpan</button>
    </div>

</form>


<script>
    //proses simpan
    $('#inp').submit(function(e) { //nek di klik id form urusan
        var url = 'menu/admin/master_data/proses/proses_kategori.php'; //tujuan gantine action
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: url,
            data: 'simpan=simpan&' + $(this).serialize(),
            success: function(data) {

                var json_data = JSON.parse(data);
                if (json_data.status == 1) {
                    $('#tampil-data').load('menu/admin/master_data/view/v_kategori.php');
                    $('#peringatan').html('<div class="alert alert-success">' + json_data.pesan + '</div>');

                } else {
                    $('#peringatan').html('<div class="alert alert-danger">' + json_data.pesan + '</div>');

                }
                $('.alert').fadeOut(5000);
                $('.modal-backdrop').fadeOut(1);
                $('#modal').fadeOut(1);
                $('#modal').modal('hide');
            }
        });
    });
</script>