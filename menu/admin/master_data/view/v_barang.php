<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>


<table class="table datatable-basic table-hover">
    <thead>
        <tr style="text-transform: uppercase">
            <th width="15%">KODE BARANG</th>
            <th>NAMA</th>
            <th>KATEGORI</th>
            <th>Harga</th>

            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "../../../../functions/lib_function.php";
        $no = 1;
        $query = list_barang();
        foreach ($query as $data) :
            ?>
            <tr>
                <td><?= $data['kd_barang'] ?></td>
                <td><?= $data['nama_barang']; ?></td>
                <td><?= $data['kategori']; ?></td>
                <td><?= number_format($data['harga_barang'], 0, '', '.'); ?></td>

                <td class="text-center">
                    <button style="padding: 3px 7px;" value="<?= $data['id']; ?>" class="btn btn-success btn-edit Edit" data-popup="tooltip" data-placement="top" title="Edit Data"><i class="icon-pencil"></i></button>
                    <button style="padding: 3px 7px; onclick=" hapus(this)" data-id="<?= $data['id'] ?>" class="btn btn-danger" data-popup="tooltip" data-placement="top" title="Hapus Data"><i class="icon-trash"></i></button>
                </td>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>


<script>
    //edit tampilan
    $('.Edit').click(function() {
        var id = $(this).val();
        $('#modal').modal('show');
        var fileedit = 'menu/admin/master_data/edit/edit_barang.php';
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
                        url: 'menu/admin/master_data/proses/proses_barang.php', // File yang akan memproses data
                        data: 'hapus=hapus&id=' + id,
                        dataType: "html",
                        success: function(response) {
                            var json_data = JSON.parse(response);
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
                }
            })
    }
</script>

<script>
    $(function() {

        // Setting datatable defaults
        $.extend($.fn.dataTable.defaults, {
            autoWidth: false,

            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span>Cari:</span> _INPUT_',
                searchPlaceholder: 'Ketik untuk mencari...',
                lengthMenu: '<span>Tampilkan:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            }
        });

        // Basic datatable
        $('.datatable-basic').DataTable();

    });
</script>