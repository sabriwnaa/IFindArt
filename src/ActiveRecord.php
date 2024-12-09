<?php

interface ActiveRecord{

    public function save():bool;
    public function delete():bool;
    public static function findById($id):?Object;
    public static function findall():array;
}

?>