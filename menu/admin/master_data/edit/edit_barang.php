<?php
require_once('../../../../functions/lib_function.php');
$id = $_POST['ids'];
$query = get_barang_byId($id);
$data = $query->fetch_array();
?>

<div class="modal-header bg-success">
    <h6 class="modal-title">Edit Barang</h6>
    <button type="button" class="close" data-dismiss="modal">×</button>
</div>
<form id="inp">
    <div class="modal-body">

        <div class="form-group">
            <label>Kode Barang:</label>
            <input value="<?= $data['id']; ?>" type="hidden" class="form-control" name="id">
            <input value="<?= $data['kd_barang']; ?>" type="text" class="form-control" name="kd_barang">
        </div>
        <div class="form-group">
            <label>Kategori:</label>
            <select required name="id_kategori" class="form-control">
                <option value="">Pilih Kategori</option>
                <?php
                $query = list_kategori();
                foreach ($query as $data2) :
                    ?>
                    <option <?php if ($data['id_kategori'] == $data2['id_kategori']) {
                                    echo 'selected';
                                } ?> value="<?= $data2['id_kategori']; ?>"><?= $data2['kategori']; ?></option>

                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Nama Barang:</label>
            <input value="<?= $data['nama_barang']; ?>" required type="text" class="form-control" name="nama_barang">
        </div>
        <div class="form-group">
            <label>Harga:</label>
            <input value="<?= $data['harga_barang']; ?>" required type="text" class="form-control" name="harga_barang">
        </div>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
        <button class="btn bg-success">Simpan</button>
    </div>

</form>


<script>
    //proses simpan
    $('#inp').submit(function(e) { //nek di klik id form urusan
        var url = 'menu/admin/master_data/proses/proses_barang.php'; //tujuan gantine action
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: url,
            data: 'edit=edit&' + $(this).serialize(),
            success: function(data) {

                var json_data = JSON.parse(data);
                if (json_data.status == 1) {
                    $('#tampil-data').load('menu/admin/master_data/view/v_barang.php');
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