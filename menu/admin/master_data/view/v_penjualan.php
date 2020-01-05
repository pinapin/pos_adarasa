<table class="table datatable-basic table-hover">
    <thead>
        <tr style="text-transform: uppercase">
            <th>No</th>
            <th>Kode Brg</th>
            <th>Nama Brg</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Subtotal</th>

            <th class="text-center" style="width: 20%">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "../../../../functions/lib_function.php";
        $no = 1;
        $query = list_tmp_penjualan();
        foreach ($query as $data) :
            $sub = $data['jml'] * $data['harga_barang'];
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $data['kd_barang']; ?></td>
                <td><?= $data['nama_barang']; ?></td>
                <td><?= $data['jml']; ?></td>
                <td><?= $data['harga_barang']; ?></td>
                <th><?= number_format($sub, 0, '', '.'); ?></th>

                <td class="text-center">
                    <button style="padding: 3px 7px;" onclick="hapus(this)" data-id="<?= $data['kd_barang'] ?>" class="btn btn-danger btn-sm" data-popup="tooltip" data-placement="top" title="Hapus Data"><i class="icon-trash"></i></button>
                </td>
            </tr>

        <?php endforeach; ?>
        <tr class="text-right">
            <th colspan="6">BAYAR :</th>
            <td><input style="font-size: 20px" type="text" name="bayar" id="bayar" class="form-control text-right"></td>
        </tr>
        <tr class="text-right">
            <th colspan="6">KEMBALI :</th>
            <td><input readonly style="font-size: 20px" type="text" name="kembali" id="kembali" class="form-control text-right"></td>
        </tr>
        <tr class="text-right">
            <th colspan="6"></th>
            <td><button class="btn btn-primary w-100">SIMPAN <i class="icon-paperplane ml-2"></i></button> </td>
        </tr>
    </tbody>
</table>


<script>
    //edit tampilan
    $('.Edit').click(function() {
        var id = $(this).val();
        $('#modal').modal('show');
        var fileedit = 'menu/admin/master_data/edit/edit_kategori.php';
        $.ajax({
            type: 'POST',
            url: fileedit,
            data: 'ids=' + id,
            success: function(data) {
                $('#modal_tambah').html(data);
            }
        });
    });
</script>



<script>
    function hapus(dt) {
        var id = $(dt).data('id');
        swal.fire({
                title: "Yakin ingin menghapus?",
                text: "Data yang terhapus akan hilang secara permanen!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Iya, Hapus",
                cancelButtonText: "Batal",
                confirmButtonClass: "btn btn-success",
                cancelButtonClass: "btn btn-primary m-l-10",
                buttonsStyling: !1,
            })
            .then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST', // Metode pengiriman data menggunakan POST
                        url: 'menu/admin/master_data/proses/proses_penjualan.php', // File yang akan memproses data
                        data: 'hapus=hapus&id=' + id,
                        dataType: "html",
                        success: function(response) {
                            var json_data = JSON.parse(response);
                            if (json_data.status == 1) {
                                $('#tampil-data').load('menu/admin/master_data/view/v_penjualan.php');
                                $('#tampil-total').load('menu/admin/master_data/view/v_total.php');
                                $('#kd_barang').val("");
                            } else {
                                $('#peringatan').html('<div class="alert alert-danger">' + json_data.pesan + '</div>');

                            }
                            $('.alert').fadeOut(5000);
                            $('.modal-backdrop').fadeOut(1);
                            $('#modal').fadeOut(1);
                            $('#modal').modal('hide');

                        }
                    });
                }
            })
    }
</script>