<?php
if($_SESSION['level']=='admin')
	{ ?>
		<div class="row mt">
			<div class="col-lg-12">
				<div class="form-panel" style="border-left:5px solid#d9534f;border-right:5px solid#d9534f;">
					<h4 style="color:#d9534f;">Pilih Laporan Pinjam</h4>
					<p><a class="btn btn-primary" href="index.php?pilih=3.3&aksi=semua"><i class="glyphicon glyphicon-sd-video"></i> Semua Pinjaman</a> <!--<a class="btn btn-primary" href="index.php?pilih=3.3&aksi=jatuhtempo"><i class="glyphicon glyphicon-hd-video"></i> Jatuh Tempo</a> <a class="btn btn-primary" href="index.php?pilih=3.3&aksi=telat"><i class="glyphicon glyphicon-subtitles"></i> Telat</a></p>-->
				</div>
			</div>
			</div> <?php }
			else if($_SESSION['level']=='admin')
				{} ?>
			<?php 
			include "config/koneksi.php";
			include "fungsi/fungsi.php";

			$aksi=$_GET['aksi'];
			$kategori = ($kategori=$_POST['kategori'])?$kategori : $_GET['kategori'];
			$cari = ($cari = $_POST['input_cari'])? $cari: $_GET['input_cari'];
			?>

			<?php
	// **STYLE FORM
			?>
			<?php
			if(empty($aksi)){}
				else if($aksi=='semua')
				{
					?>
					<body>
						<div class="row">
							<div class="col-lg-12">
								<div class="form-panel">
									<h4 class="mb"><span class='glyphicon glyphicon-briefcase'></span> Laporan Pinjaman
										<?php
										$am=mysql_query("select*from t_pinjam");
										$jum=mysql_num_rows($am);
										echo'<kbd style="background-color:#d9534f;">'.$jum.'</kbd>';?>
										<span style="float:right;">
											<a href="laporan/print_pinjaman.php" target="_blank" class="btn btn-primary"><span class='glyphicon glyphicon-print'></span> Print</a> 
										</span></h4>
										<!--<?php print_r($jum); ?>-->
										<form class="form-inline" role="form">
											<table class="table table-bordered table-striped table-condensed">
												<thead>
													<tr class="info">
														<th width="40px"><a href="#">No</a></th>
														<th width="60px"><a href="#">Kode Pinjam</a></th>
														<th width="100px"><a href="#">Nama Anggota</a></th>
														<th width="100px"><a href="#">Tangggal Pinjam</a></th>
														<th width="100px"><a href="#">Tangggal Tempo</a></th>
														<th width="100px"><a href="#">Jaminan</a></th>
														<th width="300px"><a href="#">Keterangan</a></th>
														<!-- <th><a href="#">Jenis Pinjam</a></th> -->
														<th width="150px"><a href="#">Besar Pinjam</a></th>
														<th width="100px"><a href="#">Lama Angsuran</a></th>
														<th width="100px"><a href="#">Status</a></th>
														<th width="100px"><a href="#">Aksi</a></th>
													</tr>
												</thead>
												<tbody>
													<?php $sql=mysql_query("SELECT * from t_pinjam order by kode_pinjam asc");
													$nomer=1;
													while($data=mysql_fetch_array($sql))
													{
														$kd_a=$data['kode_anggota'];
														$anggota=mysql_fetch_array(mysql_query("SELECT nama_anggota from t_anggota where kode_anggota='$kd_a'"));
														$kd_j=$data['kode_jenis_pinjam'];
														$jenis=mysql_fetch_array(mysql_query("SELECT nama_pinjaman from t_jenis_pinjam where kode_jenis_pinjam='$kd_j'"));
														echo'<tr>
														<td>'.$nomer.'</td>
														<td>'.$kd_p=$data['kode_pinjam'].'</td>
														<td>'.$anggota['nama_anggota'].'</td>
														<td>'.$data['tgl_entri'].'</td>
														<td>'.$data['tgl_tempo'].'</td>
														<td>'.$data['jenis_jaminan'].'</td>
														<td>'.$data['detail_jamin'].'</td>
														<td>Rp. '.number_format($data['besar_pinjam']).'</td>
														<td>'.$data['lama_angsuran'].' Bulan</td>
														<td>';$jum=mysql_num_rows(mysql_query("SELECT*from t_angsur where kode_pinjam='$kd_p' and kode_anggota='$kd_a'"));$lama=mysql_fetch_array(mysql_query("SELECT lama_angsuran from t_pinjam where kode_pinjam='$kd_p' and kode_anggota='$kd_a'"));
														$lunas=mysql_fetch_array(mysql_query("SELECT  * from t_pinjam where kode_pinjam='$kd_p' "));
														if($lunas['status'] == 'lunas')
														{
															echo 'Lunas';
														}
														else
														{
															echo 'Belum Lunas';
														}

														echo'</td>
														<td align="center">
														<a class="btn btn-primary btn-xs" href=index.php?pilih=3.3&aksi=show&kode_anggota='.$data['kode_anggota'].'&kode_pinjam='.$data['kode_pinjam'].'><i class="glyphicon glyphicon-eye-open"></i> View</a>
														</td>
														</tr>';
														$nomer++;}?> 
													</tbody>   
												</table></form></div></div></div>
											</div>

											<?php 
										}elseif($aksi=='show'){
											$kode=$_GET['kode_anggota'];
											$kode_pinjam=$_GET['kode_pinjam'];
											$q=mysql_query("SELECT*from t_angsur where kode_pinjam='$kode_pinjam' AND kode_anggota='$kode' order by kode_angsur desc");

											?>
											<div class="row">
												<div class="col-lg-12">
													<div class="form-panel">
														<h4 class="mb"><span class='glyphicon glyphicon-briefcase'></span> Laporan Angsuran "<?php $angg=mysql_fetch_array(mysql_query("SELECT nama_anggota from t_anggota where kode_anggota='$kode'")); echo $angg['nama_anggota'];?>" 

															<span style="float:right;">
																<a href="laporan/print_angsuran.php?kode_pinjam=<?php echo $kode_pinjam;?>&kode_anggota=<?php echo $kode; ?>" target="_blank" class="btn btn-primary"><span class='glyphicon glyphicon-print'></span> Print</a> 
															</span></h4>
															<form class="form-inline" role="form">
																<table class="table table-bordered table-striped table-condensed">
																	<thead>
																		<tr class="info">
																			<th><a href="#">No</a></th>
																			<th><a href="#">Kode Angsuran</a></th>
																			<th><a href="#">Kode Pinjam</a></th>
																			<th><a href="#">Tanggal Angsuran</a></th>
																			<th><a href="#">Angsuran ke</a></th>
																			<th><a href="#">Besar Angsuran</a></th>
																			<th><a href="#">Denda</a></th>

																		</tr>
																	</thead><tbody>
																		<?php
																		$no=1;
																		while($ang=mysql_fetch_array($q)){
																			?>
																			<tr>
																				<td><?php echo $no;?></td>
																				<td><?php echo $ang['kode_angsur'];?></td>
																				<td><?php echo $l=$ang['kode_pinjam'];?></td>
																				<td><?php echo $ang['tgl_entri'];?></td>
																				<td><?php echo $ang['angsuran_ke'];?></td>
																				<td>Rp. <?php echo Rp($ang['besar_angsuran']);?></td>
																				<td>Rp. <?php echo Rp($ang['denda']);?></td>
																			</tr>
																			<?php
																			$no++;}
																			?>
																		</tbody></table></form></div></div></div>

																		<?php
																	}
																	else if($aksi=='telat')
																	{
																		?>
																		<body>
																			<div class="row">
																				<div class="col-lg-12">
																					<div class="form-panel">
																						<h4 class="mb"><span class='glyphicon glyphicon-briefcase'></span> Laporan Telat
																							<span style="float:right;">
																								<a href="laporan/print_telat.php" target="_blank" class="btn btn-primary"><span class='glyphicon glyphicon-print'></span> Print</a> 
																							</span></h4>
																							<form class="form-inline" role="form">
																								<table class="table table-bordered table-striped table-condensed">
																									<thead>
																										<tr class="info">
																											<th><a href="#">No</a></th>
																											<th><a href="#">Kode Pinjam</a></th>
																											<th><a href="#">Nama Anggota</a></th>
																											<th><a href="#">Tangggal Pinjam</a></th>
																											<th><a href="#">Tanggal Tempo</a></th>
																											<th><a href="#">Telat</a></th>
																											<th><a href="#">Denda</a></th>
																											<th><a href="#">Status</a></th>
																											<th><a href="#">Aksi</a></th>
																										</tr>
																									</thead>
																									<tbody>
																										<?php $sql=mysql_query("SELECT * from t_pinjam where status='belum lunas' order by kode_pinjam desc");
																										$nomer=1;
																										while($data=mysql_fetch_array($sql))
																										{
																											$a=$data['tgl_tempo'];$dat=date("Y-m-d");
																											if($dat>$a)
																											{
																												$go=round($telat=((abs(strtotime($dat)-strtotime($a)))/(60*60*24))); $denda=$go * 1000;
																												$kd_a=$data['kode_anggota'];
																												$anggota=mysql_fetch_array(mysql_query("SELECT nama_anggota from t_anggota where kode_anggota='$kd_a'"));
																												$kd_j=$data['kode_jenis_pinjam'];
																												$jenis=mysql_fetch_array(mysql_query("SELECT nama_pinjaman from t_jenis_pinjam where kode_jenis_pinjam='$kd_j'"));
																												echo'<tr>
																												<td>'.$nomer.'</td>
																												<td>'.$kd_p=$data['kode_pinjam'].'</td>
																												<td>'.$anggota['nama_anggota'].'</td>
																												<td>'.$data['tgl_entri'].'</td>
																												<td>'.$a.'</td>
																												<td>'.$go.' Hari</td>
																												<td>Rp. '.$denda.'</td>
																												<td>';$jum=mysql_num_rows(mysql_query("SELECT*from t_angsur where kode_pinjam='$kd_p' and kode_anggota='$kd_a'"));$lama=mysql_fetch_array(mysql_query("SELECT lama_angsuran from t_pinjam where kode_pinjam='$kd_p' and kode_anggota='$kd_a'"));
																												if($jum==$lama['lama_angsuran'])
																												{
																													echo 'Lunas';
																												}
																												else
																												{
																													echo 'Belum Lunas';
																												}

																												echo'</td>
																												<td align="center">
																												<a class="btn btn-primary btn-xs" href=index.php?pilih=3.3&aksi=show&kode_anggota='.$data['kode_anggota'].'&kode_pinjam='.$data['kode_pinjam'].'><i class="glyphicon glyphicon-eye-open"></i> View</a>
																												</td>
																												</tr>';
																											}
																											else
																											{

																											}
																											$nomer++;}?> 
																										</tbody>   
																									</table></form></div></div></div>
																								</div>

																								<?php 
																							}
																							else if($aksi=='jatuhtempo')
																							{
																								?>
																								<body>
																									<div class="row">
																										<div class="col-lg-12">
																											<div class="form-panel">
																												<h4 class="mb"><span class='glyphicon glyphicon-briefcase'></span> Laporan Jatuh Tempo
																													<span style="float:right;">
																														<a href="laporan/print_jatuh_tempo.php" target="_blank" class="btn btn-primary"><span class='glyphicon glyphicon-print'></span> Print</a> 
																													</span></h4>
																													<form class="form-inline" role="form">
																														<table class="table table-bordered table-striped table-condensed">
																															<thead>
																																<tr class="info">
																																	<th><a href="#">No</a></th>
																																	<th><a href="#">Kode Pinjam</a></th>
																																	<th><a href="#">Nama Anggota</a></th>
																																	<th><a href="#">Tangggal Pinjam</a></th>
																																	<th><a href="#">Tanggal Tempo</a></th>
																																	<th><a href="#">Besar Pinjam</a></th>
																																	<th><a href="#">Lama Angsuran</a></th>
																																	<th><a href="#">Status</a></th>
																																	<th><a href="#">Aksi</a></th>
																																</tr>
																															</thead>
																															<tbody>
																																<?php $sql=mysql_query("SELECT * from t_pinjam where status='belum lunas'");
																																$nomer=1;
																																while($data=mysql_fetch_array($sql))
																																{
																																	$a=$data['tgl_tempo'];$dat=date("Y-m-d");
																																	if($a==$dat)
																																	{
																																		$kd_a=$data['kode_anggota'];
																																		$anggota=mysql_fetch_array(mysql_query("SELECT nama_anggota from t_anggota where kode_anggota='$kd_a'"));
																																		$kd_j=$data['kode_jenis_pinjam'];
																																		$jenis=mysql_fetch_array(mysql_query("SELECT nama_pinjaman from t_jenis_pinjam where kode_jenis_pinjam='$kd_j'"));
																																		echo'<tr>
																																		<td>'.$nomer.'</td>
																																		<td>'.$kd_p=$data['kode_pinjam'].'</td>
																																		<td>'.$anggota['nama_anggota'].'</td>
																																		<td>'.$data['tgl_entri'].'</td>
																																		<td>'.$a.'</td>
																																		<td>Rp '.number_format($data['besar_pinjam']).'</td>
																																		<td>'.$data['lama_angsuran'].' Bulan</td>
																																		<td>';$jum=mysql_num_rows(mysql_query("SELECT*from t_angsur where kode_pinjam='$kd_p' and kode_anggota='$kd_a'"));$lama=mysql_fetch_array(mysql_query("SELECT lama_angsuran from t_pinjam where kode_pinjam='$kd_p' and kode_anggota='$kd_a'"));
																																		if($jum==$lama['lama_angsuran'])
																																		{
																																			echo 'Lunas';
																																		}
																																		else
																																		{
																																			echo 'Belum Lunas';
																																		}

																																		echo'</td>
																																		<td align="center">
																																		<a class="btn btn-primary btn-xs" href=index.php?pilih=3.3&aksi=show&kode_anggota='.$data['kode_anggota'].'&kode_pinjam='.$data['kode_pinjam'].'><i class="glyphicon glyphicon-eye-open"></i> View</a>
																																		</td>
																																		</tr>';
																																	}
																																	else
																																	{

																																	}
																																	$nomer++;}?> 
																																</tbody>   
																															</table></form></div></div></div>
																														</div>

																														<?php 
																													}
																													?>
																												</body>