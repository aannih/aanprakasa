<?php
session_start();

$conn = mySqli_connect("localhost","root","","stockbarang");

if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['Namabarang'];
    $deskripsi = $_POST['Deskripsi'];
    $stock = $_POST["Stock"];

    $addtotable = mySqli_query($conn,"insert into Stock (Namabarang, Deskripsi, Stock) values('$namabarang','$deskripsi','$stock')");
    if($addtotable){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
};


if (isset($_POST['barangmasuk'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['Penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where IDbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;

    $addtomasuk = mysqli_query($conn, "insert into barang_masuk (IDbarang, Keterangan, qty) values('$barangnya','$penerima','$qty')");
    $updatestokmasuk = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity' where IDbarang='$barangnya'");
    if ($addtomasuk&&$updatestokmasuk) {
        header('location:masuk.php');
    }else{
        echo 'gagal';
        header('location:masuk.php');
    }
};


//menambah barang keluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where IDbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;

    $addtokeluar = mysqli_query($conn,"insert into keluar (IDbarang, Penerima, qty) values('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stock='$tambahkanstocksekarangdenganquantity' where IDbarang='$barangnya'");
    if($addtokeluar&&$updatestockmasuk){
        header('location:keluar.php');

    }else{
        echo'gagal';
        header('location:keluar.php');
    }
}


?>