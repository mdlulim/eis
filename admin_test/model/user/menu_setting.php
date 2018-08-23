<?php
class ModelUserMenuSetting extends Model {
	
	public function getAllmenusetting() {
		
		$sql = "SELECT * FROM oc_menu_setting WHERE parent_id=0 and status = 1 ORDER BY parent_id, sort_order, menu_id";
		
		
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getSubMenu($parent_id) {
		
		$sql = "SELECT * FROM oc_menu_setting WHERE parent_id=".$parent_id." and status = 1 ORDER BY parent_id, sort_order, menu_id";
		
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getCAllmenusetting($user_group_id) {
		
		$sql = "SELECT ms.* FROM oc_menu_setting ms INNER JOIN oc_menu_setting_to_user_group mu ON mu.menu_id=ms.menu_id WHERE mu.user_group_id=".$user_group_id." AND ms.parent_id=0 AND ms.status = 1 ORDER BY ms.parent_id, ms.sort_order, ms.menu_id";
		
		
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getCSubMenu($parent_id, $user_group) {
		
		$sql = "SELECT ms.* FROM oc_menu_setting ms INNER JOIN oc_menu_setting_to_user_group mu ON mu.menu_id=ms.menu_id WHERE $where mu.user_group_id=".$user_group." AND  ms.parent_id=".$parent_id." AND ms.status = 1 ORDER BY ms.parent_id, ms.sort_order, ms.menu_id";
		
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getCAllMenuSettings($user_group_id) {
		$sql = "SELECT ms.* FROM oc_menu_setting ms INNER JOIN oc_menu_setting_to_user_group mu ON mu.menu_id=ms.menu_id WHERE mu.user_group_id=".$user_group_id." AND ms.status = 1 ORDER BY ms.parent_id, ms.sort_order, ms.menu_id";
		
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function editmenusetting($user_group_id, $data) {
		$menu_ids = $data['menu_id'];
		
		$this->db->query("DELETE from " . DB_PREFIX . "menu_setting_to_user_group where user_group_id = '".$user_group_id."'");
		
		foreach($menu_ids as $menu_id)
		{ 
			$this->db->query("INSERT into " . DB_PREFIX . "menu_setting_to_user_group SET menu_id = '" . $menu_id . "', user_group_id = '" . $user_group_id . "'");
		}
		
	}
	
}