<?
CMSApplication::register_module("domain", array('plugin_name'=>'wildfire.multidomain', "display_name"=>"Domains", "link"=>"/admin/domain/", 'split'=>true));

if(!defined("CONTENT_MODEL")){
  $con = new ApplicationController(false, false);
  define("CONTENT_MODEL", $con->cms_content_class);
}


WaxEvent::add(CONTENT_MODEL.".setup", function(){
  $model = WaxEvent::data();
  $model->define("domains", "ManyToManyField", array('scaffold'=>true, 'target_model'=>'Domain', 'group'=>'relationships', 'editable'=>true));
});

?>