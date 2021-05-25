<?php
class HoaDonDB extends connection
{
    public function themHD($maKH, $ngay, $tongTien, $diachi, $sodienthoai)
    {
        $sql1 = "ALTER TABLE hoadon AUTO_INCREMENT = 1 ;";
        $sql2 = "INSERT INTO hoadon(maKH,ngayLapHoaDon,tongTien,diaChi,soDienThoai,tinhTrang) VALUES ('$maKH','$ngay','$tongTien',
        '$diachi','$sodienthoai','0')";
        $row1 = mysqli_query($this->conn, $sql1);
        $row2 = mysqli_query($this->conn, $sql2);
    }
    public function searchMaHD()
    {
        $sql = "SELECT AUTO_INCREMENT AS 'maHDN' FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'banhang'
        AND   TABLE_NAME   = 'hoadon';";
        $rows = mysqli_query($this->conn, $sql);
        $arr = array();
        while ($row = mysqli_fetch_array($rows)) {
            $arr[] = $row;
        }
        return json_encode($arr);
    }
    public function listMaKH($maKH)
    {
        $sql = "SELECT * FROM hoadon WHERE maKH=" . $maKH;
        $rows = mysqli_query($this->conn, $sql);
        $arr = array();
        while ($row = mysqli_fetch_array($rows)) {
            $arr[] = $row;
        }
        return json_encode($arr);
    }
}
