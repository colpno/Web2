<?php
class TaiKhoanDB extends connection {
    public function searchTenTK($tenTK) {
        $sql="SELECT * FROM taikhoan WHERE tenTaiKhoan='".$tenTK."'";
        $rows=mysqli_query($this->conn,$sql);
        $arr=array();
        while ($row=mysqli_fetch_array($rows)){
            $arr[]=$row;
        }
        return json_encode($arr);
    }
    public function them($taikhoan,$matkhau) {
        $sql1="ALTER TABLE taikhoan AUTO_INCREMENT = 1 ;";
        $sql2="INSERT INTO taikhoan(maQuyen,tenTaiKhoan,matKhau,trangThai,anhDaiDien) VALUES ('3','".$taikhoan."',
        '".$matkhau."','1','./img/avatar.jpg')";
        $row1=mysqli_query($this->conn,$sql1);
        $row2=mysqli_query($this->conn,$sql2);
    }
}
?>