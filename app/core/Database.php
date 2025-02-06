<?php

class database
{
    private function connect()
    {
        return new PDO(DB.":host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
    }
    public function query($query, $data = [])
    {
        $con=$this->connect();
        $stm = $con->prepare($query);
        if ($stm) {
            $check = $stm->execute($data);
            if ($check) {
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                if (is_array($result) && count($result) > 0) {
                    return $result;
                }
            }
        }
        return false;
    }
    public function createTable() 
    {
        $table = explode(";",trim(trim(TABLES)));
        foreach ($table as $t) {
            if ($t) {
                $this->query($t);
            }
        }
    }
}