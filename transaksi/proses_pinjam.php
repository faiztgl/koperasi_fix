<?php
include "../config/koneksi.php";
$kode_anggota		= $_GET['kode_anggota'];
$kode_jenis_pinjam	= $_GET['kode_jenis_pinjam'];
$jenis_jaminan		= $_GET['jenis_jaminan'];
$detjam				= $_GET['detjam'];
$detjam1			= $_GET['detjam1'];
$detjam2			= $_GET['detjam2'];
$detjamx			= $detjam1." ".$detjam2." ".$detjam;
$besar_pinjaman		= $_GET['besar_pinjaman'];
$besar_pinjamank	= str_replace(".","",$besar_pinjaman);
$besar_angsuran		= $_GET['besar_angsuran'];
$besar_angsurank	= str_replace(".","",$besar_angsuran);
$lama_angsuran		= $_GET['lama_angsuran'];
$kembangbulan		= $_GET['kembangbulan'];
$kembangbulank		= str_replace(".","",$kembangbulan);
$angsur_tb			= $_GET['angsur_tb'];
$angsur_tbk			= str_replace(".","",$angsur_tb);
$u_entry			= $_GET['u_entry'];
$potong_adm			= $_GET['potong_adm'];
$potong_admk		= str_replace(".","",$potong_adm);
$tgl_entri			= $_GET['tgl_entri'];
$maks 				= $_GET['maks_pinjam'];
$simpan=mysql_fetch_array(mysql_query("SELECT sum(besar_simpanan) as simpan from t_simpan"));
       	//echo $tabung['tabung'];
$angsur=mysql_fetch_array(mysql_query("SELECT sum(besar_angsuran) as angsuran from t_angsur"));
       	//echo $angsur['angsuran'];
$denda=mysql_fetch_array(mysql_query("SELECT sum(denda) as denda from t_angsur"));
       	//echo $denda['denda'];
$pinjam=mysql_fetch_array(mysql_query("SELECT sum(besar_pinjam) as pinjam from t_pinjam"));
$ambil=mysql_fetch_array(mysql_query("SELECT sum(besar_ambil) as ambil from t_pengambilan"));

$pendapatan=$simpan['simpan']+$angsur['angsuran']+$denda['denda'];
$pengambilan=$pinjam['pinjam']+$ambil['ambil'];
$sisa=$pendapatan-$pengambilan;
if($sisa<$besar_pinjaman)
	{ ?>
		<script>
			alert("Maaf Keuangan masih tidak normal silahkan lakukan transasi bebehari kedepan");
			window.location="../index.php?pilih=2.1&aksi=pinjamangsur&kode_anggota=<?php echo $kode_anggota;?>";
		</script>
	<?php }
	else if($sisa>$besar_pinjaman)
	{
		if($besar_pinjaman>$maks)
			{ ?>
				<script>
					alert("Maaf besar pinjaman melebihi maksimal pinjam");
					window.location="../index.php?pilih=2.1&aksi=pinjamangsur&kode_anggota=<?php echo $kode_anggota;?>";
				</script>
			<?php }
			else if($besar_pinjaman<=$maks)
			{
				$tempo=date('Y-m-d',strtotime('+30 day',strtotime($tgl_entri)));
				$sql=mysql_query("INSERT into t_pinjam values ('','$kode_anggota','$kode_jenis_pinjam','$jenis_jaminan','$detjamx','$besar_pinjamank','$kembangbulank','$angsur_tbk','$besar_angsurank','$potong_admk','$lama_angsuran','','$besar_pinjamank','$u_entry','$tgl_entri','$tempo','belum lunas')");
				if($sql)
					{ ?>
						<script>
							window.open('notapinjam.php?kode_anggota=<?php echo $kode_anggota; ?>&kode_jenis=<?php echo $kode_jenis_pinjam; ?>&besar_pinjaman=<?php echo $besar_pinjaman; ?>&besar_angsuran=<?php echo $besar_angsuran; ?>','popuppage','width=500,toolbar=1,resizable=1,scrollbars=yes,height=450,top=30,left=100');
							window.location="../index.php?pilih=2.1&aksi=pinjamangsur&kode_anggota=<?php echo $kode_anggota; ?>";
						</script>
					<?php }
					else
					{
						$gagal = mysqli_error($koneksi);
						echo $gagal;
					}
				}	
			}	

			?>

