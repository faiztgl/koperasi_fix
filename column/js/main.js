var rupiah1 = document.getElementById("rupiah1");
rupiah1.addEventListener("keyup", function(e) {
  rupiah1.value = convertRupiah(this.value);
});

var rupiah2 = document.getElementById("rupiah2");
rupiah2.addEventListener("keyup", function(e) {
  rupiah2.value = convertRupiah(this.value, "Rp. ");
});

var rupiah3 = document.getElementById("rupiah3");
rupiah3.addEventListener("keyup", function(e) {
  rupiah3.value = convertRupiah(this.value);
});
rupiah3.addEventListener('keydown', function(event) {
	return isNumberKey(event);
});

var rupiah4 = document.getElementById("rupiah4");
rupiah4.addEventListener("keyup", function(e) {
  rupiah4.value = convertRupiah(this.value, "Rp. ");
});
rupiah4.addEventListener('keydown', function(event) {
	return isNumberKey(event);
});

function convertRupiah(angka, prefix) {
  var number_string = angka.replace(/[^,\d]/g, "").toString(),
    split  = number_string.split(","),
    sisa   = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

	if (ribuan) {
		separator = sisa ? "." : "";
		rupiah += separator + ribuan.join(".");
	}

	rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
	return prefix == undefined ? rupiah : rupiah ? prefix + rupiah : "";
}

function isNumberKey(evt) {
    key = evt.which || evt.keyCode;
	if ( 	key != 188 // Comma
		 && key != 8 // Backspace
		 && key != 17 && key != 86 & key != 67 // Ctrl c, ctrl v
		 && (key < 48 || key > 57) // Non digit
		) 
	{
		evt.preventDefault();
		return;
	}
}

$(document).ready(function(){
    $('#nilaijam').mask('#.##0', {reverse: true});
    $('#masking2').mask('#.##0,0', {reverse: true});
    $('#masking3').mask('#,##0.00', {reverse: true});
})