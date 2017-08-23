
<?php 

switch ($layout){
	case "layout_popup":
		include('default_layout_popup.tpl');
		break;
		
    default:
        include('default_layout_default.tpl');
}
	

?>