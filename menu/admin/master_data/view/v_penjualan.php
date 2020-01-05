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
        $query2 = get_total_tmp_penjualan();
        $data2 = $query2->fetch_array();
        $query = list_tmp_penjualan();
        foreach ($query as $data) :
            $sub = $data['jml'] * $data['harga_barang'];
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $data['kd_barang']; ?></td>
                <td><?= $data['nama_barang']; ?></td>
                <td>
                    <form id="updt-jumlah<?php echo $data['id'] ?>">
                        <input type="hidden" name="kd_barang" value="<?php echo $data['kd_barang'] ?>">
                        <input size="4" style="text-align: center" type="" name="jumlah" value="<?php echo $data['jml'] ?>">


                    </form>
                    <script>
                        $('#updt-jumlah<?php echo $data['id'] ?>').submit(function(e) { //nek di klik id form urusan
                            var url = 'menu/admin/master_data/proses/proses_penjualan.php'; //tujuan gantine action
                            e.preventDefault();
                            $.ajax({
                                type: 'POST',
                                url: url,
                                data: 'update_jumlah=update_jumlah&' + $(this).serialize(),
                                success: function(data) {

                                    var json_data = JSON.parse(data);
                                    if (json_data.status == 1) {
                                        window.location = '?menu=penjualan'


                                    } else {
                                        $('#peringatan').html('<div class="alert alert-danger alert-styled-left alert-arrow-left alert-bordered">' + json_data.pesan + '</div>');

                                    }
                                    $('.alert').fadeOut(6000);
                                    $('.modal-backdrop').fadeOut(1);
                                    $('#modal').fadeOut(1);
                                    $('#modal').modal('hide');
                                }
                            });
                        });
                    </script>
                </td>
                <td><?= $data['harga_barang']; ?></td>
                <th><?= number_format($sub, 0, '', '.'); ?></th>

                <td class="text-center">
                    <button style="padding: 3px 7px;" onclick="hapus(this)" data-id="<?= $data['kd_barang'] ?>" class="btn btn-danger btn-sm" data-popup="tooltip" data-placement="top" title="Hapus Data"><i class="icon-trash"></i></button>
                </td>
            </tr>

        <?php endforeach; ?>
        <form id="saved">
            <tr class="text-right">
                <th colspan="6">BAYAR :</th>
                <td>
                    <input type="hidden" value="<?= $data2['total']; ?>" name="total" id="total" class="form-control text-right">
                    <input style="font-size: 20px" type="text" onkeyup="sum3()" name="bayar" id="bayar" class="form-control text-right bypaket">
                </td>
            </tr>
            <tr class="text-right">
                <th colspan="6">KEMBALI :</th>
                <td><input readonly style="font-size: 20px" type="text" name="kembali" id="kembali" class="form-control text-right"></td>
            </tr>
            <tr class="text-right">
                <th colspan="6"></th>
                <td><button class="btn btn-primary w-100">SIMPAN <i class="icon-paperplane ml-2"></i></button> </td>
            </tr>
        </form>
    </tbody>
</table>

<script type="text/javascript">
    function toRp(angka) {
        var rev = parseInt(angka, 10).toString().split('').reverse().join('');
        var rev2 = '';
        for (var i = 0; i < rev.length; i++) {
            rev2 += rev[i];
            if ((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
                rev2 += '.';
            }
        }
        return rev2.split('').reverse().join('');
    }

    $(document).on('change keyup blur', '#bayar', function() {
        $('#bayar').maskMoney({
            prefix: '',
            thousands: '.',
            decimal: ',',
            precision: 0
        });
    });

    function sum3() {
        var byr = 0;
        var ttl = 0;

        if (document.getElementById('bayar').value.toString().split('.').join('')) {
            byr = document.getElementById('bayar').value.toString().split('.').join('');
        } else {
            byr = 0;
        }

        if (document.getElementById('total').value.toString().split('.').join('')) {
            ttl = document.getElementById('total').value.toString().split('.').join('');
        } else {
            ttl = 0;
        }

        var result2 = parseInt(byr) - parseInt(ttl);


        if (!isNaN(result2)) {
            document.getElementById('kembali').value = toRp(result2);

        }
    }
</script>
<script>
    //proses simpan
    $('#saved').submit(function(e) { //nek di klik id form urusan
        var url = 'menu/admin/master_data/proses/proses_penjualan.php'; //tujuan gantine action
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: url,
            data: 'simpan=simpan&' + $(this).serialize(),
            success: function(data) {

                var json_data = JSON.parse(data);
                if (json_data.status == 1) {
                    $('#tampil-data').load('menu/admin/master_data/view/v_penjualan.php');
                    $('#peringatan').html('<div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">' + json_data.pesan + '</div>');

                } else {
                    $('#peringatan').html('<div class="alert alert-danger alert-styled-left alert-arrow-left alert-bordered">' + json_data.pesan + '</div>');

                }
                $('.alert').fadeOut(9000);
                $('.modal-backdrop').fadeOut(1);
                $('#modal').fadeOut(1);
                $('#modal').modal('hide');

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