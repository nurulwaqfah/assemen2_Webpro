<?php

function hitungStatus($volume_sampah)
{
    if($volume_sampah >= 0 && $volume_sampah <= 40){
        return "Kosong";
    }elseif($volume_sampah >= 41 && $volume_sampah <= 80){
        return "Penuh";
    }else{
        return "Overflow";
    }
}