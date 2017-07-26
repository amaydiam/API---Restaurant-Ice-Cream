<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=data_transaksi_".date('Ymd_His').".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<h1>Data Transaksi <?php echo $title; ?></h1>
<table border='1'>

    <thead>
    <tr>
        <th rowspan="2">Waktu Transaksi</th>
        <th rowspan="2">Kode Transaksi</th>
        <th rowspan="2">Petugas</th>
        <th colspan="4">Detail Transaksi</th>
    </tr>
    <tr>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Kuantitati</th>
        <th>Keterangan</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (is_array($record)) {
        $wt = "";
        $kt = "";
        $iu = "";
        $no = 1;
        foreach ($record as $row) :

           $w= explode(" ",$row['waktu_transaksi']);

            ?>
            <tr> <?php if ($row['waktu_transaksi'] != $wt) {
                    ?>
                     <td valign="top" rowspan="<?php echo $row['jmlh_item'] ?>">
                        <?php echo $w[1];?>
                    </td>
                <?php
                } ?>
                <?php if ($row['kode_transaksi'] != $kt) {
                    ?>
                     <td valign="top" rowspan="<?php echo $row['jmlh_item'] ?>">
                        <?php echo $row['kode_transaksi'] ?>
                    </td>
                <?php
                } ?>
                <?php if ($row['waktu_transaksi'] != $wt ) {
                ?>
                 <td valign="top" rowspan="<?php echo $row['jmlh_item'] ?>">
                    <?php echo $row['nama'] ?>
                </td>
                <?php
                } ?>
                 <td align="left" valign="top" align="ce"><?php echo $row['kode_barang'] ?></td>
                 <td valign="top"><?php echo $row['nama_barang'] ?></td>
                 <td valign="top"><?php echo $row['kuantiti_detail_transaksi'] ?></td>
                 <td valign="top"><?php echo $row['keterangan_detail_transaksi'] ?></td>
            </tr>
            <?php
            $wt = $row['waktu_transaksi'];
            $kt = $row['kode_transaksi'];
            $iu = $row['id_user'];
            $no++; ?>
        <?php
        endforeach;
    } else {
    }
    ?>
    </tbody>
</table>
</html>