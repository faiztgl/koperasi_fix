<?php 
include "config/koneksi.php";
include "fungsi/fungsi.php";

$aksi=$_GET['aksi'];

?>

</head>

<?php
if(empty($aksi)){
  ?>
  <body>  
    <div class="row mt">
      <div class="form-panel">
        <h4 class="mb"><span class='glyphicon glyphicon-briefcase'></span> Laporan SHU <span style="float:right;">

        </span>
      </h4>
      <?php $potongadm=mysql_fetch_array(mysql_query("SELECT sum(potong_adm) as potongadm from t_pinjam")); ?>
      <?php $denda=mysql_fetch_array(mysql_query("SELECT sum(denda) as denda from t_angsur")); ?>
      <?php $bunga=mysql_fetch_array(mysql_query("SELECT sum(bungaperbulan) as bunga from t_pinjam")); ?>
      <?php $jmlsaham= mysql_fetch_array(mysql_query("SELECT sum(jml_saham) as jml_saham from t_anggota")); ?>
      <?php $lamaangsur= mysql_fetch_array(mysql_query("SELECT sum(lama_angsuran) as lamaangsur from t_pinjam")); ?>
      <?php $total = $potongadm['potongadm'] + $denda['denda'] + ($bunga['bunga'] * $lamaangsur['lamaangsur']) ?>
      <?php $biayaadm= $total * 0.15 ?>
      <?php $shupersaham= round(($total - $biayaadm)/ $jmlsaham['jml_saham']) ?>
    </div>
    <div class="col-lg-4 col-xs-10">
      <!--  -->
      <div class="small-box">
        <div class="panel" style="border: 2px solid#5bc0de; ">
          <div class="panel-heading"  style="background-color:#5bc0de; color:#fff;"><h5>Biaya Admin + Bunga + Denda </h5></div>
          <div class="panel-body">
           <span style="font-size:20px;"><?php echo 'Rp. '.number_format($total);//.' '.$tabung['tabung'].' '.$angsur['angsuran'].' '.$denda['denda']; ?></span>
         </div>
       </div>
     </div>
   </div>
   <div class="col-lg-4 col-xs-10">
    <!--  -->
    <div class="small-box">
      <div class="panel" style="border: 2px solid#5bc0de; ">
        <div class="panel-heading"  style="background-color:#5bc0de; color:#fff;"><h5>Potong Admin 15% </h5></div>
        <div class="panel-body">
         <span style="font-size:20px;"><?php echo 'Rp. '.number_format($biayaadm);//.' '.$tabung['tabung'].' '.$angsur['angsuran'].' '.$denda['denda']; ?></span>
       </div>
     </div>
   </div>
 </div>
 <div class="col-lg-4 col-xs-10">
  <!--  -->
  <div class="small-box">
    <div class="panel" style="border: 2px solid#5bc0de; ">
      <div class="panel-heading"  style="background-color:#5bc0de; color:#fff;"><h5>SHU Persaham </h5></div>
      <div class="panel-body">
       <span style="font-size:20px;"><?php echo 'Rp. '.number_format($shupersaham);//.' '.$tabung['tabung'].' '.$angsur['angsuran'].' '.$denda['denda']; ?></span>
     </div>
   </div>
 </div>
</div>
</div><!-- /row -->


<?php
}
?>



