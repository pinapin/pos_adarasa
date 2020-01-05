<!-- Basic datatable -->
<div id="tampil-total"></div>
<div class="card">


    <div class="pl-3 pr-3 pt-3" id="peringatan"></div>
    <form id="input">
        <div class="col-lg-4 p-2">
            <div class="form-group row mb-0">
                <label class="col-form-label col-lg-4">Kode Barang</label>
                <div class="col-lg-8">
                    <input placeholder="Masukkan atau scan disini" required name="kd_barang" id="kd_barang" type="text" class="form-control">
                </div>
            </div>
        </div>
        <button style="display: none">tambah</button>
    </form>
    <div id="tampil-data"></div>


</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <div id="modal_tambah" class="modal-content">
            ...
        </div>
    </div>
</div>

<script>
    //load data
    $('#tampil-data').load('menu/admin/master_data/view/v_penjualan.php');
    $('#tampil-total').load('menu/admin/master_data/view/v_total.php');
</script>

<script>
    //proses simpan
    $('#input').submit(function(e) { //nek di klik id form urusan
        var url = 'menu/admin/master_data/proses/proses_penjualan.php'; //tujuan gantine action
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: url,
            data: 'tambah=tambah&' + $(this).serialize(),
            success: function(data) {

                var json_data = JSON.parse(data);
                if (json_data.status == 1) {
                    $('#tampil-data').load('menu/admin/master_data/view/v_penjualan.php');
                    $('#tampil-total').load('menu/admin/master_data/view/v_total.php');
                    $('#kd_barang').val("");

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