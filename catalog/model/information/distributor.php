<?php

class ModelInformationDistributor extends Model
{
    public function addDistributor(array $data){

        $format = "INSERT INTO %s VALUES(0, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' , '%s', %f, %f)";

        $query_string = sprintf($format, DB_PREFIX . "supplier",
            $this->db->escape($data["manager_firstname"]), $this->db->escape($data["manager_lastname"]),
            $this->db->escape($data["company_name"]), $this->db->escape($data["company_website"]),
            $this->db->escape($data["email"]), $this->db->escape($data["phone"]),
            $this->db->escape($data["house_number"]), $this->db->escape($data["city"]),
            $this->db->escape($data["postcode"]),$this->db->escape($data["street"]),
            $this->db->escape($data["region"]), $data["lat"], $data["lng"]);

        $query = $this->db->query($query_string);
        return $query->rows;
    }
}