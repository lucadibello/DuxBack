<?php
class ModelInformationFinder extends Model {
	
	public function getSuppliers() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "supplier");
		return $query->rows;
	}
}