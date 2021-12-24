<?php
class NhanVienDB extends connection {
    public function them($maTK,$ho,$ten,$diachi,$sodienthoai) {
        $sql1="ALTER TABLE nhanvien AUTO_INCREMENT = 1 ";
        $sql2="INSERT INTO nhanvien(maTK,ho,ten,sodienthoai,diachi) VALUES ('".$maTK."','".$ho."',
        '".$ten."','".$sodienthoai."','".$diachi."')";
        $row1=mysqli_query($this->conn,$sql1);
        $row2=mysqli_query($this->conn,$sql2);
    }
    public function searchMaNV($maTK) {
        $sql="SELECT * FROM nhanvien WHERE maTK=".$maTK;
        $rows=mysqli_query($this->conn,$sql);
        $arr=array();
        while ($row=mysqli_fetch_array($rows)){
            $arr[]=$row;
        }
        return json_encode($arr);
    }
}
?>