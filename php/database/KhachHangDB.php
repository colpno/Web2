<?php
class KhachHangDB extends connection {
    public function them($maTK,$ho,$ten,$sodienthoai) {
        $sql1="ALTER TABLE khachhang AUTO_INCREMENT = 1 ";
        $sql2="INSERT INTO khachhang(maTK,ho,ten,sodienthoai) VALUES ('".$maTK."','".$ho."',
        '".$ten."','".$sodienthoai."')";
        $row1=mysqli_query($this->conn,$sql1);
        $row2=mysqli_query($this->conn,$sql2);
    }
    public function searchMaKH($maTK) {
        $sql="SELECT * FROM khachhang WHERE maTK=".$maTK;
        $rows=mysqli_query($this->conn,$sql);
        $arr=array();
        while ($row=mysqli_fetch_array($rows)){
            $arr[]=$row;
        }
        return json_encode($arr);
    }
    public function updateDiaChi($maKH,$diaChi) {
        $sql="UPDATE khachhang SET diaChi='$diaChi' WHERE maKH=$maKH";
        $rows=mysqli_query($this->conn,$sql);
        echo $sql;
    }
}
?>