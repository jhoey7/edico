<table width="100%" cellpadding="0" cellspacing="2">
    <tr>
    	<td align="center" style="font-size:14px;text-transform:uppercase;font-weight:bold">
            <?= $TRADER["NAMA_TRADER"] ?>
        </td>
    </tr>
    <tr>
    	<td align="center" style="text-transform:uppercase;">
            <div style="width:350px">
                <?= $TRADER["ALAMAT_TRADER"] ?>
            </div>
        </td>
    </tr>
    <tr>
    	<td align="center" style="text-transform:uppercase;">
            <div style="width:350px">   
                TELP.  <?= $TRADER["TELEPON"] ?>, FAX.  <?= $TRADER["FAX"] ?>
            </div>
        </td>
    </tr>
    <tr>
    	<td align="center" style="border-bottom:3px solid #000;border-bottom-style:ridge">&nbsp;</td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="2">
    <tr>
        <td width="20%">Nomor</td>
        <td width="2%">:</td>
        <td width="38%"><?= $header["NO_SURAT"] ?></td>
        <td width="40%" align="right">Tanggal : <?= $header['TGL_SURAT'] ?></td>           
    </tr>
    <tr>
        <td>Lampiran</td>
        <td>:</td>
        <td colspan="2"><?= $JMLLAMPIRAN ?></td>
    </tr>
    <tr>
        <td>Hal</td>
        <td>:</td>
        <td colspan="2"><?= $header["PERIHAL"] ?></td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">Yth. Kepala <?= ucwords(strtolower($header["KD_KANTOR_TUJUAN"])) ?></td>
    </tr>
    <tr>
        <td colspan="4">Di Tempat</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">
            <table width="100%" cellpadding="0" cellspacing="2" border="0">
                <tr>
                    <td width="1" valign="top">1.</td>
                    <td colspan="3">Dengan memperhatikan Peraturan Menteri Keuangan Nomor 143/PMK.04/2011 tentang Kawasan Berikat dengan ini kami menyerahkan Permohonan</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>                    
                    <td colspan="4"><?= ucwords(strtolower($header["PERIHAL"])) ?></td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <? if($LAMPIRAN){ ?>
                <tr>
                    <td valign="top">2.</td>
                    <td colspan="4">Sebagai bahan pertimbangan, kami lampirkan berkas dokumen yang terkait dengan permohonan dimaksud :</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="4"><?= $LAMPIRAN ?></td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top">3.</td>
                    <td colspan="3">Terkait permohonan ini kami menyatakan dokumen untuk melengkapi permohonan sebagaimana terlampir adalah sesuai dengan aslinya dan dapat dipertanggungjawabkan kebenarannya.</td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top">4.</td>
                    <td colspan="3">Demikian permohonan kami, jika permohonan kami diterima, kami menyatakan bersedia memenuhi seluruh ketentuan peraturan perundang-undangan yang berlaku.</td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top">5.</td>
                    <td colspan="3">Dalam rangka pengurusan permohonan ini kami menugaskan Pegawai sebagai berikut :</td>
                </tr>
                <? }else{ ?>
                <tr>
                    <td valign="top">2.</td>
                    <td colspan="3">Terkait permohonan ini kami menyatakan dokumen untuk melengkapi permohonan sebagaimana terlampir adalah sesuai dengan aslinya dan dapat dipertanggungjawabkan kebenarannya.</td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top">3.</td>
                    <td colspan="3">Demikian permohonan kami, jika permohonan kami diterima, kami menyatakan bersedia memenuhi seluruh ketentuan peraturan perundang-undangan yang berlaku.</td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top">4.</td>
                    <td colspan="3">Dalam rangka pengurusan permohonan ini kami menugaskan Pegawai sebagai berikut :</td>
                </tr>
                <? } ?>
                <tr>
                    <td width="2%">&nbsp;</td>    
                    <td width="21%">Nama</td>
                    <td width="1%">:</td>
                    <td width="76%"><?= $header["NM_PEMOHON"] ?></td>
                </tr>
                <tr>   
                    <td>&nbsp;</td>    
                    <td>Nomor Identitas</td>
                    <td>:</td>
                    <td><?= $header["ID_PEMOHON"] ?></td>
                </tr>   
                <tr>
                    <td>&nbsp;</td>    
                    <td>No. Surat Tugas/Surat Kuasa</td>
                    <td>:</td>
                    <td><?= $header["NO_SURAT_TUGAS"] ?></td>
                </tr>
                <tr>   
                    <td>&nbsp;</td>    
                    <td>Telepon</td>
                    <td>:</td>
                    <td><?= $header["TELEPON"] ?></td>
                <tr>
                    <td>&nbsp;</td>    
                    <td>Email</td>
                    <td>:</td>
                    <td><?= $header["EMAIL"] ?></td>
                </tr>
            </table> 
        </td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4" align="right">
            <table>
                <tr>
                    <td align="center">                
                        Pemohon<br><br><br><?= $header["NM_PEMOHON"]?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>     
</table>
<?php
	if($pagebreak){
		echo "";
	}else{
		 echo "<pagebreak />";
	}
?>