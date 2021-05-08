<?php
class ChiTietHoaDonDB extends connection {
    public function themChiTietHD($maHD,$arr) { 
        foreach ($arr as $key=>$value) {
            $maSP=$value["maSP"];
            $soLuong=$value["soLuong"];
            $donGia=$value["donGia"];
            $thanhTien=$value["thanhTien"];
            $sql="INSERT INTO chitiethoadon(maHD,maSP,soLuong,donGia,thanhTien) VALUES ('".$maHD."','".$maSP."',
            '".$soLuong."','".$donGia."','".$thanhTien."')";
            $row=mysqli_query($this->conn,$sql);
        }
    }
    public function listHD($maHD) {
        $sql="SELECT * FROM chitiethoadon WHERE maHD=".$maHD;
        $rows=mysqli_query($this->conn,$sql);
        $arr=array();
        while ($row=mysqli_fetch_array($rows)) {
            $arr[]=$row;
        }
        return json_encode($arr);
    }
}
?>