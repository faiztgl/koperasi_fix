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
$pdf->Cell(25.2,0.7,"Laporan Jatuh Tempo",0,10,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,0.7,"\nDi cetak pada : ".date("D-d/m/Y"),0,0,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(2, 0.8, 'NO', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Kode Pinjam', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Nama Anggota', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Tanggal Pinjam', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Jatuh Tempo', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Besar Pinjam', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Lama Angsuran', 1, 1, 'C');
$pdf->SetFont('Arial','',10);
$sql=mysql_query("SELECT * from t_pinjam where status='belum lunas'");
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
    $pdf->Cell(2, 0.8, $nomer, 1, 0, 'C');
	$pdf->Cell(3, 0.8, $kd_p=$data['kode_pinjam'], 1, 0, 'C');
	$pdf->Cell(4, 0.8, $anggota['nama_anggota'], 1, 0, 'C');
	$pdf->Cell(4, 0.8, $data['tgl_entri'], 1, 0, 'C');
	$pdf->Cell(4, 0.8, $a, 1, 0, 'C');
	$pdf->Cell(4, 0.8, number_format($data['besar_pinjam']), 1, 0, 'C');
	$pdf->Cell(3, 0.8, $data['lama_angsuran']." Bulan", 1, 1, 'C');
	}
			else
			{
				
			}
    $nomer++;
	}
$pdf->Output("Laporan Jatuh tempo.pdf","I");

?>