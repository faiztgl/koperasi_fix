
<?php
include "../config/koneksi.php";
include "../fungsi/fungsi.php";
require('pdf/fpdf.php');
$potongadm=mysql_fetch_array(mysql_query("SELECT sum(potong_adm) as potongadm from t_pinjam")); 
$denda=mysql_fetch_array(mysql_query("SELECT sum(denda) as denda from t_angsur")); 
$bunga=mysql_fetch_array(mysql_query("SELECT sum(bungaperbulan) as bunga from t_pinjam")); 
$jmlsaham= mysql_fetch_array(mysql_query("SELECT sum(jml_saham) as jml_saham from t_anggota")); 
$lamaangsur= mysql_fetch_array(mysql_query("SELECT sum(lama_angsuran) as lamaangsur from t_pinjam"));
$total = $potongadm['potongadm'] + $denda['denda'] + ($bunga['bunga'] * $lamaangsur['lamaangsur']);
$biayaadm= ($total * 0.15);
$shupersaham= round(($total - $biayaadm)/ $jmlsaham['jml_saham']);
$pdf = new FPDF("L","cm","A4");


$pdf->SetMargins(2,1,1);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',11);
$pdf->MultiCell(19.5,0.5,'',0,'L'); 
$pdf->SetX(4);   
$pdf->SetFont('Arial','B',10);
$pdf->SetX(4);
$pdf->Image('../kopindo.png',2,1.3,2,1.6);
$pdf->SetX(4); 
$pdf->MultiCell(19.5,0.5,'  " Koperasi SMP Muhammadiyah 1 Surakarta "',0,'L');
$pdf->SetX(4);
$pdf->MultiCell(19.5,0.5,'  Alamat : Jl. Flores No. 1 Surakarta 57111',0,'L');
$pdf->SetX(4);
$pdf->MultiCell(19.5,0.5,'  Telp. 636273',0,'L');
$pdf->Line(1,3.1,28.5,3.1);
$pdf->SetLineWidth(0.1);      
$pdf->Line(1,3.2,28.5,3.2);   
$pdf->SetLineWidth(0);
$pdf->ln(1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(25.2,0.7,"Laporan Tutup Buku",0,10,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,0.7,"\nDi cetak pada : ".date("D-d/m/Y"),0,0,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(2, 0.8, 'NO', 1, 0, 'C');
$pdf->Cell(5, 0.8, 'Nama Pemegang Saham', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Jumlah Saham', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Modal Awal', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Simpanan Wajib', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'SHU', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Modal Akhir', 1, 1, 'C');
$pdf->SetFont('Arial','',10);
$query=mysql_query("SELECT * FROM t_anggota");
$no=1;
while($data=mysql_fetch_array($query))
{
	$pdf->Cell(2, 0.8, $no,1, 0, 'C');
	$pdf->Cell(5, 0.8, $data['nama_anggota'],1, 0, 'C');
	$pdf->Cell(3, 0.8, $data['jml_saham'], 1, 0,'C');
	$g=mysql_fetch_array(mysql_query("SELECT besar_simpanan from t_simpan where jenis_simpan='pokok'"));
	$pdf->Cell(4, 0.8, Rp($g['besar_simpanan']*$data['jml_saham']),1, 0,'C');
	$f=mysql_fetch_array(mysql_query("SELECT besar_simpanan from t_simpan where jenis_simpan='wajib'"));
	$pdf->Cell(4, 0.8, Rp($f['besar_simpanan']*12),1, 0,'C');
	$pdf->Cell(4, 0.8,Rp($shupersaham*$data['jml_saham']),1, 0,'C');
	$pdf->Cell(4, 0.8, Rp($f['besar_simpanan']*12+$g['besar_simpanan']*$data['jml_saham']),1, 1,'C');
	$no++;
}

$pdf->Output("Laporan Tutup Buku.pdf","I");
?>