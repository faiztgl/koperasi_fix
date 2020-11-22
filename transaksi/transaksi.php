<?php 
include "config/koneksi.php";
include "fungsi/fungsi.php";

$aksi=$_GET['aksi'];

?>
<script src="jquery.js"></script>

<!-- SIMPANAN -->
<script language="JavaScript">
	
	$(document).ready(function(){
		$(function() {
			$( '#tanggal' ).datepicker({
				dateFormat:'yy-mm-dd',
				changeMonth: true,
				changeYear: true
			});
			$( '#tgl' ).datepicker({
				dateFormat:'yy-mm-dd',
				changeMonth: true,
				changeYear: true
			});
		});
	});
	// fungsi untuk get besar_simpanan
	function show(kode_jenis_simpan){
		$.ajax({
			type : "POST",
			data : "kode_jenis_simpan="+kode_jenis_simpan,
			url  : "dataSimpanan.php",
			success : function(msg){
				hasil = jQuery.parseJSON(msg);
				if(hasil.NAMA_SIMPANAN!=""){
					$('#besar_simpanan').val(hasil.BESAR_SIMPANAN);				
				}else{
					$('#besar_simpanan').val("");				
				}
			}
		})
	}
	$(document).ready(function(){
		$("#kategori").change(function(){
			var kat = $("#kategori").val();
			if (kat == "tgl_simpan"){
				$("#cari").html('<input type=\"text\" name=\"input_cari\" id=\"tgl\" onclick=\"datePicker("tgl")\"/>');
			}else{
				$("#cari").html('<input type="text" name="input_cari" id="cari"/>');
			}
		});
	});
</script>

<!-- PINJAMAN -->
<script language="JavaScript">
		// fungsi untuk get besar_simpanan
		function show3(kode_jenis_pinjam){
			$.ajax({
				type : "POST",
				data : "kode_jenis_pinjam="+kode_jenis_pinjam,
				url : "dataJenisPinjaman.php",
				success : function(msg){
					hasil = jQuery.parseJSON(msg);
					if(hasil.NAMA_PINJAMAN!=""){
						$('#lama_angsuran').val(hasil.LAMA_ANGSURAN);
						$('#maks_pinjam').val(hasil.MAKS_PINJAM);
						$('#bunga').val(hasil.BUNGA);
					}else{		
						$('#lama_angsuran').val("");
						$('#maks_pinjam').val("");
					}
				}
			})
		}
	// menghitung pinjaman
	function startCalc(){
		interval = setInterval("calc()",1);
	}
	//menghitung ansuran
	function calc(){
		a = document.frmAdd.besar_pinjaman.value;
		f = document.frmAdd.bunga.value/100;
		e = document.frmAdd.maks_pinjam.value;
		b = document.frmAdd.lama_angsuran.value;
		g = a * f;
		i = a / b;
		h = parseInt(g)+parseInt(i);
		c = document.frmAdd.besar_angsuran.value = h ;
	} 
	function stopCalc(){
		clearInterval(interval);
	} 
</script>

<!-- ANGSURAN -->
<script language="JavaScript">
	// fungsi untuk get besar_simpanan
	function show2(kode_pinjam){
		$.ajax({
			type : "POST",
			data : "kode_pinjam="+kode_pinjam,
			url  : "dataPinjaman.php",
			success : function(msg){
				hasil = jQuery.parseJSON(msg);
				if(hasil.TGL_PINJAM!=""){
					$('#tgl_pinjam').val(hasil.TGL_PINJAM);	
					$('#besar_pinjam').val(hasil.BESAR_PINJAM);
					var a=$('#lama_angsuran').val(hasil.LAMA_ANGSURAN);
					$('#besar_angsuran').val(hasil.BESAR_ANGSURAN);
					var b=$('#angsuran_ke').val(hasil.SISA_ANGSURAN);


				}else{
					$('#besar_simpanan').val("");				
				}
			}
		})
	}
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#cari").keyup(function(){
			$("#fbody").find("tr").hide();
			var data = this.value.split("");
			var jo = $("#fbody").find("tr");
			$.each(data, function(i, v)
			{
				jo = jo.filter("*:contains('"+v+"')");
			});
			jo.fadeIn();

		})
	});

</script>


</head>

<?php
if(empty($aksi)){
	?>
	<body>  
		<div class="row mt">
			<div class="col-lg-12">
				<div class="form-panel">
					<h4 class="mb"><span class='glyphicon glyphicon-briefcase'></span> Transaksi <span style="float:right;">
						<input type="text" id="cari" style="width:230px;height:30px;font-size:15px;" placeholder=" cari disini...">
					</span>
				</h4>
				<form class="form-inline" role="form">
					<table class="table table-bordered table-striped table-condensed">
						<thead>
							<tr class="info">
								<th><a href="#">No</a></th>
								<th><a href="#">Kode Anggota</a></th>
								<th><a href="#">Nama Anggota</a></th>
								<th><a href="#">Pekerjaan</a></th>
								<th><a href="#">Tanggal Masuk</a></th>
								<th><a href="">Aksi</a></th>
							</tr>	
						</thead>
						<?php
						$query=mysql_query("SELECT * FROM t_anggota where status='aktif'
							ORDER BY kode_anggota ASC");
						echo ' <tbody id="fbody">';$no=1;		
						while($data=mysql_fetch_array($query)){
							?>

							<tr>
								<td><?php echo $no;?></td>
								<td align="center"><?php echo $kod=$data['kode_anggota'];?></td>
								<td><?php echo $data['nama_anggota'];?></td>
								<td><?php echo $data['pekerjaan'];?></td>
								<td align="center"><?php echo $data['tgl_masuk'];?></td>
								<td align="center">
									<a class="btn btn-primary btn-xs" href="index.php?pilih=2.1&aksi=simpanananggota&kode_anggota=<?php echo $data['kode_anggota'];?>"><i class="glyphicon glyphicon-check"></i> Simpan</a>
									<a class="btn btn-success btn-xs" href="index.php?pilih=2.1&aksi=pinjamangsur&kode_anggota=<?php echo $data['kode_anggota'];?>"><i class="glyphicon glyphicon-edit"></i> Pinjam | <i class="glyphicon glyphicon-share"></i> Angsur</a> 
									<?php 
									if($_SESSION['level']=='admin')
									{

									}
									else if($_SESSION['level']=='operator')
										{ ?>
											<a class="btn btn-danger btn-xs" href="index.php?pilih=4.4&aksi=operator&kode_anggota=<?php echo $data['kode_anggota'];?>"><i class="glyphicon glyphicon-question-sign"></i> Pengajuan</a>
										<?php    }
										?>
									</td>
								</tr>  
								<?php
	$no++;} //tutup while
	?>
</tbody>  </table>
</div>
</div><!-- /col-lg-12 -->
</div><!-- /row -->

<?php
}elseif($aksi=='simpan'){
	$kode=$_GET['kode_anggota'];
	$kode_jenis=$_GET['kode_jenis_simpan'];
	$nama=mysql_fetch_array(mysql_query("SELECT *from t_jenis_simpan where kode_jenis_simpan='$kode_jenis'"));
	$qubah=mysql_query("SELECT * FROM t_anggota WHERE kode_anggota='$kode'");
	$data2=mysql_fetch_array($qubah);
	?>

	<div class="row mt">
		<div class="col-lg-12">
			<div class="form-panel" style="width:50%;">
				<h4 class="mb"><span class='glyphicon glyphicon-briefcase'></span> Transaksi Simpanan</h4>
				<form action="transaksi/proses_transaksi.php?pros=simpan" method="post" id="form" name="mainform" onSubmit="validasiSimpan()">
					<div class="form-group">
						<label>Kode Anggota</label>
						<input type="hidden" name="kode_tabungan" value="<?php echo $data2['kode_tabungan']; ?>">
						<input type="text" name="kode_anggota" size="34" title="Kode Anggota harus diisi" readonly="" class="form-control" value="<?php echo $data2['kode_anggota'];?>">
					</div>
					<div class="form-group">
						<label>Nama Anggota</label>
						<input type="text" name="nama_anggota" size="54" class="form-control" readonly value="<?php echo $data2['nama_anggota'];?>"/>
					</div>
					<div class="form-group">
						<label>Pekerjaan</label>
						<input type="text" name="pekerjaan" class="form-control" size="54" readonly value="<?php echo $data2['pekerjaan'];?>"/>
					</div>
					<div class="form-group">
						<label>Jenis Simpanan</label>
						<select name="kode_jenis_simpan" class="form-control" id="kode_jenis_simpan" onChange="show(this.value)" class="required" title="Jenis Simpan harus diisi">
							<option value="<?php echo $kode_jenis;?>"><?php echo $nama['nama_simpanan'];?></option>

						</select>
					</div>
					<script>
						function isNumberKey(evt)
						{
							var charCode = (evt.which) ? evt.which : event.keyCode
							if (charCode > 31 && (charCode < 48 || charCode > 57))

								return false;
							return true;
						}
					</script>
					<?php if($nama['nama_simpanan']=='sukarela')
					{
						?>
						<div class="form-group">
							<label>Besar Simpanan</label>
							<input type="text" onkeypress="return isNumberKey(event);" value="<?php echo $nama['besar_simpanan'];?>" name="besar_simpanan" class="form-control" id="besar_simpanan" size="54"/>
						</div>
					<script type="text/javascript">
						var besar_simpanan = document.getElementById('besar_simpanan');
						besar_simpanan.addEventListener('keyup', function(e){
							// tambahkan 'Rp.' pada saat form di ketik
							// gunakan fungsi formatnilaijam() untuk mengubah angka yang di ketik menjadi format angka
							besar_simpanan.value = formatbesar_simpanan(this.value);
						});
				 
						/* Fungsi formatnilaijam */
						function formatbesar_simpanan(angka, prefix){
							var number_string = angka.replace(/[^,\d]/g, '').toString(),
							split   		= number_string.split(','),
							sisa     		= split[0].length % 3,
							besar_simpanan     		= split[0].substr(0, sisa),
							ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
				 
							// tambahkan titik jika yang di input sudah menjadi angka ribuan
							if(ribuan){
								separator = sisa ? '.' : '';
								besar_simpanan += separator + ribuan.join('.');
							}
				 
							besar_simpanan = split[1] != undefined ? besar_simpanan + ',' + split[1] : besar_simpanan;
							return prefix == undefined ? besar_simpanan : (besar_simpanan ? + besar_simpanan : '');
						}
					</script>
					<?php } 
					else { ?>
						<div class="form-group">
							<label>Besar Simpanan</label>
							<input type="text" onkeypress="return isNumberKey(event);"  value="<?php echo $nama['besar_simpanan'];?>" name="besar_simpanan" class="form-control" id="besar_simpanan" size="54" readonly/>
						</div>
					<?php } ?>
					<div class="form-group">
						<label>User Entri</label>
						<input type="text" name="user_entri" class="form-control" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly >
					</div>
					<div class="form-group">
						<label>Tanggal Entri</label>
						<input type="text" name="tgl_entri" class="form-control" size="54" value="<?php echo date("Y-m-d");?>" readonly />
					</div>
					<button class="btn btn-danger"><span class='glyphicon glyphicon-check'></span> Simpan</button>
				</form>

			</div>
		</div>
	</div>






	<!-- 	PINJAMAN -->

	<?php
}else if($aksi=='pinjam'){
	$kode=$_GET['kode_anggota'];
	$qubah=mysql_query("SELECT * FROM t_anggota WHERE kode_anggota='$kode'");
	$data2=mysql_fetch_array($qubah);
	?>

	<!-- <div class="row">
		<div class="col-lg-12">
			<h4 class="text-center">Transaksi Pinjaman</h4>
		</div>
	</div>

	<div class="row mt">
		<div class="col-lg-6">
			<h4 class="text-center">Hitung Maksimal Pinjaman</h4>

			<form method="POST">
				<div class="form-group">
					<label>Harga</label>
					<input type="text" class="form-control" name="harga">
				</div>
				<div class="form-group">
					<label>Presentase</label>
					<input type="text" class="form-control" name="qty" value="0.75" readonly>
				</div>
				<div class="form-group">
					<label>Potongan</label>
					<input type="text" class="form-control" name="pot" value="35000" readonly>
				</div>
				<div>
					<button type="submit" name="hitung" class="btn btn-success"> Hittung</button>
				</div>
			</form>
			<hr />
			<h3>Hasil :</h3>
			<?php
			if(isset($_POST['hitung'])){
				$harga    =$_POST['harga'];
				$qty    =$_POST['qty'];
				$pot = $_POST['pot'];
				$total    =$harga*$qty-$pot;
				echo "
				<form>
				<tr>
				<td>Nama</td>
				<input type='text' name='nma' value='$total'>
				</tr>
				";
			}
			?>
		</div> -->


		<div class="col-lg-6">
			<div class="form-panel" style="width:100%;">
				<h4 class="mb"><span class='glyphicon glyphicon-briefcase'></span> Transaksi Pinjaman</h4>
				<form action="transaksi/proses_pinjam.php" method="GET" id="form" name="frmAdd">
					<div class="form-group">
						<label>Kode Anggota</label>
						<input type="text" class="form-control" name="kode_anggota" size="34" title="Kode Anggota harus diisi" readonly="" value="<?php echo $data2['kode_anggota'];?>">
					</div>
					<div class="form-group">
						<label>Nama Anggota</label>
						<input type="text" class="form-control" name="nama_anggota" size="54" readonly value="<?php echo $data2['nama_anggota'];?>"/>
					</div>
					<div class="form-group">
						<label>Pekerjaan</label>
						<input type="text" class="form-control" name="pekerjaan" size="54" readonly value="<?php echo $data2['pekerjaan'];?>"/>
					</div>

					<div class="form-group">
						<label>Jenis Jaminan</label>
						<select type="text" class="form-control" name="jenis_jaminan">
							<option>--Pilih--</option>
							<option value="BPKB">BPKB</option>
							<option value="SERTIFIKAT">SERTIFIKAT</option>
						</select>

						<!-- <input type="text" class="form-control" name="jenis_jaminan" required=""> -->
					</div>
					
					<div class="form-group">
						<label>Merk/Model</label>
						<input type="text" class="form-control" id="detjam1" name="detjam1" size="200" placeholder="Merk/Model Jaminan" required="">
						<label>Tipe/Luas</label>
						<input type="text" class="form-control" id="detjam2" name="detjam2" size="200" placeholder="Tipe/Luas Jaminan" required="">
						<label>Detail Jaminan</label>
						<input type="text" class="form-control" id="detjam" name="detjam" size="200" placeholder="Tahun atau Alamat Jaminan" required="">
					</div>

					<div class="form-group">
						<label>Nilai Jaminan</label>
						<input type="text" class="form-control" id="nilaijam" name="nilaijam" required="">
					</div>

					<div class="form-group">
						<label>Presentase Acc (%)</label>
						<input type="text" class="form-control" id="acc" value="75" readonly>
					</div>
					<div class="form-group mb-0">
						<label>Maksimal Pinjam</label>
						<input type="text" id="total" name="maks_pinjam" class="form-control" placeholder="Total" readonly="">
					</div>

					<div class="form-group">
						<label>Besar Pinjam</label>
						<input type="text"  class="form-control" name="besar_pinjaman" id="pinjam" size="54" />
					</div>

					

					<div class="form-group">
						<label>Lama Angsuran</label>
						<label>Lama Angsuran (Bulan)</label>
						<!--<input type="text" name="lama_angsuran" id="lamaangsur" class="form-control">-->
						  <select type="text" class="form-control" name="lama_angsuran" id="lamaangsur">
							<option>--pilih--</option>
							<option value="6">6</option>
							<option value="12">12</option>
							<option value="24">24</option>
						</select>
					</div>
						 <!-- <select name="kode_jenis_pinjam" class="form-control" id="kode_jenis_pinjam" onChange="show3(this.value)" class="required" title="Jenis Pinjaman harus diisi">
							<?php
							$q=mysql_query("SELECT * FROM t_jenis_pinjam");
							while($a=mysql_fetch_array($q)){
								?>
								<option value="<?php echo $a['kode_jenis_pinjam'];?>"><?php echo $a['nama_pinjaman'];?></option>
								<?php
							}
							?>
						</select> 
					</div> -->
					<!-- <div class="form-group">
						<label>Lama Angsuran (Bulan)</label>
						<input id="lama_angsuran" class="form-control" placeholder="Bulan" type="text" name="lama_angsuran" style="width:100px;" readonly/>
					</div> -->
					<!-- <div class="form-group">
						<label>Maks Pinjaman</label>
						<input id="maks_pinjam" class="form-control" type="text" name="maks_pinjam" size="54" readonly/>
					</div> -->
					<!-- <div class="form-group">
						<label>Bunga (%)</label>
						<input id="kembang" class="form-control" type="text" size="54" value="2" readonly/>
					</div> -->
					<!-- <script>
						function isNumberKey(evt)
						{
							var charCode = (evt.which) ? evt.which : event.keyCode
							if (charCode > 31 && (charCode < 48 || charCode > 57))

								return false;
							return true;
						}
					</script> -->
					<div class="form-group mb-0">
						<label>Biaya Adm</label>
						<input type="text" class="form-control" name="potong_adm" id="potonganadm" value="35.000" readonly="">
					</div>

					<div class="form-group mb-0">
						<label>Yang Diterima</label>
						<input type="text" id="totalterima" class="form-control"  readonly="">
					</div>

					<div class="form-group">
						<label>Angsuran Perbulan</label>
						<input type="text"  class="form-control" id="jmlangsur" name="angsur_tb" size="54" readonly=""/>
					</div>

					<div class="form-group">
						<label>Bunga Perbulan (2%)</label>
						<input type="text" id="kembangbulan" name="kembangbulan" class="form-control"  size="54" readonly=""/>
					</div>

					<div class="form-group">
						<label>Total Angsuran Perbulan</label>
						<input type="text" class="form-control" name="besar_angsuran" id="totangsur" size="54" readonly=""/>
					</div>
					<div class="form-group">
						<label>User Entri</label>
						<input type="text" class="form-control" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly>
					</div>
					<div class="form-group">
						<label>Tanggal Entri</label>
						<input type="text" class="form-control" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly/>
					</div>
					<button class="btn btn-danger"><span class='glyphicon glyphicon-edit'></span> Pinjam</button>
				</form>

			</div>
		</div>
	</div>

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<!--<script type="text/javascript" src="/column/js/main.js"></script>-->
	<script type="text/javascript">
		
		var nilaijam = document.getElementById('nilaijam');
		nilaijam.addEventListener('keyup', function(e){
			// tambahkan 'Rp.' pada saat form di ketik
			// gunakan fungsi formatnilaijam() untuk mengubah angka yang di ketik menjadi format angka
			nilaijam.value = formatnilaijam(this.value);
		});
 
		/* Fungsi formatnilaijam */
		function formatnilaijam(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			nilaijam     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				nilaijam += separator + ribuan.join('.');
			}
 
			nilaijam = split[1] != undefined ? nilaijam + ',' + split[1] : nilaijam;
			return prefix == undefined ? nilaijam : (nilaijam ? + nilaijam : '');
		}
		$(document).ready(function(){
			$("#nilaijam").keyup(function(){ 
				var nilaijam  = parseInt($("#nilaijam").val().replace(/[^0-9]/gi, ''));
				console.log(nilaijam);
				var acc  = parseInt($("#acc").val());
				var total = nilaijam * (acc/100);
				$("#total").val(total); 
				$("#total").val(formatnilaijam($("#total").val())); 
			}); 
		});

			var pinjam = document.getElementById('pinjam');
			pinjam.addEventListener('keyup', function(e){
			// tambahkan 'Rp.' pada saat form di ketik
			// gunakan fungsi formatnilaijam() untuk mengubah angka yang di ketik menjadi format angka
			pinjam.value = formatnilaijam(this.value);
		});
	</script> 
	<script type="text/javascript">
		$(document).ready(function(){
			$("#pinjam").keyup(function(){ 
				var pinjam  = parseInt($("#pinjam").val().replace(/[^0-9]/gi, ''));
				var potonganadm = parseInt($("#potonganadm").val().replace(/[^0-9]/gi, ''));
				var totalterima = pinjam - potonganadm;
				$("#totalterima").val(totalterima); 
				$("#totalterima").val(formatnilaijam($("#totalterima").val()));
			}); 
		}); 
	</script> 
	<script type="text/javascript">
		$(document).ready(function(){
			$("#lamaangsur").on("change", function(){ 
				var lamaangsur  = parseInt($("#lamaangsur option:selected").val());
				var pinjam  = parseInt($("#pinjam").val().replace(/[^0-9]/gi, ''));
				var totangsur =(pinjam / lamaangsur) + (pinjam * 0.02) ;
				var bulat = Math.ceil(totangsur);
				$("#totangsur").val(bulat); 
				$("#totangsur").val(formatnilaijam($("#totangsur").val()));
			}); 
		}); 
	</script> 
	<script type="text/javascript">
		$(document).ready(function(){
			$("#lamaangsur").on("change",function(){ 
				var lamaangsur  = parseInt($("#lamaangsur option:selected").val().replace(/[^0-9]/gi, ''));
				var pinjam  = parseInt($("#pinjam").val().replace(/[^0-9]/gi, ''));
				var jmlangsur =pinjam / lamaangsur ;
				var bulat = Math.ceil(jmlangsur);
				$("#jmlangsur").val(bulat);
				$("#jmlangsur").val(formatnilaijam($("#jmlangsur").val()));
			}); 
		}); 
	</script>  
	<script type="text/javascript">
		$(document).ready(function(){
			$("#pinjam").keyup(function(){ 
				var pinjam  = parseInt($("#pinjam").val().replace(/[^0-9]/gi, ''));
				var kembangbulan =pinjam * 0.02;
				$("#kembangbulan").val(kembangbulan); 
				$("#kembangbulan").val(formatnilaijam($("#kembangbulan").val()));
			}); 
		}); 
	</script>
	
	


	<!-- ANGSUR -->

	<?php
}else if($aksi=='angsur')
{
	$kode=$_GET['kode_anggota'];
	$kodep=$_GET['kode_pinjam'];
	$jio=mysql_fetch_array(mysql_query("SELECT * from t_pinjam where kode_pinjam='$kodep' "));

	$qubah=mysql_query("SELECT * FROM t_anggota WHERE kode_anggota='$kode'");
	$data2=mysql_fetch_array($qubah);
	?>

	<div class="row mt">
		<div class="col-lg-12">
			<div class="form-panel" style="width:50%;">
				<h4 class="mb"><span class='glyphicon glyphicon-briefcase'></span> Transaksi Angsuran</h4>
				<form action="transaksi/proses_transaksi.php?pros=angsur" method="post" id="form" name="frmAdd">
					<div class="form-group">
						<label for="kode_anggota">Kode Anggota</label>
						<input type="text" class="form-control" name="kode_anggota" size="54" readonly value="<?php echo $data2['kode_anggota'];?>">
					</div>
					<div class="form-group">
						<label for="nama_anggota">Nama Anggota</label>
						<input type="text" class="form-control" name="nama_anggota" size="54" readonly value="<?php echo $data2['nama_anggota'];?>"/>
					</div>
					<div class="form-group">
						<label for="kode_pinjam">Kode Pinjam</label>
						<select name="kode_pinjam" class="form-control" id="kode_pinjam" onChange="show2(this.value)" class="required" title="Jenis Simpan harus diisi">
							<option value="<?php echo $_GET['kode_pinjam']; ?>"><?php echo $_GET['kode_pinjam']; ?></option>
						</select>
					</div>
					<div class="form-group">
						<label for="tgl_pinjam">Tanggal Pinjam</label>
						<input id="tgl_pinjam" class="form-control" value="<?php echo $jio['tgl_entri'];?>" type="text" name="tgl_pinjam" size="54" readonly />
					</div>
					<div class="form-group">
						<label for="besar_pinjaman">Besar Pinjam</label>
						<input type="text" class="form-control" name="besar_pinjam" value="<?php echo number_format($jio['besar_pinjam']);?>" id="besar_pinjam" value="" size="54" readonly  onFocus="startCalc();" onBlur="stopCalc();"/>
					</div>
					<div class="form-group">
						<label for="lama_angsur">Lama Angsur</label>
						<input type="text" class="form-control" name="lama_angsuran" value="<?php echo $jio['lama_angsuran'];?>" id="lama_angsuran" size="54" readonly  onFocus="startCalc();" onBlur="stopCalc();"/>
					</div>
					<div class="form-group">
						<label for="besar_angsur">Angsuran</label>
						<input type="text" class="form-control" name="besar_angsur" value="<?php echo $jio['besar_angsuran'];?>" id="besar_angsuran" size="54" readonly />
					</div>
					<div class="form-group">
						<label for="sisa_pinjam">Angsuran Ke</label>
						<input type="text" class="form-control" name="angsuran_ke" value="<?php echo $jio['sisa_angsuran']+1;?>" id="angsuran_ke" size="54" />
					</div>
					<?php 	
					$kk=mysql_fetch_array(mysql_query("SELECT * from t_pinjam where kode_pinjam='$kodep' and kode_anggota='$kode'"));$tempo=$kk['tgl_tempo'];$dat=date("Y-m-d");$besar=$kk['besar_angsuran'];
					if($dat>$tempo)
					{
						$go=round($telat=((abs(strtotime($dat)-strtotime($tempo)))/(60*60*24))); $denda=$besar * 1/10;?>
						<div class="form-group">
							<label for="sisa_pinjam">Denda</label>
							<input type="text" class="form-control" name="denda" value="<?php echo $denda; ?>" readonly>
						</div>
					<?php }
					else
						{ ?>
							<div class="form-group">

								<input type="hidden" class="form-control" name="denda" value="0">
							</div>
						<?php }
						?>
						<div class="form-group">
							<label for="user_entri">User Entri</label>
							<input type="text" class="form-control" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly>
						</div>
						<div class="form-group">
							<label for="tgl_entri">Tanggal Angsur</label>
							<input type="text" class="form-control" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly/>
						</div>
						<button class="btn btn-danger"><span class='glyphicon glyphicon-share'></span> Angsur</button>
					</form>

				</div>
			</div>
		</div>


		<?php
	}else if($aksi=='lunas')
	{
		$kode=$_GET['kode_anggota'];
		$kodep=$_GET['kode_pinjam'];
		$jio=mysql_fetch_array(mysql_query("SELECT * from t_pinjam where kode_pinjam='$kodep' "));
		$angsur=mysql_fetch_array(mysql_query("SELECT * from t_angsur where kode_pinjam='$kodep' "));
		$maxangsur=mysql_fetch_array(mysql_query("SELECT max(angsuran_ke) as angsuran_ke from t_angsur where kode_pinjam='$kodep' "));
		$qubah=mysql_query("SELECT * FROM t_anggota WHERE kode_anggota='$kode'");
		$data2=mysql_fetch_array($qubah);
		$kurangangsur= $jio['lama_angsuran'] - $jio['sisa_angsuran'];
		$angsuranpokok= $jio['angsur_tb'] * $kurangangsur;
		$bunga= $jio['bungaperbulan'] * $kurangangsur / 2;
		$totalangsur= $angsuranpokok + $bunga;
		$angsuranke = $jio['lama_angsuran'] - $maxangsur['angsuran_ke'];
		?>
		<div class="row mt">
			<div class="col-lg-12">
				<div class="form-panel" style="width:50%;">
					<h4 class="mb"><span class='glyphicon glyphicon-briefcase'></span> Transaksi Pelunasan</h4>
					<form action="transaksi/proses_transaksi.php?pros=lunas" method="post" id="form" name="frmAdd">
						<div class="form-group">
							<label for="kode_anggota">Kode Anggota</label>
							<input type="text" class="form-control" name="kode_anggota" size="54" readonly value="<?php echo $data2['kode_anggota'];?>">
						</div>
						<div class="form-group">
							<label for="nama_anggota">Nama Anggota</label>
							<input type="text" class="form-control" name="nama_anggota" size="54" readonly value="<?php echo $data2['nama_anggota'];?>"/>
						</div>
						<div class="form-group">
							<label for="kode_pinjam">Kode Pinjam</label>
							<select name="kode_pinjam" class="form-control" id="kode_pinjam" onChange="show2(this.value)" class="required" title="Jenis Simpan harus diisi">
								<option value="<?php echo $_GET['kode_pinjam']; ?>"><?php echo $_GET['kode_pinjam']; ?></option>
							</select>
						</div>
						<div class="form-group">
							<label for="tgl_pinjam">Tanggal Pinjam</label>
							<input id="tgl_pinjam" class="form-control" value="<?php echo $jio['tgl_entri'];?>" type="text" name="tgl_pinjam" size="54" readonly />
						</div>
						<div class="form-group">
							<label for="besar_pinjaman">Besar Pinjam</label>
							<input type="text" class="form-control" name="besar_pinjam" value="<?php echo $jio['besar_pinjam'];?>" id="besar_pinjam" value="" size="54" readonly  />
						</div>


						<div class="form-group">
							<label for="lama_angsur">Lama Angsur</label>
							<input type="text" class="form-control" name="lama_angsuran" value="<?php echo $jio['lama_angsuran'];?>" id="lama_angsuran" size="54" readonly />
						</div>

						<div class="form-group">
							<label for="kurangangsur">Kurang Angsuran</label>
							<input type="text" class="form-control" value="<?php echo $kurangangsur;?>" id="kurangangsur" size="54" readonly />
						</div>

						<div class="form-group">
							<label for="pokok">Angsuran Pokok</label>
							<input type="text" class="form-control"  value="<?php echo $angsuranpokok;?>" id="pokok" size="54" readonly />
						</div>

						<div class="form-group">
							<label for="bunga">Besar Bunga (-50%)</label>
							<input type="text" class="form-control" value="<?php echo $bunga;?>" id="bunga" value="" size="54" readonly />
						</div>

						<div class="form-group">
							<label for="besar_pinjaman">Total Angsur</label>
							<input type="text" class="form-control" name="besar_angsur" value="<?php echo $totalangsur;?>" id="besar_pinjam" value="" size="54" readonly />
						</div>

						<div class="form-group">
							<label for="sisa_pinjam">Angsuran Ke</label>
							<input type="text" class="form-control" disabled="disabled"  value="<?php echo $jio['sisa_angsuran']+1;?>" id="angsuran_ke" size="54" />
						</div>
						<?php 	
						$kk=mysql_fetch_array(mysql_query("SELECT * from t_pinjam where kode_pinjam='$kodep' and kode_anggota='$kode'"));$tempo=$kk['tgl_tempo'];$dat=date("Y-m-d");
						if($dat>$tempo)
						{
							$go=round($telat=((abs(strtotime($dat)-strtotime($tempo)))/(60*60*24))); $denda=$go * 1000;?>
							<div class="form-group">
								<label for="sisa_pinjam">Denda</label>
								<input type="text" class="form-control" name="denda" value="<?php echo $denda; ?>" readonly>
							</div>
						<?php }
						else
							{ ?>
								<div class="form-group">

									<input type="hidden" class="form-control" name="denda" value="0">
								</div>
							<?php }
							?>
							<div class="form-group">
								<label for="user_entri">User Entri</label>
								<input type="text" class="form-control" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly>
							</div>
							<div class="form-group">
								<label for="tgl_entri">Tanggal Angsur</label>
								<input type="text" class="form-control" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly/>
							</div>
							<button class="btn btn-danger"><span class='glyphicon glyphicon-share'></span> Lunasi</button>
						</form>

					</div>
				</div>
			</div>
		


		<?php
	}
	else if($aksi=='pinjamangsur')
		{ $kode=$_GET['kode_anggota']; $anggota=mysql_fetch_array(mysql_query("SELECT nama_anggota from t_anggota where kode_anggota='$kode'")); ?>
	<div class="row mt">
		<div class="col-lg-12">
			<div class="form-panel">
				<h4 class="mb"><span class='glyphicon glyphicon-briefcase'></span> Transaksi <?php echo $anggota['nama_anggota'];?>
				<?php

				$am=mysql_query("select*from t_pinjam where kode_anggota='$kode'");
				$jum=mysql_num_rows($am);
				echo'<kbd style="background-color:#d9534f;">'.$jum.'</kbd>';?>
				<span style="float:right;">
					<?php $df=mysql_fetch_array(mysql_query("SELECT * FROM t_pinjam where kode_anggota='$kode' order by kode_pinjam desc"));$op=mysql_num_rows($df);
					if($df['status']=='belum lunas')
					{
						echo '<a href="href=index.php?pilih=2.1&aksi=pinjam" disabled="disabled" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Tambah Pinjaman</a> ';
					}
					else if($df['status']=='lunas')
					{
						echo '<a href=index.php?pilih=2.1&aksi=pinjam&kode_anggota='.$kode.' class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Tambah Pinjaman</a> ';
					} 
					else if($op<=0)
					{
						echo '<a href=index.php?pilih=2.1&aksi=pinjam&kode_anggota='.$kode.' class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Tambah Pinjaman</a> ';
					}?>

				</span></h4>
				<form class="form-inline" role="form">
					<table class="table table-bordered table-striped table-condensed">
						<thead>
							<tr class="info">
								<th><a href="#">No</a></th>
								<th><a href="#">Kode Pinjam</a></th>
								<th><a href="#">Tangggal Pinjam</a></th>
								<!-- 									<th><a href="#">Jenis Pinjam</a></th> -->
								<th><a href="#">Jenis Jaminan</a></th>
								<th><a href="#">Besar Pinjam</a></th>
								<th><a href="#">Lama Angsuran</a></th>
								<th><a href="#">Jatuh Tempo</a></th>
								<th><a href="#">Status</a></th>
								<th><a href="#">Aksi</a></th>
							</tr>
						</thead>
						<tbody>
							<?php $sql=mysql_query("SELECT * from t_pinjam where kode_anggota='$kode' order by kode_pinjam desc");
							$nomer=1;
							while($data=mysql_fetch_array($sql))
							{
								$kd_a=$data['kode_anggota'];
								$kd_j=$data['kode_jenis_pinjam'];
								$jenis=mysql_fetch_array(mysql_query("SELECT nama_pinjaman from t_jenis_pinjam where kode_jenis_pinjam='$kd_j'"));
								echo'<tr>
								<td>'.$nomer.'</td>
								<td>'.$kd_p=$data['kode_pinjam'].'</td>
								<td>'.$data['tgl_entri'].'</td>
								<td>'.$data['jenis_jaminan'].'</td>
								<td>'.number_format($data['besar_pinjam']).'</td>
								<td>';echo $data['sisa_angsuran'].' Bulan Dari '.$data['lama_angsuran']; echo ' Bulan</td>
								<td>'.$data['tgl_tempo'].'</td>
								<td>'.$data['status'].'</td>
								<td align="center">
								<a class="btn btn-primary btn-xs" href=index.php?pilih=3.3&aksi=show&kode_anggota='.$data['kode_anggota'].'&kode_pinjam='.$data['kode_pinjam'].'>View</a> ';
								$lunas=mysql_fetch_array(mysql_query("SELECT  * from t_pinjam where kode_pinjam='$kd_p' "));
								$dfo=mysql_num_rows(mysql_query("SELECT *from t_angsur where kode_pinjam='$kd_p' and kode_anggota='$kode'"));
								if($dfo==$data['lama_angsuran'])
								{
									echo '<a class="btn btn-warning btn-xs" disabled="disabled">Angsur</a>';
								} elseif ($lunas['status'] == 'lunas') {
									echo '<a class="btn btn-warning btn-xs" disabled="disabled">Angsur</a>';
								}
								else
								{
									echo '<a class="btn btn-warning btn-xs" href=index.php?pilih=2.1&aksi=angsur&kode_anggota='.$data['kode_anggota'].'&kode_pinjam='.$data['kode_pinjam'].'>Angsur</a>';
								} echo " ";
								
								if ($lunas['status'] == 'lunas') {
									echo '<a class="btn btn-success btn-xs" disabled="disabled" href=index.php?pilih=2.1&aksi=lunas&kode_anggota='.$data['kode_anggota'].'&kode_pinjam='.$data['kode_pinjam'].'>Lunas</a>';
								} else {
									echo '<a class="btn btn-success btn-xs" href=index.php?pilih=2.1&aksi=lunas&kode_anggota='.$data['kode_anggota'].'&kode_pinjam='.$data['kode_pinjam'].'>Lunas</a>';
								}
								
								echo '</td>
								</tr>';
								$nomer++;}?> 
							</tbody>   
						</table></form></div></div></div>
					</div>
				<?php }
				elseif($aksi=='simpanananggota'){
					$kode=$_GET['kode_anggota'];
					$q=mysql_query("SELECT *from t_anggota where kode_anggota='$kode'");
					$ang=mysql_fetch_array($q); 
					?>

					<div class="row mt">
						<div class="col-lg-12">
							<div class="form-panel">
								<h4 class="mb"><span class='glyphicon glyphicon-briefcase'></span> Laporan Simpanan Anggota "<?php echo $ang['nama_anggota'];?>" 
									<?php
									$am=mysql_query("SELECT * FROM t_simpan where kode_anggota='$kode'");
									$jum=mysql_num_rows($am);
									echo'<kbd style="background-color:#d9534f;">'.$jum.'</kbd>';?>
									<span style="float:right;">
										<?php 
										$rino=mysql_query("SELECT*FROM t_jenis_simpan");
										$no=1;
										while($verida=mysql_fetch_array($rino))
										{ 
											if($verida['nama_simpanan']=='wajib')
											{
												$baru=mysql_fetch_array(mysql_query("SELECT *FROM t_simpan where kode_anggota='$kode' and jenis_simpan='wajib' order by kode_simpan desc "));$numrow=mysql_num_rows($baru);
												$data=$baru['tgl_mulai'];
												$now=date("Y-m-d");

												if($data==$now)
												{
													echo '<a class="btn btn-danger" href="index.php?pilih=2.1&aksi=simpan&kode_anggota='.$kode.'&kode_jenis_simpan='.$verida['kode_jenis_simpan'].'"><i class="fa fa-warning"></i> Wajib '.$data.'</a> ';
												}
												else if($data<$now)
												{
													echo '<a class="btn btn-danger" href="index.php?pilih=2.1&aksi=simpan&kode_anggota='.$kode.'&kode_jenis_simpan='.$verida['kode_jenis_simpan'].'"><i class="fa fa-warning"></i> Wajib '.$data.'</a> ';
												}
												else if($data>$now)
												{
													echo '<a class="btn btn-danger" disabled="disabled" href="index.php?pilih=2.1&aksi=simpan&kode_anggota='.$kode.'&kode_jenis_simpan='.$verida['kode_jenis_simpan'].'"><i class="fa fa-warning"></i> Wajib '.$data.'</a> ';
												}
											}
											else if($verida['nama_simpanan']=='sukarela')
											{
												echo '<a class="btn btn-success" href="index.php?pilih=2.1&aksi=simpan&kode_anggota='.$kode.'&kode_jenis_simpan='.$verida['kode_jenis_simpan'].'"><i class="glyphicon glyphicon-link"></i> Sukarela</a> ';
											}
											$no++;
										}
										?>
										<a href="laporan/print_show_simpanan.php?kode=<?php echo $ang['kode_anggota'];?>" target="_blank" class="btn btn-primary"><span class='glyphicon glyphicon-print'></span> Print</a> 
									</span></h4>
									<form class="form-inline" role="form">
										<table class="table table-bordered table-striped table-condensed">
											<thead>
												<tr class="info">
													<th rowspan="2"><a href="#">No</a></th>
													<th><a href="#">Tanggal Simpan</a></th>
													<th><a href="#">Nama Simpanan</a></th>
													<th><a href="#">Besar Simpanan</a></th>
												</tr>
											</thead>
											<?php
											$query = mysql_query("SELECT * from t_simpan where kode_anggota='$kode'order by kode_simpan desc");
											echo '<tbody>';	
											$no=1;
											while($data=mysql_fetch_array($query)){
												?>
												<tr>
													<td><?php echo $no?></td>
													<td><?php echo Tgl($data['tgl_entri']);?></td>
													<td><?php echo $data['jenis_simpan'];?></td>
													<td>Rp. <?php echo Rp($data['besar_simpanan']);?></td>
												</tr> 
												<?php
												$no++;}
												?>
												<tr  class="info"><td colspan="3" align="center">Total</td>
													<td>Rp. <?php $bu=mysql_fetch_array(mysql_query("SELECT sum(besar_simpanan) as besar_simpan from t_simpan where kode_anggota='$kode'")); echo Rp($bu['besar_simpan']);
													echo '</td>';?>
												</tr>
											</tbody>   
										</table>
									</div>
								</div>
							</div>
							<?php
						}
						?>



