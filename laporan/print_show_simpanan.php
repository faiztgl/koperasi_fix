
<?php
include "../config/koneksi.php";
$kode=$_GET['kode'];
$nama=mysql_fetch_array(mysql_query("SELECT nama_anggota from t_anggota where kode_anggota='$kode'"));
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
$pdf->Cell(25.2,0.7,"Laporan Simpanan Anggota ".$nama['nama_anggota']."",0,10,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,0.7,"\nDi cetak pada : ".date("D-d/m/Y"),0,0,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(3, 0.8, 'NO', 1, 0, 'C');
$pdf->Cell(6, 0.8, 'Tanggal Simpan', 1, 0, 'C');
$pdf->Cell(6, 0.8, 'Jenis Simpanan', 1, 0, 'C');
$pdf->Cell(5, 0.8, 'Besar Simpanan', 1, 0, 'C');
$pdf->Cell(5, 0.8, 'Keterangan', 1, 1, 'C');
$pdf->SetFont('Arial','',10);
$query = mysql_query("SELECT * from t_simpan where kode_anggota='$kode'");
$no=1;
while($data=mysql_fetch_array($query)){
	$pdf->Cell(3, 0.8, $no,1, 0, 'C');
    $pdf->Cell(6, 0.8, $data['tgl_entri'],1, 0, 'C');
    $pdf->Cell(6, 0.8, $data['jenis_simpan'], 1, 0,'C');
    $pdf->Cell(5, 0.8, number_format($data['besar_simpanan']),1, 0,'C');
	$pdf->Cell(5, 0.8, "-",1, 1,'C');$no++;}
$hasil=mysql_fetch_array(mysql_query("SELECT sum(besar_simpanan) as besar from t_simpan where kode_anggota='$kode'"));
$pdf->Cell(15, 0.8, 'Total', 1, 0, 'C');
$pdf->Cell(5, 0.8, number_format($hasil['besar']), 1, 0, 'C');
$pdf->Cell(5, 0.8, '-', 1, 1, 'C');
$pdf->Output("Laporan simpanan.pdf","I");

?>

