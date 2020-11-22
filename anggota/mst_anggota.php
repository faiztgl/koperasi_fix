<?php 
include "config/koneksi.php";
include "fungsi/fungsi.php";

$aksi=$_GET['aksi'];
$kategori = ($kategori=$_POST['kategori'])?$kategori : $_GET['kategori'];
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
       <div class="form-panel" style="border-left:5px solid#d9534f;border-right:5px solid#d9534f;">
        <p><a class="btn btn-primary" href="index.php?pilih=1.2&aksi=aktif"><i class="glyphicon glyphicon-sd-video"></i> Aktif</a> <a class="btn btn-primary" href="index.php?pilih=1.2&aksi=keluar"><i class="glyphicon glyphicon-subtitles"></i> Nonaktif</a> <a href="?pilih=1.2&aksi=tambah&kode_tabungan=<?php echo $data['kode_tabungan'];?>" class="btn btn-primary"><span class='glyphicon glyphicon-plus'></span> Tambah Anggota</a> 
        </p>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="form-panel">
        <h4 class="mb"><span class='glyphicon glyphicon-briefcase'></span> Data Anggota
          <?php
          $am=mysql_query("SELECT *from t_anggota");
          $jum=mysql_num_rows($am);
          echo'<kbd style="background-color:#d9534f;">'.$jum.'</kbd>';?> 
          <span style="float:right;">
            <input type="text" id="cari" style="width:230px;height:30px;font-size:15px;" placeholder=" cari disini...">
          </span></h4>
          <form class="form-inline" role="form">
            <table class="table table-bordered table-striped table-condensed">
              <thead>
                <tr class="info">
                 <th><a href="#">No</a></th>
                 <th><a href="#">Kode Anggota</a></th>
                 <th><a href="#">Kode Tabungan</a></th>
                 <th><a href="#">Nama Anggota</a></th>
                 <th><a href="#">Jumlah Saham</a></th>
                 <th><a href="#">TTL</a></th>
                 <th><a href="#">Pekerjaan</a></th>
                 <th><a href="#">Tanggal Masuk</a></th>
                 <th><a href="#">Status</a></th> 
               </tr>
             </thead>
             <tbody id="fbody">
              <?php
              $query=mysql_query("SELECT * FROM t_anggota");
              $no=1;
              while($data=mysql_fetch_array($query)){
               ?>
               <tr>
                 <td><?php echo $no;?></td>
                 <td><?php echo $data['kode_anggota'];?></td>
                 <td><?php echo $data['kode_tabungan'];?></td>
                 <td><?php echo $data['nama_anggota'];?></td>
                 <td><?php echo $data['jml_saham'];?></td>
                 <td><?php echo $data['tempat_lahir'];?>, <?php echo $data['tgl_lahir'];?></td>
                 <td><?php echo $data['pekerjaan'];?></td>
                 <td><?php echo $data['tgl_masuk'];?></td>
                 <td><?php echo $data['status'];?></td>                
               </tr>   
               <?php
						$no++;} //tutup while
           ?>
         </tbody> </table>
       </div>
     </div><!-- /col-lg-12 -->
   </div><!-- /row -->
   

   <?php
 }else if($aksi=='tambah'){
  $query=mysql_query("SELECT * FROM t_jenis_simpan WHERE nama_simpanan='pokok'");
  $querytabungan=mysql_query("SELECT * FROM t_anggota");
  $data=mysql_fetch_array($query);
  $datatabungan=mysql_fetch_array($querytabungan);
		//echo $query;
  ?>

  <div class="row mt">
    <div class="col-lg-12">
      <div class="form-panel" style="width:50%;">
        <h4 class="mb"><span class='glyphicon glyphicon-briefcase'></span> Tambah Data Anggota
        </h4>
        <form action="anggota/proses_anggota.php?pros=tambah" method="post" id="form" role="form" enctype="multipart/form-data">
          <div class="form-group">
            <label>Kode Anggota</label>
            <input type="hidden" name="kode_tabungan" value="<?php if ($datatabungan['kode_tabungan'] == null) {
             echo 1;
           } else echo $datatabungan['kode_tabungan'] + 1; ?>">
           <input type="text" name="kode_anggota" class="form-control" size="54px" value="<?php echo nomer("A","kode_anggota","t_anggota	");?>" readonly title="Kode harus diisi"/>
         </div>
         <div class="form-group">
          <label>Tanggal Masuk</label>
          <input type="text" name="tgl_masuk" class="form-control" value="<?php echo date("Y-m-d");?>">
        </div>

        <div class="form-group">
          <label>Jumlah Saham</label>
          <input type="text" name="jml_saham" class="form-control" size="54" id="jml_saham">
        </div>

        <div class="form-group">
          <label>Simpanan Pokok</label>
          <input type="text" name="besar_tabungan" class="form-control" size="54" id="simpanan_pokok" class="required" readonly="">
        </div>
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="nama_anggota" class="form-control" size="54" class="required" title="Nama harus diisi"/>
        </div>
        <div class="form-group">
          <label>Jenis Kelamin</label>
          <input type="radio" name="jenis_kelamin" value="Laki-laki" class="required" title="Jenis Kelamin harus diisi"/> Laki-laki
          <input type="radio" name="jenis_kelamin" value="Perempuan" class="required" title="Jenis Kelamin harus diisi"/> Perempuan
        </div>
        <div class="form-group">
          <label>Tempat Lahir</label>
          <input type="text" name="tmp_lahir" size="54" class="form-control"/>
        </div>
        <div class="form-group">
          <label>Tanggal Lahir</label>
          <input type="date" class="form-control" name="tgl_lahir" class="required" title="Tanggal Lahir harus diisi">
        </div>
        <div class="form-group">
          <label>Alamat Anggota</label>
          <input type="text" name="alamat_anggota" class="form-control" id="alamat_anggota" rows="5" cols="41" class="required" title="Alamat harus diisi"/>
        </div>
        <div class="form-group">
          <label>Telepon</label>
          <input type="text" name="telp" size="54" class="form-control"/>
        </div>
        <div class="form-group">
          <label>Pekerjaan</label>
          <input type="text" name="pekerjaan" size="54" class="form-control"/>
        </div>
        <div class="form-group">
          <label>User Entri</label>
          <input type="text"  class="form-control" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly >
        </div><div class="form-group">
          <label>Tanggal Entri</label>
          <input type="text" name="tgl_entri" class="form-control" size="54" value="<?php echo date("Y-m-d");?>" readonly/>
        </div>
        <button class="btn btn-danger"><span class='glyphicon glyphicon-ok'></span> Simpan</button>
      </form>
    </div></div></div>


    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript">
	var simpanan_pokok = document.getElementById('simpanan_pokok');
		simpanan_pokok.addEventListener('keyup', function(e){
			// tambahkan 'Rp.' pada saat form di ketik
			// gunakan fungsi formatsimpanan_pokok() untuk mengubah angka yang di ketik menjadi format angka
			simpanan_pokok.value = formatsimpanan_pokok(this.value);
		});
 
		/* Fungsi formatsimpanan_pokok */
		function formatsimpanan_pokok(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			simpanan_pokok     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				simpanan_pokok += separator + ribuan.join('.');
			}
 
			simpanan_pokok = split[1] != undefined ? simpanan_pokok + ',' + split[1] : simpanan_pokok;
			return prefix == undefined ? simpanan_pokok : (simpanan_pokok ? + simpanan_pokok : '');
		}
      $(document).ready(function(){
        $("#jml_saham").keyup(function(){ 
          var jml_saham  = parseInt($("#jml_saham").val());
          var simpanan_pokok = jml_saham * 1263390;
          $("#simpanan_pokok").val(simpanan_pokok); 
		  $("#simpanan_pokok").val(formatsimpanan_pokok($("#simpanan_pokok").val()));
        }); 
      }); 
    </script> 

    <?php
  }else if($aksi=='ubah'){
    $kode=$_GET['kode_anggota'];
    $qubah=mysql_query("SELECT * FROM t_anggota WHERE kode_anggota='$kode'");
    $data2=mysql_fetch_array($qubah);
    ?>
    <div class="row mt">
      <div class="col-lg-12">
        <div class="form-panel" style="width:50%;">
          <h4 class="mb"><span class='glyphicon glyphicon-briefcase'></span>Ubah Data Anggota
          </h4>
          <form action="anggota/edit_anggota.php" method="get" id="form" role="form" enctype="multipart/form-data">
            <div class="form-group">
              <label>Kode Anggota</label>
              <input type="text" name="kode_anggota" class="form-control" size="54px" value="<?php echo $data2['kode_anggota'];?>"readonly/>
            </div>
            <div class="form-group">
              <label>Tanggal Masuk</label>
              <input type="date" value="<?php echo $data2['tgl_masuk'];?>" class="form-control" name="tgl_masuk" >
            </div>
            <div class="form-group">
              <label>Nama Lengkap</label>
              <input type="text" name="nama_anggota" class="form-control" size="54" class="required" value="<?php echo $data2['nama_anggota'];?>"/>
            </div>
            <div class="form-group">
              <label>Jenis Kelamin</label>
              <?php	
              if ($data2['jenis_kelamin'] == "Laki-laki"){
               echo "<input type='radio' name='jenis_kelamin' value='Laki-laki' checked>Laki-laki <input type='radio' name='jenis_kelamin' value='Perempuan'>Perempuan";
             }else if ($data2['jenis_kelamin'] == "Perempuan"){
               echo "<input type='radio' name='jenis_kelamin' value='Laki-laki'>Laki-laki <input type='radio' name='jenis_kelamin' value='Perempuan' checked>Perempuan";
             }
             ?>	
           </div>
           <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" class="form-control" value="<?php echo $data2['tempat_lahir'];?>" name="tmp_lahir"/>
          </div>
          <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" class="form-control" value="<?php echo $data2['tgl_lahir'];?>">
          </div>
          <div class="form-group">
            <label>Alamat Anggota</label>
            <input type="text" name="alamat_anggota" value="<?php echo $data2['alamat_anggota'];?>" class="form-control"/>
          </div>
          <div class="form-group">
            <label>Telepon</label>
            <input type="text" class="form-control" value="<?php echo $data2['telp'];?>" name="telp"/>
          </div>
          <div class="form-group">
            <label>Pekerjaan</label>
            <input type="text" name="pekerjaan" size="54" class="form-control" value="<?php echo $data2['pekerjaan'];?>"/>
          </div>
          <div class="form-group">
            <label>Tanggal Entri</label>
            <input type="date" name="tgl_entri" class="form-control" value="<?php echo date("Y-m-d");?>" readonly>
          </div>
          <button class="btn btn-danger"><span class='glyphicon glyphicon-pencil'></span> Edit</button>
        </form>
      </div></div></div>
      <?php
    } else if($aksi=='aktif'){
      ?>
      <div class="row mt">
       <div class="col-lg-12">
         <div class="form-panel" style="border-left:5px solid#d9534f;border-right:5px solid#d9534f;">
          <p><a class="btn btn-primary" href="index.php?pilih=1.2&aksi=aktif"><i class="glyphicon glyphicon-sd-video"></i> Aktif</a> <a class="btn btn-primary" href="index.php?pilih=1.2&aksi=keluar"><i class="glyphicon glyphicon-subtitles"></i> Nonaktif</a> <a href="?pilih=1.2&aksi=tambah" class="btn btn-primary"><span class='glyphicon glyphicon-plus'></span> Tambah Anggota</a> 
          </p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="form-panel">
          <h4 class="mb"><span class='glyphicon glyphicon-briefcase'></span> Data Anggota Aktif
            <?php
            $am=mysql_query("SELECT *from t_anggota where status='aktif'");
            $jum=mysql_num_rows($am);
            echo'<kbd style="background-color:#d9534f;">'.$jum.'</kbd>';?>
            <span style="float:right;">
              <input type="text" id="cari" style="width:230px;height:30px;font-size:15px;" placeholder=" cari disini...">
              
            </span></h4>
            <form class="form-inline" role="form">
              <table class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr class="info">
                   <th><a href="#">No</a></th>
                   <th><a href="#">Kode Anggota</a></th>
                   <th><a href="#">Nama Anggota</a></th>
                   <th><a href="#">TTL</a></th>
                   <th><a href="#">Pekerjaan</a></th>
                   <th><a href="#">Tanggal Masuk</a></th>
                   <th><a href="#">Status</a></th>        
                   <th colspan="3"><a>Aksi</a></th>
                 </tr>
               </thead>
               <tbody id="fbody">
                <?php
                $query=mysql_query("SELECT * FROM t_anggota where status='aktif'");
                $no=1;
                while($data=mysql_fetch_array($query)){
                  ?>
                  <tr>
                    <td><?php echo $no;?></td>
                    <td><?php echo $data['kode_anggota'];?></td>
                    <td><?php echo $data['nama_anggota'];?></td>
                    <td><?php echo $data['tempat_lahir'];?>, <?php echo $data['tgl_lahir'];?></td>
                    <td><?php echo $data['pekerjaan'];?></td>
                    <td><?php echo $data['tgl_masuk'];?></td>
                    <td><?php echo $data['status'];?></td>
                    <td align="center">
                      <a class="btn btn-success btn-xs" href="index.php?pilih=1.2&aksi=ubah&kode_anggota=<?php echo $data['kode_anggota'];?>"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                      <script type="text/javascript">
                        function hapus(){
                          var msg = confirm("Jika anda menghapus data ini ,seluruh transaksi data ini juga akan dihapus. Anda Yakin ?");
                          if(msg==true){
                            window.location="anggota/proses_anggota.php?pros=keluar&kode_anggota=<?php echo $data['kode_anggota'];?>";  
                          }
                          else{
                            
                          }
                        }
                      </script>
                      <a class="btn btn-primary btn-xs" href="anggota/proses_anggota.php?pros=keluar&kode_anggota=<?php echo $data['kode_anggota'];?>"><i class="glyphicon glyphicon-off"></i> Keluar</a>
                      <a class="btn btn-danger btn-xs" href="anggota/proses_anggota.php?pros=hapus&kode_anggota=<?php echo $data['kode_anggota'];?>"><i class="glyphicon glyphicon-trash"></i> Hapus</a>
                    </td>
                  </tr>   
                  <?php
            $no++;} //tutup while
            ?>
          </tbody> </table>
        </div>
      </div><!-- /col-lg-12 -->
    </div><!-- /row -->
    

  <?php } else if($aksi=='keluar'){
    ?>
    <div class="row mt">
     <div class="col-lg-12">
       <div class="form-panel" style="border-left:5px solid#d9534f;border-right:5px solid#d9534f;">
        <p><a class="btn btn-primary" href="index.php?pilih=1.2&aksi=aktif"><i class="glyphicon glyphicon-sd-video"></i> Aktif</a> <a class="btn btn-primary" href="index.php?pilih=1.2&aksi=keluar"><i class="glyphicon glyphicon-subtitles"></i> Nonaktif</a> <a href="?pilih=1.2&aksi=tambah" class="btn btn-primary"><span class='glyphicon glyphicon-plus'></span> Tambah Anggota</a> 
        </p>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="form-panel">
        <h4 class="mb"><span class='glyphicon glyphicon-briefcase'></span> Data Anggota Keluar
          <?php
          $am=mysql_query("SELECT *from t_anggota where status='keluar'");
          $jum=mysql_num_rows($am);
          echo'<kbd style="background-color:#d9534f;">'.$jum.'</kbd>';?>
          <span style="float:right;">
            <input type="text" id="cari" style="width:230px;height:30px;font-size:15px;" placeholder=" cari disini...">
            
          </span></h4>
          <form class="form-inline" role="form">
            <table class="table table-bordered table-striped table-condensed">
              <thead>
                <tr class="info">
                 <th><a href="#">No</a></th>
                 <th><a href="#">Kode Anggota</a></th>
                 <th><a href="#">Nama Anggota</a></th>
                 <th><a href="#">TTL</a></th>
                 <th><a href="#">Pekerjaan</a></th>
                 <th><a href="#">Tanggal Masuk</a></th>
                 <th><a href="#">Status</a></th>
                 
                 <th colspan="3"><a>Aksi</a></th>
               </tr>
             </thead>
             <tbody id="fbody">
              <?php
              $query=mysql_query("SELECT * FROM t_anggota where status='keluar'");
              $no=1;
              while($data=mysql_fetch_array($query)){
                ?>
                <tr>
                  <td><?php echo $no;?></td>
                  <td><?php echo $data['kode_anggota'];?></td>
                  <td><?php echo $data['nama_anggota'];?></td>
                  <td><?php echo $data['tempat_lahir'];?>, <?php echo $data['tgl_lahir'];?></td>
                  <td><?php echo $data['pekerjaan'];?></td>
                  <td><?php echo $data['tgl_masuk'];?></td>
                  <td><?php echo $data['status'];?></td>
                  <td align="center">
                    <script type="text/javascript">
                      function hapus(){
                        var msg = confirm("Jika anda menghapus data ini ,seluruh transaksi data ini juga akan dihapus. Anda Yakin ?");
                        if(msg==true){
                          window.location="anggota/proses_anggota.php?pros=keluar&kode_anggota=<?php echo $data['kode_anggota'];?>";  
                        }
                        else{
                          
                        }
                      }
                    </script>
                    <a class="btn btn-danger btn-xs" href="anggota/proses_anggota.php?pros=hapus&kode_anggota=<?php echo $data['kode_anggota'];?>"><i class="glyphicon glyphicon-off"></i> Hapus</a>
                  </td>
                </tr>   
                <?php
            $no++;} //tutup while
            ?>
          </tbody> </table>
        </div>
      </div><!-- /col-lg-12 -->
    </div><!-- /row -->
    

    <?php } ?>