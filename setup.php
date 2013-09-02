<?
CMSApplication::register_module("domain", array("display_name"=>"Domains", "link"=>"/admin/domain/"));

AutoLoader::register_view_path("plugin", __DIR__."/view/");
AutoLoader::register_controller_path("plugin", __DIR__."/lib/controller/");
AutoLoader::register_controller_path("plugin", __DIR__."/resources/app/controller/");
AutoLoader::$plugin_array[] = array("name"=>"wildfire.multidomains","dir"=>__DIR__);

if(!defined("CONTENT_MODEL")){
  $con = new ApplicationController(false, false);
  define("CONTENT_MODEL", $con->cms_content_class);
}
define("WILDFIRE_MULTIDOMAIN", 1);

WaxEvent::add(CONTENT_MODEL.".setup", function(){
  $model = WaxEvent::data();
  $model->define("domains", "ManyToManyField", array('scaffold'=>true, 'target_model'=>'Domain', 'group'=>'relationships', 'editable'=>true));
});

?>
