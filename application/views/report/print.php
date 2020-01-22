<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);

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
if($jns_file == "xls") {
    $border = 'style="border: 1px solid black;"';
}
if (in_array($tipe, array("mutasi_bb", "mutasi_hp", "mutasi_bs", "mutasi_pk","mutasi_bp","mutasi_bm","mutasi_sp","mutasi_wip"))) { ?>
    <table class="tabelPopUp" width="100%" style="font-size: 12px;">
        <thead>
            <?php
            if($jns_file == "xls") { ?>
                <tr><td colspan="12">Kawasan Berikat PT Mutiara Laut Abadi</td></tr>
                <tr><td colspan="12">Laporan <?php echo $judul; ?></td></tr>
                <tr><td colspan="12">Periode <?php echo date_format(date_create($tgl_awal), 'd-m-Y')." s/d ".date_format(date_create($tgl_akhir), 'd-m-Y'); ?></td></tr>
                <tr><td colspan="12">&nbsp;</td></tr>
            <?php } ?>
            <tr>
                <th rowspan="2" align="center" width="3%" <?php echo $border; ?>>No</th>
                <th rowspan="2" width="7%" <?php echo $border; ?>>Kode&nbsp;Barang</th>
                <th rowspan="2" width="22%" <?php echo $border; ?>>Nama&nbsp;Barang</th>
                <th rowspan="2" width="4%" <?php echo $border; ?>>Satuan</th>
                <th width="8%" <?php echo $border; ?>>Saldo&nbsp;Awal</th>
                <th rowspan="2" width="8%" <?php echo $border; ?>>Pemasukan</th>
                <th rowspan="2" width="8%" <?php echo $border; ?>>Pengeluaran</th>
                <th rowspan="2" width="8%" <?php echo $border; ?>>Penyesuaian</th>
                <th width="8%" <?php echo $border; ?>>Saldo&nbsp;Akhir</th>
                <th width="8%" <?php echo $border; ?>>Stock&nbsp;Opname</th>
                <th rowspan="2" width="8%" <?php echo $border; ?>>Selisih</th>
                <th rowspan="2" width="9%" <?php echo $border; ?>>Keterangan</th>
            </tr>
            <tr>
                <th <?php echo $border; ?>><?php echo date_format(date_create($tgl_awal), 'd-m-Y'); ?></th>
                <th <?php echo $border; ?>><?php echo date_format(date_create($tgl_akhir), 'd-m-Y'); ?></th>
                <th style="text-align: center;" <?php echo $border; ?>><?php echo $tgl_stock ? date_format(date_create($tgl_stock), 'd-m-Y') : "-"; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $banyakData = count($resultData);
            if ($banyakData > 0) {
                $SaldoAwl = 0;
                foreach ($resultData as $listData) {
                    #KOLOM PEMASUKAN
                    $sqlGetMasuk = "SELECT REPLACE(FORMAT(SUM(jml_satuan),2),',','') AS PEMASUKAN
    					   FROM tr_inout
    					   WHERE STR_TO_DATE(tgl_realisasi,'%Y-%m-%d') BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' 
    					   AND kd_barang ='".$listData['kd_barang']."' 
    					   AND jns_barang ='".$listData['jns_barang']."'
    					   AND TIPE IN ('GATE-IN','PROCESS_OUT','SCRAP','MOVE-IN')";
                    $sqlGetMasuk .= " GROUP BY kd_barang, jns_barang";

                    $MASUK = $this->db->query($sqlGetMasuk)->row();
                    $MASUK = $MASUK->PEMASUKAN;

                    #KOLOM SALDO AWAL
                    $tglAwalInOut = date('Y-m-d', strtotime($tgl_stock . "+1 day"));
                    $tglAkhirInOut = date('Y-m-d', strtotime($tgl_awal . "-1 day"));
                    $sqlGetSaldoStock = "SELECT jml_stockopname AS 'JUMLAH_STOCK', DATE_FORMAT(tgl_stock, '%Y-%m-%d') AS TANGGAL_STOCK
    								FROM tm_stockopname
    								WHERE DATE_FORMAT(tgl_stock, '%Y-%m-%d') <= '".$tgl_awal."'
    								AND kd_brg ='".$listData['kd_barang']."' 
    								AND jns_brg ='".$listData['jns_barang']."'";
                    $sqlGetSaldoStock .= " ORDER BY tgl_stock DESC LIMIT 1";

                    $RSSTOCKOPNAME = $this->db->query($sqlGetSaldoStock)->row();
                    $GETSALDOAWALSTOCK = $RSSTOCKOPNAME->JUMLAH_STOCK;

                    $TGSTK = "";
                    if ($RSSTOCKOPNAME->TANGGAL_STOCK != "") {
                        $TGSTK = " BETWEEN '" . date('Y-m-d', strtotime($RSSTOCKOPNAME->TANGGAL_STOCK.'+1 day')) . "' AND '" . $tglAkhirInOut . "'";
                    } else {
                        $TGSTK = " <= '" . $tglAkhirInOut . "'";
                    }

                    $sqlGetSaldoIn = "SELECT SUM(jml_satuan) AS 'AWAL_SALDO_IN', STR_TO_DATE(MAX(tgl_realisasi),'%Y-%m-%d') 'TGL_IN'
    							  FROM tr_inout
    							  WHERE STR_TO_DATE(tgl_realisasi,'%Y-%m-%d') ".$TGSTK."
    							  AND kd_barang = '".$listData['kd_barang']."' 
                                  AND jns_barang = '".$listData['jns_barang']."'
    							  AND tipe IN ('GATE-IN','PROCESS_OUT','SCRAP','MOVE-IN')";
                    $sqlGetSaldoIn .= " GROUP BY kd_barang, jns_barang";

                    $sqlGetSaldoOut = "SELECT SUM(jml_satuan) AS 'AWAL_SALDO_OUT', STR_TO_DATE(MAX(tgl_realisasi),'%Y-%m-%d') 'TGL_OUT'
    							  FROM tr_inout
    							  WHERE STR_TO_DATE(tgl_realisasi,'%Y-%m-%d') ".$TGSTK."
    							  AND kd_barang = '".$listData['kd_barang']."' 
                                  AND jns_barang = '".$listData['jns_barang']."'
    							  AND tipe IN ('GATE-OUT','PROCESS_IN','MOVE-OUT','MUSNAH','RUSAK')";
                    $sqlGetSaldoOut .= " GROUP BY kd_barang, jns_barang";

                    $sqlGetPenyesuaian = "SELECT SUM(JML_ADJUSTMENT) AS 'JUMLAH_ADJUSTMENT' 
                                          FROM tm_adjustment 
                                          WHERE STR_TO_DATE(tgl_adjustment,'%Y-%m-%d') ".$TGSTK." 
                                          AND kd_brg = '".$listData['kd_barang']."' 
                                          AND jns_brg = '".$listData['jns_barang']."'";
                    $sqlGetPenyesuaian .= " ORDER BY tgl_adjustment DESC LIMIT 1";

                    $RSGETSALDOAWALIN = $this->db->query($sqlGetSaldoIn)->row();
                    $GETSALDOAWALIN = $RSGETSALDOAWALIN->AWAL_SALDO_IN;

                    $RSGETSALDOAWALOUT = $this->db->query($sqlGetSaldoOut)->row();
                    $GETSALDOAWALOUT = $RSGETSALDOAWALOUT->AWAL_SALDO_OUT;

                    $RSGETADJUSTMENT = $this->db->query($sqlGetPenyesuaian)->row();
                    $GETADJUSTMENT = $RSGETADJUSTMENT->JUMLAH_ADJUSTMENT;

                    if ($GETSALDOAWALSTOCK == "") {
                        $SALDOAWLGET = $GETSALDOAWALSTOCK + $GETSALDOAWALIN - $GETSALDOAWALOUT + $GETADJUSTMENT;
                    } else {
                        if ($RSSTOCKOPNAME->TANGGAL_STOCK == $tglAkhirInOut) { 
                            $SALDOAWLGET = $GETSALDOAWALSTOCK;
                        } else {
                            if ($RSSTOCKOPNAME->TANGGAL_STOCK == $RSGETSALDOAWALIN->TGL_IN || $RSSTOCKOPNAME->TANGGAL_STOCK == $RSGETSALDOAWALOUT->TGL_OUT) { 
                                $SALDOAWLGET = $GETSALDOAWALSTOCK;
                            } else { 
                                $SALDOAWLGET = $GETSALDOAWALSTOCK + $GETSALDOAWALIN - $GETSALDOAWALOUT + $GETADJUSTMENT;
                            }
                        }
                    }
                    $SALDOAWL = $SALDOAWLGET;

                    #KOLOM PENGELUARAN		  
                    $sqlGetKeluar = "SELECT REPLACE(FORMAT(SUM(jml_satuan),2),',','') AS PENGELUARAN
    					FROM tr_inout
    					WHERE STR_TO_DATE(tgl_realisasi,'%Y-%m-%d') BETWEEN '" . $tgl_awal . "' AND '" . $tgl_akhir . "'
    					AND kd_barang = '".$listData['kd_barang']."' 
                        AND jns_barang = '".$listData['jns_barang']."'
    					AND tipe IN ('GATE-OUT','MUSNAH','RUSAK','PROCESS_IN','MOVE-OUT','MUSNAH','RUSAK')";
                    $sqlGetKeluar .= " GROUP BY kd_barang, jns_barang";
                    
                    $KELUAR = $this->db->query($sqlGetKeluar)->row();
                    $KELUAR = $KELUAR->PENGELUARAN;

                    #KOLOM PENYESUAIAN
                    $sqlPenyesuaian = "SELECT REPLACE(FORMAT(SUM(JML_ADJUSTMENT),4),',','') AS PENYESUAIAN
                        FROM tm_adjustment
                        WHERE STR_TO_DATE(tgl_adjustment,'%Y-%m-%d') = '" . $tgl_akhir . "'
                        AND kd_brg = '" . $listData['kd_barang'] . "' 
                        AND jns_brg = '" . $listData['jns_barang'] . "'";
                    $sqlPenyesuaian .= " GROUP BY kd_brg, jns_brg ORDER BY tgl_adjustment DESC LIMIT 1";

                    $PENYESUAIAN = $this->db->query($sqlPenyesuaian)->row();
                    $PENYESUAIAN = $PENYESUAIAN->PENYESUAIAN;

                    #KOLOM SALDO AKHIR
                    $SALDOAKHR = $SALDOAWL + $MASUK - $KELUAR + $PENYESUAIAN;

                    #KOLOM STOCKOPNAME
                    $sqlGetStock = "SELECT jml_stockopname AS JUMLAH
    							FROM tm_stockopname
    							WHERE DATE_FORMAT(tgl_stock, '%Y-%m-%d') = '".$tgl_stock."' 
    							AND kd_brg = '".$listData['kd_barang']."' 
    							AND jns_brg = '".$listData['jns_barang']."'";
                    $STOCK = $this->db->query($sqlGetStock);
                    if ($STOCK->num_rows() > 0) {
                        $STOCK = $STOCK->row();
                        $STOCK = $STOCK->JUMLAH;
                    } else {
                        $STOCK = "";
                    }

                    #UNTUK MENAMPILKAN SEMUA BARANG BAIK YG DIMUTASI ATAU TIDAK
                    if ($all) {
                        if (!in_array($listData['kd_barang'], $inaray)) {
    						$tglAkhirInOut = date('Y-m-d', strtotime($tgl_awal . "-1 day"));
    						$sqlGetSaldoStock = "SELECT jml_stockopname AS 'JUMLAH_STOCK', DATE_FORMAT(tgl_stock, '%Y-%m-%d') AS TANGGAL_STOCK
    									FROM tm_stockopname
    									WHERE DATE_FORMAT(tgl_stock, '%Y-%m-%d') <= '" . $tgl_awal . "'
    									AND kd_brg ='" . $listData['kd_barang'] . "' 
    									AND jns_brg ='" . $listData['jns_barang'] . "'";
    						$sqlGetSaldoStock .= " ORDER BY tgl_stock DESC LIMIT 1";

    						$RSSTOCKOPNAME = $this->db->query($sqlGetSaldoStock)->row();
    						$GETSALDOAWALSTOCK = $RSSTOCKOPNAME->JUMLAH_STOCK;

    						$TGSTK = "";
    						if ($RSSTOCKOPNAME->TANGGAL_STOCK != "") {
    							$TGSTK = " BETWEEN '" . date('Y-m-d', strtotime($RSSTOCKOPNAME->TANGGAL_STOCK.'+1 day')) . "' AND '" . $tglAkhirInOut . "'";
    						} else {
    							$TGSTK = " <= '" . $tglAkhirInOut . "'";
    						}

    						$sqlGetSaldoIn = "SELECT SUM(jml_satuan) AS 'AWAL_SALDO_IN', STR_TO_DATE(MAX(tgl_realisasi),'%Y-%m-%d') 'TGL_IN'
    									  FROM tr_inout
    									  WHERE STR_TO_DATE(tgl_realisasi,'%Y-%m-%d') " . $TGSTK . "
    									  AND kd_barang ='" . $listData['kd_barang'] . "' 
                                          AND jns_barang ='" . $listData['jns_barang'] . "'
    									  AND tipe IN ('GATE-IN','PROCESS_OUT','SCRAP','MOVE-IN')";
    						$sqlGetSaldoIn .= " GROUP BY kd_barang, jns_barang";

    						$sqlGetSaldoOut = "SELECT SUM(jml_satuan) AS 'AWAL_SALDO_OUT', STR_TO_DATE(MAX(tgl_realisasi),'%Y-%m-%d') 'TGL_OUT'
    									  FROM tr_inout
    									  WHERE STR_TO_DATE(tgl_realisasi,'%Y-%m-%d') " . $TGSTK . "
    									  AND kd_barang ='" . $listData['kd_barang'] . "' 
                                          AND jns_barang ='" . $listData['jns_barang'] . "'
    									  AND tipe IN ('GATE-OUT','PROCESS_IN','MOVE-OUT','MUSNAH','RUSAK')";
                            $sqlGetSaldoOut .= " GROUP BY kd_barang, jns_barang";

                            $sqlGetPenyesuaian = "SELECT SUM(JML_ADJUSTMENT) AS 'JUMLAH_ADJUSTMENT' 
                                                  FROM tm_adjustment 
                                                  WHERE STR_TO_DATE(tgl_adjustment,'%Y-%m-%d') ".$TGSTK." 
                                                  AND kd_brg = '".$listData['kd_barang']."' 
                                                  AND jns_brg = '".$listData['jns_barang']."'";
                            $sqlGetPenyesuaian .= " ORDER BY tgl_adjustment DESC LIMIT 1";

    						$RSGETSALDOAWALIN = $this->db->query($sqlGetSaldoIn)->row();
                            $GETSALDOAWALIN = $RSGETSALDOAWALIN->AWAL_SALDO_IN;
                            
    						$RSGETSALDOAWALOUT = $this->db->query($sqlGetSaldoOut)->row();
                            $GETSALDOAWALOUT = $RSGETSALDOAWALOUT->AWAL_SALDO_OUT;

                            $RSGETADJUSTMENT = $this->db->query($sqlGetPenyesuaian)->row();
                            $GETADJUSTMENT = $RSGETADJUSTMENT->JUMLAH_ADJUSTMENT;

    						if ($GETSALDOAWALSTOCK == "") {
    							$SALDOAWLGET = $GETSALDOAWALSTOCK + $GETSALDOAWALIN - $GETSALDOAWALOUT + $GETADJUSTMENT;
    						} else {
    							if ($RSSTOCKOPNAME->TANGGAL_STOCK == $tglAkhirInOut) { 
    								$SALDOAWLGET = $GETSALDOAWALSTOCK;
    							} else {
    								if ($RSSTOCKOPNAME->TANGGAL_STOCK == $RSGETSALDOAWALIN->TGL_IN || $RSSTOCKOPNAME->TANGGAL_STOCK == $RSGETSALDOAWALOUT->TGL_OUT) {
    									$SALDOAWLGET = $GETSALDOAWALSTOCK;
    								} else { 
    									$SALDOAWLGET = $GETSALDOAWALSTOCK + $GETSALDOAWALIN - $GETSALDOAWALOUT + $GETADJUSTMENT;
    								}
    							}
    						}

                            $sqlGetMasuk = "SELECT REPLACE(FORMAT(SUM(jml_satuan),2),',','') AS PEMASUKAN
    						        FROM tr_inout
    						        WHERE STR_TO_DATE(tgl_realisasi,'%Y-%m-%d') BETWEEN '" . $tgl_awal . "' AND '" . $tgl_akhir . "'
    						        AND kd_barang ='" . $listData['kd_barang'] . "' 
    						        AND jns_barang ='" . $listData['jns_barang'] . "'
    						        AND tipe IN ('GATE-IN','PROCESS_OUT','SCRAP','MOVE-IN')";
                            $sqlGetMasuk .= " GROUP BY kd_barang, jns_barang";

                            $MASUK = $this->db->query($sqlGetMasuk)->row();
                            $MASUK = $MASUK->PEMASUKAN;

                            #KOLOM PENGELUARAN
                            $sqlGetKeluar = "SELECT REPLACE(FORMAT(SUM(jml_satuan),2),',','') AS PENGELUARAN
    							   FROM tr_inout
    							   WHERE STR_TO_DATE(tgl_realisasi,'%Y-%m-%d') BETWEEN '" . $tgl_awal . "' AND '" . $tgl_akhir . "'
    							   AND kd_barang = '" . $listData['kd_barang'] . "' 
                                   AND jns_barang = '" . $listData['jns_barang'] . "'
    							   AND tipe IN ('GATE-OUT','MUSNAH','RUSAK','PROCESS_IN','MOVE-OUT','MUSNAH','RUSAK')";
                            $sqlGetKeluar .= " GROUP BY kd_barang, jns_barang";

                            $KELUAR = $this->db->query($sqlGetKeluar)->row();
                            $KELUAR = $KELUAR->PENGELUARAN;

                            #PENYESUAIAN
                            $PENYESUAIAN = 0;

                            $SALDOAWL = $SALDOAWLGET;
                            $SALDOAKHR = $SALDOAWL + $MASUK - $KELUAR + $PENYESUAIAN;

                            #KOLOM STOCKOPNAME
                            $sqlGetStock = "SELECT jml_stockopname AS JUMLAH
    							FROM tm_stockopname
    							WHERE DATE_FORMAT(tgl_stock,'%Y-%m-%d') = '" . $tgl_stock . "'
    							AND kd_brg = '" . $listData['kd_barang'] . "' 
    							AND jns_brg = '" . $listData['jns_barang'] . "'";
                            $STOCK = $this->db->query($sqlGetStock);
                            if ($STOCK->num_rows() > 0) {
                                $STOCK = $STOCK->row();
                                $STOCK = $STOCK->JUMLAH;
                            } else {
                                $STOCK = "";
                            }
                        }
                    } 

                    #KOLOM SELISIH
                    $SELISIH = "";
                    if ((is_array($STOCK) && empty($STOCK)) || strlen($STOCK) === 0) {
                        $SELISIH = "";
                    } else {
                        $SELISIH = $STOCK - $SALDOAKHR;
                    }

                    if ($SELISIH) {
                        if (number_format($SELISIH, 2) == '-0.00') {
                            $SELISIH = 0;
                        }
                    }

                    if ($SALDOAKHR) {
                        if (number_format($SALDOAKHR, 2) == '-0.00') {
                            $SALDOAKHR = 0;
                        }
                    }

                    if ($SALDOAWL) {
                        if (number_format($SALDOAWL, 2) == '-0.00') {
                            $SALDOAWL = 0;
                        }
                    }
                    ?>
                    <tr>
                        <td align="center" <?php echo $border; ?>><?= $no; ?></td>
                        <td <?php echo $border; ?>><?= $listData['kd_barang']; ?></td>
                        <td <?php echo $border; ?>><?= $listData['nm_brg']; ?></td>
                        <td <?php echo $border; ?>><?= $listData['kd_satuan']; ?></td>
                        <td align="right" <?php echo $border; ?>><?= number_format($SALDOAWL, 2); ?></td>
                        <td align="right" <?php echo $border; ?>><?= $MASUK ? number_format($MASUK, 2) : number_format(0,2); ?></td>
                        <td align="right" <?php echo $border; ?>><?= $KELUAR ? number_format($KELUAR, 2) : number_format(0,2); ?></td>
                        <td align="right" <?php echo $border; ?>><?= number_format($PENYESUAIAN, 2); ?></td>
                        <td align="right" <?php echo $border; ?>><?= number_format($SALDOAKHR, 2); ?></td>
                        <td align="right" <?php echo $border; ?>><?= $STOCK ? number_format($STOCK, 2) : ""; ?></td>
                        <td align="right" <?php echo $border; ?>><?= number_format($SELISIH, 2); ?></td>
                        <td <?php echo $border; ?>><?= getKeterangan($SELISIH); ?></td>
                    </tr>
                    <?php $no++;
                }
            } else { ?>
                <tr>
                    <td colspan="12" align="center" <?php echo $border; ?>>Nihil</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } elseif($tipe == "pemasukan" || $tipe == "pengeluaran") { ?>
    <table class="tabelPopUp" width="100%">
        <?php
        if($jns_file == "xls") { ?>
            <tr><td colspan="12">Kawasan Berikat PT Mutiara Laut Abadi</td></tr>
            <tr><td colspan="12">Laporan <?php echo ucwords($tipe); ?> Barang Per Dokumen Pabean</td></tr>
            <tr><td colspan="12">Periode <?php echo date_format(date_create($tgl_awal), 'd-m-Y')." s/d ".date_format(date_create($tgl_akhir), 'd-m-Y'); ?></td></tr>
            <tr><td colspan="12">&nbsp;</td></tr>
        <?php } ?>
        <tr align="left">
            <th rowspan="2" align="center" <?php echo $border; ?>>No</th>
            <th rowspan="2" <?php echo $border; ?>>Jenis Dokumen</th>
            <th rowspan="2" <?php echo $border; ?>>Nomor Aju</th>
            <th colspan="2" <?php echo $border; ?>>Dokumen Pabean</th>
            <?php if ($tipe == 'pemasukan') { ?>            
                <th colspan="2" <?php echo $border; ?>>Bukti/Dok. Penerimaan</th>
            <?php }if ($tipe == 'pengeluaran') { ?>
                <th colspan="2" <?php echo $border; ?>>Bukti/Dok. Pengeluaran</th>
            <?php }if ($tipe == 'pemasukan') { ?>            
                <th rowspan="2" <?php echo $border; ?>>Pemasok/Pengirim</th>
            <?php }if ($tipe == 'pengeluaran') { ?>
                <th rowspan="2" <?php echo $border; ?>>Pembeli/Penerima</th>
            <?php } ?>
            <th rowspan="2" <?php echo $border; ?>>Kode Barang</th>
            <th rowspan="2" <?php echo $border; ?>>Nama Barang</th>
            <th rowspan="2" <?php echo $border; ?>>Satuan</th>
            <th rowspan="2" <?php echo $border; ?>>Jumlah</th>
            <th rowspan="2" <?php echo $border; ?>>Nilai Barang</th>
        </tr>
        <tr align="center">
            <th <?php echo $border; ?>>Nomor</th>
            <th <?php echo $border; ?>>Tanggal</th>
            <th <?php echo $border; ?>>Nomor</th>
            <th <?php echo $border; ?>>Tanggal</th>
        </tr>
        <?php
        $banyakData = count($data);
        if ($banyakData > 0) {
            $no = 1;
            foreach ($data as $listData) {
                ?>
                <tr>
                    <td align="center" <?php echo $border; ?>><?= $no; ?></td>
                    <td <?php echo $border; ?>><?= $listData['kd_dok']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['car']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['no_dok']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['tgl_dok']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['no_dok_internal']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['tgl_dok_internal']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['nm_supplier']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['kd_barang']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['nm_brg']; ?></td>
                    <td <?php echo $border; ?>><?= $listData['kd_satuan']; ?></td>
                    <td align="right" <?php echo $border; ?>><?= number_format($listData['jml_satuan'], 2); ?></td>
                    <td align="right" <?php echo $border; ?>><?= number_format($listData['hrg_barang'], 2); ?></td>
                </tr>
                <?php $no++;
            }
        } else { ?>
            <tr>
                <td colspan="13" align="center" <?php echo $border; ?>>Nihil</td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>
