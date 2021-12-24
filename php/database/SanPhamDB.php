<?php
class SanPhamDB extends connection{
    public function listAll() {
        $sql="SELECT * FROM sanpham";
        $rows=mysqli_query($this->conn,$sql);
        $arr=array();
        while ($row=mysqli_fetch_array($rows)){
            $arr[]=$row;
        }
        return json_encode($arr);
    }
    
    public function count() {
        $sql="SELECT COUNT(maSP) AS 'sosp' FROM sanpham";
        $rows=mysqli_query($this->conn,$sql);
        $arr=array();
        while ($row=mysqli_fetch_array($rows)){
            $arr[]=$row;
        }
        return json_encode($arr);
    }

    public function countSearch($loai,$search,$from,$to,$sort) {
        $sql="SELECT COUNT(maSP) AS 'sosp' FROM sanpham ";
        if ($loai!="") {
            $sql.="WHERE maLoai=$loai ";
            if ($search!="") {
                $sql.="AND LOCATE('$search',tenSP)>0 ";
            }
            if ($from!="") {
                $sql.="AND donGia>=$from ";
            }
            if ($to!="") {
                $sql.="AND donGia<=$to ";
            }
        }
        else {
            if ($search!="") {
                $sql.="WHERE LOCATE('$search', tenSP)>0 ";
                if ($from!="") {
                    $sql.="AND donGia>=$from ";
                }
                if ($to!="") {
                    $sql.="AND donGia<=$to ";
                }
            }
            else {
                if ($from!="") {
                    $sql.="WHERE donGia>=$from ";
                    if ($to!="") {
                        $sql.="AND donGia<=$to ";
                    }
                }
                else {
                    if ($to!="") {
                        $sql.="WHERE donGia<=$to ";
                    }
                } 
            }  
        }
        if ($sort!="") {
            $sql.="ORDER BY donGia $sort; ";
        }
        
        $rows=mysqli_query($this->conn,$sql);
        $arr=array();
        while ($row=mysqli_fetch_array($rows)){
            $arr[]=$row;
        }
        return json_encode($arr);
    }

    public function countLoai() {
        $sql="SELECT sp.maLoai,tenLoai,COUNT(sp.maLoai) AS 'soLuong' FROM sanpham sp,loaisanpham lsp
        where sp.maLoai=lsp.maLoai
        GROUP BY sp.maLoai,tenLoai";
        $rows=mysqli_query($this->conn,$sql);
        $arr=array();
        while ($row=mysqli_fetch_array($rows)){
            $arr[]=$row;
        }
        return json_encode($arr);
    }

    public function searchLoai($maLoai) {
        $sql="SELECT * FROM sanpham WHERE maLoai=".$maLoai;
        $rows=mysqli_query($this->conn,$sql);
        $arr=array();
        while ($row=mysqli_fetch_array($rows)){
            $arr[]=$row;
        }
        return json_encode($arr);
    }

    public function searchMaSP($maSP) {
        $sql="SELECT * FROM sanpham WHERE maSP=".$maSP;
        $rows=mysqli_query($this->conn,$sql);
        $arr=array();
        while ($row=mysqli_fetch_array($rows)){
            $arr[]=$row;
        }
        return json_encode($arr);
    }
    public function searchTenLoai($maLoai) {
        $sql="SELECT * FROM loaisanpham WHERE maLoai=".$maLoai;
        $rows=mysqli_query($this->conn,$sql);
        $arr=array();
        while ($row=mysqli_fetch_array($rows)){
            $arr[]=$row;
        }
        return json_encode($arr);
    }
    public function updateSoLuong($maSP,$soLuong) {
        $sql="UPDATE sanpham SET soLuong=$soLuong WHERE maSP=$maSP";
        $rows=mysqli_query($this->conn,$sql);
    }

    public function page($trang,$sosp1trang,$loai,$search,$from,$to,$sort) {
        $sql="SELECT * FROM sanpham ";
        if ($loai!="") {
            $sql.="WHERE maLoai=$loai ";
            if ($search!="") {
                $sql.="AND LOCATE('$search',tenSP)>0 ";
            }
            if ($from!="") {
                $sql.="AND donGia>=$from ";
            }
            if ($to!="") {
                $sql.="AND donGia<=$to ";
            }
        }
        else {
            if ($search!="") {
                $sql.="WHERE LOCATE('$search',tenSP)>0 ";
                if ($from!="") {
                    $sql.="AND donGia>=$from ";
                }
                if ($to!="") {
                    $sql.="AND donGia<=$to ";
                }
            }
            else {
                if ($from!="") {
                    $sql.="WHERE donGia>=$from ";
                    if ($to!="") {
                        $sql.="AND donGia<=$to ";
                    }
                }
                else {
                    if ($to!="") {
                        $sql.="WHERE donGia<=$to ";
                    }
                } 
            }  
        }

        if ($sort!="") {
            $sql.="ORDER BY donGia $sort ";
        }
        
        $vitri=($trang-1)*$sosp1trang;
        $sql.="LIMIT $vitri,$sosp1trang ";

        $rows=mysqli_query($this->conn,$sql);
        $arr=array();
        while ($row=mysqli_fetch_array($rows)){
            $arr[]=$row;
        }
        return json_encode($arr);
    }
}
?>