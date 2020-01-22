<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
if ($jenis_paper == "pdf") $class = "tabelPopUp";
else $class = "table table-bordered mb30";
function getKeterangan($jml) {
    if ((is_array($jml) && empty($jml)) || strlen($jml) === 0) {
        return "";
    } else {
        if ($jml < 0) {
            return "SELISIH KURANG";
        } elseif ($jml > 0) {
            return "SELISIH LEBIH";
        } elseif ($jml == 0) {
            return "SESUAI";
        }
    }
}
$border = '';
if($jenis_paper == "xls") {
    $border = 'style="border: 1px solid black;"';
}

if (in_array($tipe, array("pemasukan","pengeluaran","pemasukan_bb"))) {
    if (in_array($tipe, array("pemasukan_bb"))) $colspan = 'colspan="3"';
    else $colspan = 'colspan="2"';
?>
    <table class="<?php echo $class; ?>" width="100%" style="font-size: 12px;">
        <thead>
            <?php
            if($jenis_paper == "xls") { ?>
                <tr><th colspan="16"><?php echo $this->session->userdata('NAMA_TRADER'); ?></th></tr>
                <tr><th colspan="16"><?php echo $tittle; ?></th></tr>
                <tr><th colspan="16">Periode <?php echo date_format(date_create($tgl_awal), 'd-m-Y')." s/d ".date_format(date_create($tgl_akhir), 'd-m-Y'); ?></th></tr>
                <tr><th colspan="16">&nbsp;</th></tr>
            <?php } ?>
            <tr align="left">
                <th rowspan="2" align="center" <?php echo $border; ?>>No</th>
                <th rowspan="2" <?php echo $border; ?>>Jns. Dok</th>
                <th <?php echo $colspan." ".$border; ?>>Dokumen Pabean</th>          
                <th colspan="2" <?php echo $border; ?>>Bukti/Dok. <?php echo in_array($tipe, array("pemasukan","pemasukan_bb")) ?  "Penerimaan" : "Pengeluaran" ?></th>
                <?php if (in_array($tipe, array("pemasukan","pengeluaran"))) { ?>
                <th rowspan="2" <?php echo $border; ?>><?php echo $tipe == "pemasukan" ? "Pemasok/Pengirim" : "Pembeli/Penerima" ?></th>
                <?php } ?>
                <th rowspan="2" <?php echo $border; ?>>Kode Barang</th>
                <th rowspan="2" <?php echo $border; ?>>Nama Barang</th>
                <th rowspan="2" <?php echo $border; ?>>Satuan</th>
                <th rowspan="2" <?php echo $border; ?>>Jumlah</th>
                <?php if (in_array($tipe, array("pemasukan_bb"))) { ?>
                <th rowspan="2" <?php echo $border; ?>>Kode<br/>Valuta</th>
                <?php } ?>
                <th rowspan="2" <?php echo $border; ?>>Nilai Barang</th>
                <?php if (in_array($tipe, array("pemasukan_bb"))) { ?>
                <th rowspan="2" <?php echo $border; ?>>Gudang</th>
                <th rowspan="2" <?php echo $border; ?>>Penerima<br/>Subkontrak</th>
                <th rowspan="2" <?php echo $border; ?>>Negara<br/>Asal<br/>Barang</th>
                <?php } ?>
            </tr>
            <tr align="center">
                <th <?php echo $border; ?>>Nomor</th>
                <th <?php echo $border; ?>>Tanggal</th>
                <?php if (in_array($tipe, array("pemasukan_bb"))) { ?>
                <th <?php echo $border; ?>>No. Seri Brg</th>
                <?php } ?>
                <th <?php echo $border; ?>>Nomor</th>
                <th <?php echo $border; ?>>Tanggal</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $banyakData = count($resultData);
        if ($banyakData > 0) {
            echo "<tbody>";
            foreach ($resultData as $listData) {
                ?>
                <tr>
                    <td align="center" <?php echo $border; ?>><?= $no; ?></td>
                    <td <?php echo $border; ?>><?= $listData['jns_dokumen']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['no_daftar']; ?></td>
                    <td <?php echo $border; ?>><?=$listData['tgl_daftar']; ?></td>
                    <?php if (in_array($tipe, array("pemasukan_bb"))) { ?>
                    <td <?php echo $border; ?>><?php echo $listData['seri_barang']; ?></td>
                    <?php } ?>
                    <td <?php echo $border; ?>><?= $listData['no_inout']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['tgl_inout']; ?></td>
                    <?php if (in_array($tipe, array("pemasukan","pengeluaran"))) { ?>
                    <td <?php echo $border; ?>><?= $listData['nm_supplier']; ?></td>
                    <?php } ?>
                    <td <?php echo $border; ?>><?= $listData['kd_brg']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['nm_brg']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['kd_satuan']; ?></td>
                    <td align="right" <?php echo $border; ?>><?= number_format($listData['jml_satuan'], $this->session->userdata('FORMAT_QTY')); ?></td>
                    <?php if (in_array($tipe, array("pemasukan_bb"))) { ?>
                    <td <?php echo $border; ?>><?php echo $listData['kd_valuta']; ?></td>
                    <?php } ?>
                    <td align="right" <?php echo $border; ?>><?= number_format($listData['price'], $this->session->userdata('FORMAT_CURRENCY')); ?></td>
                    <?php if (in_array($tipe, array("pemasukan_bb"))) { ?>
                    <td <?php echo $border; ?>><?php echo $listData['nama_gudang']; ?></th>
                    <td <?php echo $border; ?>>-</th>
                    <td <?php echo $border; ?>><?php echo $listData['negara_asal']; ?></th>
                    <?php } ?>
                </tr>
                <?php $no++;
            }
        } else { ?>
            <tr>
                <td colspan="16" align="center" <?php echo $border; ?>>Nihil</td>
            </tr>
        <?php }  echo $PAGING_BOT; ?>
        </tbody>
    </table>
<?php } elseif($tipe == "pemakaian_bb") { ?>
    <table class="<?php echo $class; ?>" width="100%" style="font-size: 12px;">
        <thead>
            <?php
            if($jenis_paper == "xls") { ?>
                <tr><th colspan="9"><?php echo $this->session->userdata('NAMA_TRADER'); ?></th></tr>
                <tr><th colspan="9"><?php echo $tittle; ?></th></tr>
                <tr><th colspan="9">Periode <?php echo date_format(date_create($tgl_awal), 'd-m-Y')." s/d ".date_format(date_create($tgl_akhir), 'd-m-Y'); ?></th></tr>
                <tr><th colspan="9">&nbsp;</th></tr>
            <?php } ?>
            <tr align="left">
                <th rowspan="2" align="center" <?php echo $border; ?>>No</th>
                <th colspan="2" <?php echo $border; ?>>Bukti Pengeluaran</th>
                <th rowspan="2" <?php echo $border; ?>>Kode Barang</th>
                <th rowspan="2" <?php echo $border; ?>>Nama Barang</th>
                <th rowspan="2" <?php echo $border; ?>>Satuan</th>
                <th colspan="2" <?php echo $border; ?>>Jumlah</th>
                <th rowspan="2" <?php echo $border; ?>>Penerima Subkontrak</th>
            </tr>
            <tr align="center">
                <th <?php echo $border; ?>>Nomor</th>
                <th <?php echo $border; ?>>Tanggal</th>
                <th <?php echo $border; ?>>Digunakan</th>
                <th <?php echo $border; ?>>Disubkontrakan</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $banyakData = count($resultData);
        if ($banyakData > 0) {
            echo "<tbody>";
            foreach ($resultData as $listData) {
                ?>
                <tr>
                    <td align="center" <?php echo $border; ?>><?= $no; ?></td>
                    <td <?php echo $border; ?>><?= $listData['no_inout']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['tgl_inout']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['kd_brg']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['nm_brg']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['kd_satuan']; ?></td>
                    <td align="right" <?php echo $border; ?>><?php echo ($listData['jns_dokumen'] != "SUBKONTRAK") ? number_format($listData['jml_satuan'], $this->session->userdata('FORMAT_QTY')) : "-"; ?></td>
                    <td <?php echo $border; ?>><?php echo ($listData['jns_dokumen'] == "SUBKONTRAK") ? number_format($listData['jml_satuan'], $this->session->userdata('FORMAT_QTY')) : "-"; ?></td>
                    <td <?php echo $border; ?>><?php echo ($listData['jns_dokumen'] == "SUBKONTRAK") ? $listData['partner'] : "-"; ?></td>
                </tr>
                <?php $no++;
            }
        } else { ?>
            <tr>
                <td colspan="9" align="center" <?php echo $border; ?>>Nihil</td>
            </tr>
        <?php }  echo $PAGING_BOT; ?>
        </tbody>
    </table>
<?php } elseif ($tipe == "pemakaian_subkon") { ?>
    <table class="<?php echo $class; ?>" width="100%" style="font-size: 12px;">
        <thead>
            <?php
            if($jenis_paper == "xls") { ?>
                <tr><th colspan="9"><?php echo $this->session->userdata('NAMA_TRADER'); ?></th></tr>
                <tr><th colspan="9"><?php echo $tittle; ?></th></tr>
                <tr><th colspan="9">Periode <?php echo date_format(date_create($tgl_awal), 'd-m-Y')." s/d ".date_format(date_create($tgl_akhir), 'd-m-Y'); ?></th></tr>
                <tr><th colspan="9">&nbsp;</th></tr>
            <?php } ?>
            <tr align="left">
                <th width="5%" rowspan="2" align="center" <?php echo $border; ?>>No</th>
                <th width="25%" colspan="2" <?php echo $border; ?>>Bukti Pengeluaran Barang</th>
                <th width="15%" rowspan="2" <?php echo $border; ?>>Kode Barang</th>
                <th width="15%" rowspan="2" <?php echo $border; ?>>Nama Barang</th>
                <th width="10%" rowspan="2" <?php echo $border; ?>>Satuan</th>
                <th width="15%" rowspan="2" <?php echo $border; ?>>Disubkontrakan</th>
                <th width="15%" rowspan="2" <?php echo $border; ?>>Penerima Subkontrak</th>
            </tr>
            <tr align="center">
                <th width="15%" <?php echo $border; ?>>Nomor</th>
                <th width="10%" <?php echo $border; ?>>Tanggal</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $banyakData = count($resultData);
        if ($banyakData > 0) {
            echo "<tbody>";
            foreach ($resultData as $listData) {
                ?>
                <tr>
                    <td align="center" <?php echo $border; ?>><?php echo $no; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['no_inout']; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['tgl_inout']; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['kd_brg']; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['nm_brg']; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['kd_satuan']; ?></td>
                    <td style="text-align: right;" <?php echo $border; ?>><?php echo number_format($listData['jml_satuan'], $this->session->userdata('FORMAT_QTY')); ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['partner']; ?></td>
                </tr>
                <?php $no++;
            }
        } else { ?>
            <tr>
                <td colspan="9" align="center" <?php echo $border; ?>>Nihil</td>
            </tr>
        <?php }  echo $PAGING_BOT; ?>
        </tbody>
    </table>
<?php } elseif ($tipe == "pemasukan_hp") { ?>
    <table class="<?php echo $class; ?>" width="100%" style="font-size: 12px;">
        <thead>
            <?php
            if($jenis_paper == "xls") { ?>
                <tr><th colspan="9"><?php echo $this->session->userdata('NAMA_TRADER'); ?></th></tr>
                <tr><th colspan="9"><?php echo $tittle; ?></th></tr>
                <tr><th colspan="9">Periode <?php echo date_format(date_create($tgl_awal), 'd-m-Y')." s/d ".date_format(date_create($tgl_akhir), 'd-m-Y'); ?></th></tr>
                <tr><th colspan="9">&nbsp;</th></tr>
            <?php } ?>
            <tr align="left">
                <th width="3%" rowspan="2" align="center" width="1%" <?php echo $border; ?>>No</th>
                <th width="25%" colspan="2" <?php echo $border; ?>>Bukti Penerimaan</th>
                <th width="14%" rowspan="2" <?php echo $border; ?>>Kode Barang</th>
                <th width="15%" rowspan="2" <?php echo $border; ?>>Nama Barang</th>
                <th width="8%" rowspan="2" <?php echo $border; ?>>Satuan</th>
                <th width="25%" colspan="2" <?php echo $border; ?>>Jumlah</th>
                <th width="10%" rowspan="2" <?php echo $border; ?>>Gudang</th>
            </tr>
            <tr align="center">
                <th width="12%" <?php echo $border; ?>>Nomor</th>
                <th width="13%" <?php echo $border; ?>>Tanggal</th>
                <th width="10%" <?php echo $border; ?>>Dari Produksi</th>
                <th width="15%" <?php echo $border; ?>>Dari Subkontrak</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $banyakData = count($resultData);
        if ($banyakData > 0) {
            echo "<tbody>";
            foreach ($resultData as $listData) {
                ?>
                <tr>
                    <td align="center" <?php echo $border; ?>><?= $no; ?></td>
                    <td <?php echo $border; ?><?= $listData['no_inout']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['tgl_inout']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['kd_brg']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['nm_brg']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['kd_satuan']; ?></td>
                    <td align="right" <?php echo $border; ?>><?php echo ($listData['jns_dokumen'] != "SUBKONTRAK") ? number_format($listData['jml_satuan'], $this->session->userdata('FORMAT_QTY')) : "-"; ?></td>
                    <td <?php echo $border; ?>><?php echo ($listData['jns_dokumen'] == "SUBKONTRAK") ? number_format($listData['jml_satuan'], $this->session->userdata('FORMAT_QTY')) : "-"; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['nama_gudang']; ?></td>
                </tr>
                <?php $no++;
            }
        } else { ?>
            <tr>
                <td colspan="9" align="center" <?php echo $border; ?>>Nihil</td>
            </tr>
        <?php }  echo $PAGING_BOT; ?>
        </tbody>
    </table>
<?php } elseif ($tipe == "pengeluaran_hp") { ?>
    <table class="<?php echo $class; ?>" width="100%" style="font-size: 12px;">
        <thead>
            <?php
            if($jenis_paper == "xls") { ?>
                <tr><th colspan="13"><?php echo $this->session->userdata('NAMA_TRADER'); ?></th></tr>
                <tr><th colspan="13"><?php echo $tittle; ?></th></tr>
                <tr><th colspan="13">Periode <?php echo date_format(date_create($tgl_awal), 'd-m-Y')." s/d ".date_format(date_create($tgl_akhir), 'd-m-Y'); ?></th></tr>
                <tr><th colspan="13">&nbsp;</th></tr>
            <?php } ?>
            <tr align="left">
                <th rowspan="2" align="center" <?php echo $border; ?>>No</th>
                <th colspan="2" <?php echo $border; ?>>PEB</th>          
                <th colspan="2" <?php echo $border; ?>>Bukti Pengeluaran Barang</th>
                <th rowspan="2" <?php echo $border; ?>>Pembeli / Penerima</th>
                <th rowspan="2" <?php echo $border; ?>>Negara Tujuan</th>
                <th rowspan="2" <?php echo $border; ?>>Kode Barang</th>
                <th rowspan="2" <?php echo $border; ?>>Nama Barang</th>
                <th rowspan="2" <?php echo $border; ?>>Satuan</th>
                <th rowspan="2" <?php echo $border; ?>>Jumlah</th>
                <th rowspan="2" <?php echo $border; ?>>Mata Uang</th>
                <th rowspan="2" <?php echo $border; ?>>Nilai Barang</th>
            </tr>
            <tr align="center">
                <th <?php echo $border; ?>>Nomor</th>
                <th <?php echo $border; ?>>Tanggal</th>
                <th <?php echo $border; ?>>Nomor</th>
                <th <?php echo $border; ?>>Tanggal</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $banyakData = count($resultData);
        if ($banyakData > 0) {
            echo "<tbody>";
            foreach ($resultData as $listData) {
                ?>
                <tr>
                    <td align="center" <?php echo $border; ?>><?= $no; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['no_daftar']; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['tgl_daftar']; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['no_inout']; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['tgl_inout']; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['nm_supplier']; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['negara_asal']; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['kd_brg']; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['nm_brg']; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['kd_satuan']; ?></td>
                    <td align="right" <?php echo $border; ?>><?php echo number_format($listData['jml_satuan'], $this->session->userdata('FORMAT_QTY')); ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['kd_valuta']; ?></td>
                    <td align="right" <?php echo $border; ?>><?php echo number_format($listData['price'], $this->session->userdata('FORMAT_CURRENCY')); ?></td>
                </tr>
                <?php $no++;
            }
        } else { ?>
            <tr>
                <td colspan="13" align="center" <?php echo $border; ?>>Nihil</td>
            </tr>
        <?php } echo $PAGING_BOT; ?>
        </tbody>
    </table>
<?php 
    } elseif ($tipe == "mutasi") { 
?>
    <table class="<?php echo $class; ?>" width="100%" style="font-size: 12px;">
        <thead>
            <?php
            if($jenis_paper == "xls") { ?>
                <tr><th colspan="12"><?php echo $this->session->userdata('NAMA_TRADER'); ?></th></tr>
                <tr><th colspan="12"><?php echo $tittle; ?></th></tr>
                <tr><th colspan="12">Periode <?php echo date_format(date_create($tgl_awal), 'd-m-Y')." s/d ".date_format(date_create($tgl_akhir), 'd-m-Y'); ?></th></tr>
                <tr><th colspan="12">&nbsp;</th></tr>
            <?php } ?>
            <tr>
                <th width="3%" <?php echo $border; ?>>No</th>
                <th width="10%" <?php echo $border; ?>>Kode&nbsp;Barang</th>
                <th width="10%" <?php echo $border; ?>>Nama&nbsp;Barang</th>
                <th width="5%" <?php echo $border; ?>>Satuan</th>
                <th width="10%" <?php echo $border; ?>>Saldo&nbsp;Awal<br><?php echo $tgl_awal; ?></th>
                <th width="8%" <?php echo $border; ?>>Pemasukan</th>
                <th width="8%" <?php echo $border; ?>>Pengeluaran</th>
                <th width="10%" <?php echo $border; ?>>Penyesuaian (Adjusment)</th>
                <th width="9%" <?php echo $border; ?>>Saldo&nbsp;Akhir<br><?php echo $tgl_akhir; ?></th>
                <th width="10%" <?php echo $border; ?>>Stock&nbsp;Opname<br><?php echo ($stockopname == $tgl_akhir) ? $stockopname : "-"; ?></th>
                <th width="7%" <?php echo $border; ?>>Selisih</th>
                <th width="10%" <?php echo $border; ?>>Keterangan</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        if (count($resultData) > 0) { 
            $no = 1; $saldoAwal = 0; $pemasukan = 0; $getSaldoAwalStock = 0; $tglStockopname = "";
            $pengeluaran = 0;
            foreach ($resultData as $listData) {
                #QUERY GET SUM PEMASUKAN
                $sqlGetMasuk ="SELECT SUM(jml_satuan) AS pemasukan
                                FROM laporan_mutasi
                                WHERE id_barang = ".$this->db->escape($listData['id_barang'])."
                                AND DATE_FORMAT(tgl_realisasi,'%Y-%m-%d') BETWEEN ".$this->db->escape($tgl_awal)." AND ".$this->db->escape($tgl_akhir)."
                                AND tipe IN ('GATE-IN','PROCESS_OUT','SCRAP')
                                GROUP BY id_barang";
                           
                $resPemasukan = $this->db->query($sqlGetMasuk);
                if ($resPemasukan->num_rows() > 0) {
                    $dataPemasukan = $resPemasukan->row();
                    $pemasukan = $dataPemasukan->pemasukan;
                }

                $tglAwalInOut = date('Y-m-d', strtotime($stockopname . "+1 day"));
                $tglAkhirInOut = date('Y-m-d', strtotime($tgl_awal . "-1 day"));
                $sqlGetSaldoStock = "SELECT jml_stockopname, DATE_FORMAT(tgl_stock, '%Y-%m-%d') as tgl_stockopname
                                FROM tm_stockopname
                                WHERE id_barang = ".$this->db->escape($listData['id_barang'])."
                                AND DATE_FORMAT(tgl_stock, '%Y-%m-%d') <= ".$this->db->escape($tgl_awal)."
                                ORDER BY DATE_FORMAT(tgl_stock, '%Y-%m-%d') DESC LIMIT 1";

                $resStockopname = $this->db->query($sqlGetSaldoStock);
                if ($resStockopname->num_rows() > 0) {
                    $resStockopname->row();
                    $getSaldoAwalStock = $resStockopname->jml_stockopname;
                    $tglStockopname = " BETWEEN '" . date('Y-m-d', strtotime($resStockopname->tgl_stockopname.'+1 day')) . "' AND '" . $tglAkhirInOut . "'";
                } else {
                    $tglStockopname = " <= '" . $tglAkhirInOut . "'";
                }

                $sqlGetSaldoIn = "SELECT SUM(jml_satuan) AS saldo_awal_pemasukan, STR_TO_DATE(MAX(tgl_realisasi),'%Y-%m-%d') tgl_pemasukan
                                  FROM laporan_mutasi 
                                  WHERE id_barang = ".$this->db->escape($listData['id_barang'])." 
                                  AND DATE_FORMAT(tgl_realisasi,'%Y-%m-%d') ".$tglStockopname." 
                                  AND tipe IN ('GATE-IN','PROCESS_OUT','SCRAP','MOVE-IN') 
                                  GROUP BY id_barang";

                $sqlGetSaldoOut = "SELECT SUM(jml_satuan) AS saldo_awal_pengeluaran, STR_TO_DATE(MAX(tgl_realisasi),'%Y-%m-%d') tgl_pengeluaran 
                                   FROM laporan_mutasi 
                                   WHERE id_barang = ".$this->db->escape($listData['id_barang'])." 
                                   AND DATE_FORMAT(tgl_realisasi,'%Y-%m-%d') ".$tglStockopname." 
                                   AND tipe IN ('GATE-OUT','PROCESS_IN','MOVE-OUT','MUSNAH','RUSAK') 
                                   GROUP BY id_barang";

                $rsGetSaldoAwalIn = $this->db->query($sqlGetSaldoIn);
                if ($rsGetSaldoAwalIn->num_rows() > 0) {
                    $dataSaldoAwalin = $rsGetSaldoAwalIn->row();
                    $saldoAwalIn = $dataSaldoAwalin->saldo_awal_pemasukan;
                } else {
                    $saldoAwalIn = 0;
                }

                $rsGetSaldoAwalOut = $this->db->query($sqlGetSaldoOut);
                if ($rsGetSaldoAwalOut->num_rows() > 0) {
                    $dataSaldoAwalOut = $rsGetSaldoAwalOut->row();
                    $saldoAwalOut = $dataSaldoAwalOut->saldo_awal_pengeluaran;
                } else {
                    $saldoAwalOut = 0;
                }

                if ($getSaldoAwalStock == "") {
                    $getSaldoAwal = $getSaldoAwalStock + $saldoAwalIn - $saldoAwalOut + 0;
                } else {
                    if ($resStockopname->tgl_stockopname == $tglAkhirInOut) { 
                        $getSaldoAwal = $getSaldoAwalStock;
                    } else {
                        if ($resStockopname->tgl_stockopname == $rsGetSaldoAwalIn->tgl_pemasukan || $resStockopname->tgl_stockopname == $rsGetSaldoAwalOut->tgl_pengeluaran) { 
                            $getSaldoAwal = $getSaldoAwalStock;
                        } else { 
                            $getSaldoAwal = $getSaldoAwalStock + $saldoAwalIn - $saldoAwalOut + 0;
                        }
                    }
                }
                $saldoAwal = $getSaldoAwal;

                #KOLOM PENGELUARAN    
                $sqlGetKeluar = "SELECT SUM(jml_satuan) AS pengeluaran
                                FROM laporan_mutasi
                                WHERE id_barang = ".$this->db->escape($listData['id_barang'])." 
                                AND DATE_FORMAT(tgl_realisasi,'%Y-%m-%d') BETWEEN ".$this->db->escape($tgl_awal)." AND ".$this->db->escape($tgl_akhir)."
                                AND tipe IN ('GATE-OUT','MUSNAH','RUSAK','PROCESS_IN','MOVE-OUT','MUSNAH','RUSAK') 
                                GROUP BY id_barang";
                
                $resPengeluaran = $this->db->query($sqlGetKeluar);
                if ($resPengeluaran->num_rows() > 0) {
                    $dataResPengeluaran = $resPengeluaran->row();
                    $pengeluaran = $dataResPengeluaran->pengeluaran;
                } else {
                    $pengeluaran = 0;
                }

                #KOLOM PENYESUAIAN
                $penyesuaian = 0;
                    
                #KOLOM SALDO AKHIR
                $saldoAkhir = $saldoAwal + $pemasukan - $pengeluaran + $penyesuaian;

                #KOLOM STOCKOPNAME
                $sqlGetStock = "SELECT jml_stockopname
                            FROM tm_stockopname
                            WHERE id_barang = ".$this->db->escape($listData['id_barang'])." 
                            AND DATE_FORMAT(tgl_stock,'%Y-%m-%d') = ".$this->db->escape($stockopname);
                $stock = $this->db->query($sqlGetStock);
                if ($stock->num_rows() > 0) {
                    $stock = $stock->row();
                    $stock = number_format($stock->jml_stockopname,2);
                } else {
                    $stock = 0;
                }

                #KOLOM SELISIH
                if ((is_array($stock) && empty($stock)) || strlen($stock) === 0) {
                    $selisih = "-";
                } else {
                    if ($stock > 0) {
                        $selisih = $stock - $saldoAkhir;
                        $selisih = number_format($selisih, 2);
                    } else {
                        $selisih = 0;
                    }
                }
        ?>
        <tr>
            <td align="center" <?php echo $border; ?>><?= $no; ?></td>
            <td <?php echo $border; ?>><?php echo $listData['kd_brg']; ?></td>
            <td <?php echo $border; ?>><?php echo $listData['nm_brg']; ?></td>
            <td <?php echo $border; ?>><?php echo $listData['kd_satuan_terkecil']; ?></td>
            <td align="right" <?php echo $border; ?>><?php echo number_format($saldoAwal, $this->session->userdata('FORMAT_QTY')); ?></td>
            <td align="right" <?php echo $border; ?>><?php echo number_format($pemasukan, $this->session->userdata('FORMAT_QTY')); ?></td>
            <td align="right" <?php echo $border; ?>><?php echo number_format($pengeluaran, $this->session->userdata('FORMAT_QTY')); ?></td>
            <td align="right" <?php echo $border; ?>><?php echo number_format($penyesuaian, $this->session->userdata('FORMAT_QTY')); ?></td>
            <td align="right" <?php echo $border; ?>><?php echo number_format($saldoAkhir, $this->session->userdata('FORMAT_QTY')); ?></td>
            <td align="right" <?php echo $border; ?>><?php echo number_format($stock, $this->session->userdata('FORMAT_QTY')); ?></td>
            <td align="right" <?php echo $border; ?>><?php echo number_format($selisih, $this->session->userdata('FORMAT_QTY')); ?></td>
            <td align="right" <?php echo $border; ?>><?php echo getKeterangan($selisih); ?></td>
        </tr>
        <?php
                $no++;
            }
        }  else { ?>
        <tr>
            <td colspan="12" align="center" <?php echo $border; ?>>Nihil</td>
        </tr>
        <?php } echo $PAGING_BOT; ?>
        </tbody>
    </table>
<?php } elseif ($tipe == "penyelesaian_waste") { ?>
    <table class="<?php echo $class; ?>" width="100%" style="font-size: 12px;">
        <thead>
            <?php
            if($jenis_paper == "xls") { ?>
                <tr><th colspan="13"><?php echo $this->session->userdata('NAMA_TRADER'); ?></th></tr>
                <tr><th colspan="13"><?php echo $tittle; ?></th></tr>
                <tr><th colspan="13">Periode <?php echo date_format(date_create($tgl_awal), 'd-m-Y')." s/d ".date_format(date_create($tgl_akhir), 'd-m-Y'); ?></th></tr>
                <tr><th colspan="13">&nbsp;</th></tr>
            <?php } ?>
            <tr align="left">
                <th rowspan="2" align="center" <?php echo $border; ?>>No</th>
                <th colspan="2" <?php echo $border; ?>>BC 2.4</th>  
                <th rowspan="2" <?php echo $border; ?>>Kode Barang</th>
                <th rowspan="2" <?php echo $border; ?>>Nama Barang</th>
                <th rowspan="2" <?php echo $border; ?>>Satuan</th>
                <th rowspan="2" <?php echo $border; ?>>Jumlah</th>
                <th rowspan="2" <?php echo $border; ?>>Nilai</th>
            </tr>
            <tr align="center">
                <th <?php echo $border; ?>>Nomor</th>
                <th <?php echo $border; ?>>Tanggal</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $banyakData = count($resultData);
        if ($banyakData > 0) {
            echo "<tbody>";
            foreach ($resultData as $listData) {
                ?>
                <tr>
                    <td align="center" <?php echo $border; ?>><?= $no; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['no_daftar']; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['tgl_daftar']; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['kd_brg']; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['nm_brg']; ?></td>
                    <td <?php echo $border; ?>><?php echo $listData['kd_satuan']; ?></td>
                    <td align="right" <?php echo $border; ?>><?php echo number_format($listData['jml_satuan'], $this->session->userdata('FORMAT_QTY')); ?></td>
                    <td align="right" <?php echo $border; ?>><?php echo number_format($listData['price'], $this->session->userdata('FORMAT_CURRENCY')); ?></td>
                </tr>
                <?php $no++;
            }
        } else { ?>
            <tr>
                <td colspan="8" align="center" <?php echo $border; ?>>Nihil</td>
            </tr>
        <?php } echo $PAGING_BOT; ?>
        </tbody>
    </table>
<?php } ?>