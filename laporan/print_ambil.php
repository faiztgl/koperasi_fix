
<?php
include "../config/koneksi.php";
require('pdf/fpdf.php');
$pdf = new FPDF("L","cm","A4");
$luy=$_GET['kode_anggota'];


$pdf->SetMargins(2,1,1);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',11);
$pdf->MultiCell(19.5,0.5,'',0,'L'); 
$pdf->SetX(4);   
$pdf->SetFont('Arial','B',10);
$pdf->SetX(4);
$pdf->Image('../logo_kop.GIF',2,1.3,2,1.6);
$pdf->SetX(4); 
$pdf->MultiCell(19.5,0.5,'  " KOPERASI SIMPAN PINJAM "',0,'L');
$pdf->SetX(4);
$pdf->MultiCell(19.5,0.5,'  Alamat : Jln.jati-katerban-baron',0,'L');
$pdf->SetX(4);
$pdf->MultiCell(19.5,0.5,'  http://www.koperasi-simpan-pinjam.com',0,'L');
$pdf->Line(1,3.1,28.5,3.1);
$pdf->SetLineWidth(0.1);      
$pdf->Line(1,3.2,28.5,3.2);   
$pdf->SetLineWidth(0);
$pdf->ln(1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(25.2,0.7,"Laporan Seluruh Tabungan",0,10,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,0.7,"\nDi cetak pada : ".date("D-d/m/Y"),0,0,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(2, 0.8, 'NO', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Kode Ambil', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Kode Anggota', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Nama Anggota', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Kode Tabungan', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Tanggal Ambil', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Besar Ambil', 1, 1, 'C');
$pdf->SetFont('Arial','',10);
$query=mysql_query("SELECT * FROM t_pengambilan where kode_anggota='$luy'");
$no=1;
while($data=mysql_fetch_array($query))
{
	$pdf->Cell(2, 0.8, $no,1, 0, 'C');
	$pdf->Cell(4, 0.8, $data['kode_ambil'],1, 0, 'C');
	$pdf->Cell(4, 0.8, $data['kode_anggota'], 1, 0,'C');
	$d=$data['kode_anggota'];$f=mysql_fetch_array(mysql_query("SELECT nama_anggota from t_anggota where kode_anggota='$d'"));
	$pdf->Cell(4, 0.8, $f['nama_anggota'],1, 0,'C');
	$pdf->Cell(4, 0.8, $data['kode_tabungan'],1, 0,'C');
	$pdf->Cell(4, 0.8, $data['tgl_ambil'],1, 0,'C');
	$pdf->Cell(4, 0.8, number_format($data['besar_ambil']),1, 1,'C');
	$no++;
}
$hasil=mysql_fetch_array(mysql_query("SELECT besar_ambil from t_pengambilan where kode_anggota='$luy'"));
$pdf->Cell(22, 0.8, 'Total', 1, 0, 'C');
$pdf->Cell(4, 0.8, number_format($hasil['besar_ambil']), 1, 1, 'C');



$pdf->Output("Laporan Semua Tabungan.pdf","I");
?>