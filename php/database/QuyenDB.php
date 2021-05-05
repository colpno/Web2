<?php
class QuyenDB extends connection {
    public function searchQuyen($maQuyen) {
        $sql="SELECT * FROM quyen WHERE maQuyen=".$maQuyen;
        $rows=mysqli_query($this->conn,$sql);
        $arr=array();
        while ($row=mysqli_fetch_array($rows)){
            $arr[]=$row;
        }
        return json_encode($arr);
    }
}
?>