<?php

/**
 * main model class
 */

class model extends database
{
    protected $table = "";

    public function insert($data){
        if (!empty($this->queryColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->queryColumns)) {
                    unset($data[$key]);
                }
            }
        }
        $keys = array_keys($data);

        $query = "insert into " . $this->table;
        $query .= " (".implode(',',$keys).") values (:".implode(',:',$keys).")";

        $this->query($query, $data);
    }
    public function update($id, $data,$idName = "user_id"){
        if (!empty($this->queryColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->queryColumns)) {
                    unset($data[$key]);
                }
            }
        }
        $keys = array_keys($data);
        $query = "update " . $this->table . " set ";
        foreach ($keys as $key) {
            $query .= $key . ' = :' . $key . ",";
        }
        $query = trim($query, ",");
        $query .= " where $idName = :$idName";
        
        $data[$idName] = $id;
        $this->query($query, $data);
    }
    public function where($data, $order = "desc", $order_by = "course_id"){
        $keys = array_keys($data);

        $query = "select * from " . $this->table . " where ";
        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . " && ";
        }

        $query = trim($query, "&& ");
        $query .= " order by $order_by $order ";
        $res = $this->query($query, $data);
        if (is_array($res)) {
            ////// call afterSelect function ////////////
            if (property_exists($this, 'afterSelect')) {
                foreach ($this->afterSelect as $func) {
                    $res = $this->$func($res);
                }
            }
            return $res;
        }
        return false;
    }

    public function delete($id) {

        $query = "delete from " . $this->table . " where course_id=".$id;

        
        $res = $this->query($query);
        if (is_array($res)) {
            ////// call afterSelect function ////////////
            if (property_exists($this, 'afterSelect')) {
                foreach ($this->afterSelect as $func) {
                    $res = $this->$func($res);
                }
            }
            return $res;
        }
        return false;
    }
    

    public function findAll($order = "desc", $idName= "id", $pagenation=true , $limit = 6, $offset = 0)
    {
        if ($pagenation) {
            $query = "select * from " . $this->table . " order by $idName ".$order." limit $offset".", $limit";
        } else {
            $query = "select * from " . $this->table . " order by $idName ".$order;
        }
        
        $res = $this->query($query);
        if (is_array($res)) {
            ////// call afterSelect function ////////////
            if (property_exists($this, 'afterSelect')) {
                foreach ($this->afterSelect as $func) {
                    $res = $this->$func($res);
                }
            }
            return $res;
        }
        return false;
    }
    public function first($data, $order = "desc"){
        $keys = array_keys($data);

        $query = "select * from " . $this->table . " where ";
        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . " && ";
        }

        $query = trim($query, "&& ");
        $query .= " order by user_id $order limit 1";
        $res = $this->query($query, $data);
        if (is_array($res)) {
            ////// call afterSelect function ////////////
            if (property_exists($this, 'afterSelect')) {
                foreach ($this->afterSelect as $func) {
                    $res = $this->$func($res);
                }
            }
            return $res[0];
        }
        return false;
    }
}