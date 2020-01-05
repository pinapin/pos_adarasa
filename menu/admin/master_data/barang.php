<!-- Basic datatable -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Data Barang</h5>
        <div class="header-elements">
            <div class="list-icons">
                <button class="btn btn-primary btn-sm Add"><i class="icon-plus-circle2"></i> Tambah</button>
            </div>
        </div>

    </div>


    <div class="pl-3 pr-3" id="peringatan">

    </div>


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
    $('#tampil-data').load('menu/admin/master_data/view/v_barang.php');
</script>

<script>
    //add
    $('.Add').click(function() {
        var id = $(this).val();
        $('#modal').modal('show');
        var fileedit = 'menu/admin/master_data/add/add_barang.php';
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