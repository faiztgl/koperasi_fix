<?php
include "../config/koneksi.php";
$kode_t=$_GET['kode_tabungan'];
$kode_a=$_GET['kode_anggota'];
$besar=$_GET['besar_ambil'];
$saldo=$_GET['saldo'];
$date=date("Y-m-d");

$kode=$_GET['kode_anggota'];
$tuggak=mysql_num_rows(mysql_query("SELECT * from t_pinjam where kode_anggota='$kode' and status='belum lunas' order by kode_pinjam desc "));
if($tuggak>0)
	{ ?>
		<script>alert("Maaf Aggota ini masih ada tunggakan");window.location="../index.php?pilih=1.2";</script>
	<?php }
	else if($tunggak==0)
	{
			//mysql_query("DELETE FROM t_pinjam where kode_anggota='$kode'");
			//mysql_query("DELETE FROM t_angsur where kode_anggota='$kode'");
			//mysql_query("DELETE FROM t_simpan where kode_anggota='$kode'");
		mysql_query("DELETE FROM t_pengajuan where kode_anggota='$kode'");
		$qdelete=mysql_query("UPDATE t_anggota set status='keluar' WHERE kode_anggota='$kode'");
		if($qdelete){ 
			$tunjangan=mysql_fetch_array(mysql_query("SELECT * from t_tabungan where kode_anggota='$kode' "));
			$jadine=$tunjangan['besar_tabungan'];?>
			<script>
				window.open('notatunjang.php?kode_anggota=<?php echo $kode; ?>&tunjangan=<?php echo $jadine; ?>','popuppage','width=500,toolbar=1,resizable=1,scrollbars=yes,height=450,top=30,left=100');
				mysql_query("INSERT INTO t_pengambilan values('','$kode','','$jadine','$dat')"); ?>
			</script>
				<?php //mysql_query("DELETE FROM t_tabungan where kode_anggota='$kode'");
						//header("");
			}else{
				echo "Hapus Data Gagal!!!!";
			}
		}	

		if($besar>$saldo)
			{ ?>
				<script>alert("Maaf Saldo tidak cukup");window.location="../index.php?pilih=1.3";</script>
			<?php }
			else
			{
				$dfop=mysql_query("INSERT into t_pengambilan values('','$kode_a','$kode_t','$besar','$date')");
				$siso=$saldo-$besar;
				mysql_query("UPDATE t_tabungan set besar_tabungan='$siso' where kode_tabungan='$kode_t' and kode_anggota='$kode_a'");
				mysql_query("UPDATE t_simpan set besar_simpanan='$siso' where kode_tabungan='$kode_t'");?>
				<script>window.open('notaambil.php?kode_anggota=<?php echo $kode_a; ?>&kode_tabungan=<?php echo $kode_t; ?>&besar_ambil=<?php echo $besar; ?>','popuppage','width=500,toolbar=1,resizable=1,scrollbars=yes,height=450,top=30,left=100');

				window.location="../index.php?pilih=1.3&aksi=viewambil&kode_tabungan=<?php echo $kode_t; ?>&kode_anggota=<?php echo $kode_a; ?>";</script>
			<?php }
			?>