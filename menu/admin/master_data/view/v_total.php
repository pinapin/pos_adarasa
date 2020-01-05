<?php
require_once('../../../../functions/lib_function.php');
$query = get_total_tmp_penjualan();
$data = $query->fetch_array();
$total = $data['total'];
?>

<div style="margin-bottom: 0" class="card">
    <div style="padding-top: 0px;padding-bottom: 0px" class="card-header header-elements-inline">
        <div style="margin-left: auto">
            <h1 style="font-size: 60px;color: orangered">Rp <?= number_format($total, 0, '', '.'); ?></h1>
        </div>
    </div>
</div>