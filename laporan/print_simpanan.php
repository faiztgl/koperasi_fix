
<?php
include "../config/koneksi.php";

require('pdf/fpdf.php');
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
$pdf->Cell(25.2,0.7,"Laporan Seluruh Simpanan",0,10,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,0.7,"\nDi cetak pada : ".date("D-d/m/Y"),0,0,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(3, 0.8, 'NO', 1, 0, 'C');
$pdf->Cell(5, 0.8, 'Nama Anggota', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Pokok', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Wajib', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Sukarela', 1, 0, 'C');
$pdf->Cell(5, 0.8, 'Total Simpanan', 1, 1, 'C');
$pdf->SetFont('Arial','',10);
	$query = mysql_query("SELECT * from t_anggota");
	$no=1;	
	while($data=mysql_fetch_array($query)){
		$kode_ang=$data['kode_anggota'];
    	$d=mysql_fetch_array(mysql_query("SELECT SUM(besar_simpanan) as pokok from t_simpan where kode_anggota='$kode_ang' and jenis_simpan='pokok'"));
		$e=mysql_fetch_array(mysql_query("SELECT SUM(besar_simpanan) as wajib from t_simpan where kode_anggota='$kode_ang' and jenis_simpan='wajib'"));
		$f=mysql_fetch_array(mysql_query("SELECT SUM(besar_simpanan) as sukarela from t_simpan where kode_anggota='$kode_ang' and jenis_simpan='sukarela'"));
		$total=$d['pokok']+$e['wajib']+$f['sukarela'];
$pdf->Cell(3, 0.8, $no, 1, 0, 'C');
$pdf->Cell(5, 0.8, $data['nama_anggota'], 1, 0, 'C');
$pdf->Cell(4, 0.8, number_format($d['pokok']), 1, 0, 'C');
$pdf->Cell(4, 0.8, number_format($e['wajib']), 1, 0, 'C');
$pdf->Cell(4, 0.8, number_format($f['sukarela']), 1, 0, 'C');
$pdf->Cell(5, 0.8, number_format($total), 1, 1, 'C');

$no++;}
$a=mysql_fetch_array(mysql_query("SELECT SUM(besar_simpanan) as total from t_simpan"));
$pdf->Cell(25, 0.8, "Total  Rp. ".number_format($a['total'])."", 1, 1, 'C');
$pdf->Output("Laporan Seluruh Simpanan.pdf","I");

?>

