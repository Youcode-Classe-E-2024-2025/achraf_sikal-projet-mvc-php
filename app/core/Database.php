<?php

class database
{
    private function connect()
    {
        return new PDO(DB.":hostname=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
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
        $this->query(TABLES);
    }
}