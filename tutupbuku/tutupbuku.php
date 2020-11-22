<?php 
include "config/koneksi.php";
include "fungsi/fungsi.php";

$aksi=$_GET['aksi'];
$cari = ($cari = $_POST['input_cari'])? $cari: $_GET['input_cari'];
?>

<head>
  <script src="jquery.js"></script>
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
          <h4 class="mb"><span class='glyphicon glyphicon-briefcase'></span> Tutup Buku <span style="float:right;">
           <a href="laporan/print_tutupbuku.php" target="_blank" class="btn btn-primary"><span class='glyphicon glyphicon-print'></span> Print</a> 
            <input type="text" id="cari" style="width:230px;height:30px;font-size:15px;" placeholder=" cari disini...">
          </span>
		  <!-- <span style="float:right;">
		  <a href="laporan/print_simpanan.php" target="_blank" class="btn btn-primary"><span class='glyphicon glyphicon-print'></span> Print</a>
		  </span> -->
        </h4>
	 
        <?php $potongadm=mysql_fetch_array(mysql_query("SELECT sum(potong_adm) as potongadm from t_pinjam")); ?>
        <?php $denda=mysql_fetch_array(mysql_query("SELECT sum(denda) as denda from t_angsur")); ?>
        <?php $bunga=mysql_fetch_array(mysql_query("SELECT sum(bungaperbulan) as bunga from t_pinjam")); ?>
        <?php $jmlsaham= mysql_fetch_array(mysql_query("SELECT sum(jml_saham) as jml_saham from t_anggota")); ?>
        <?php $lamaangsur= mysql_fetch_array(mysql_query("SELECT sum(lama_angsuran) as lamaangsur from t_pinjam")); ?>
        <?php $total = $potongadm['potongadm'] + $denda['denda'] + ($bunga['bunga'] * $lamaangsur['lamaangsur']) ?>
        <?php $biayaadm= $total * 0.15 ?>
        <?php $shupersaham= round(($total - $biayaadm)/ $jmlsaham['jml_saham']) ?>
        <form class="form-inline" role="form">
          <table class="table table-bordered table-striped table-condensed">
            <thead>
              <tr class="info">
               <th><a href="#">No</a></th>
               <th><a href="#">Nama Pemegang Saham</a></th>
               <th><a href="#">Jumlah Saham</a></th>
               <th><a href="#">Modal Awal</a></th>
               <th><a href="#">Simpanan Wajib</a></th>
               <th><a href="#">SHU</a></th>
			   <th><a href="#">Modal Akhir</a></th>
             </tr> 
           </thead>
            <tbody id="fbody">
           <?php $query= mysql_query("SELECT * FROM t_anggota") ?>
           <?php $i=1; ?>
           <?php while ($data=mysql_fetch_array($query)) : ?>
              <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $data['nama_anggota'] ?></td>
                <td><?php echo $data['jml_saham'] ?></td>
                <?php $p=mysql_fetch_array(mysql_query("SELECT besar_simpanan from t_jenis_simpan where nama_simpanan='pokok'"));?>
                <td><?php echo Rp($p['besar_simpanan']*$data['jml_saham']) ?></td>
                <?php $f=mysql_fetch_array(mysql_query("SELECT besar_simpanan from t_jenis_simpan where nama_simpanan='wajib'"));?>
                <td> <?php echo Rp($f['besar_simpanan']*12) ?></td>
                <td><?php echo Rp($shupersaham*$data['jml_saham']); ?></td>
				<td><?php echo Rp($f['besar_simpanan']*12+$p['besar_simpanan']*$data['jml_saham']); ?></td>
              </tr>
            <?php endwhile ?>
          </tbody>
        </table>
      </div>
    </div><!-- /col-lg-12 -->
  </div><!-- /row -->


  <?php
}
?>



