<?
//hook in to the content model and add a join

if(!defined("CONTENT_MODEL")){
  $con = new ApplicationController(false, false);
  define("CONTENT_MODEL", $con->cms_content_class);
}


WaxEvent::add(CONTENT_MODEL.".setup", function(){
  $model = WaxEvent::data();
  $model->define("domains", "ManyToManyField", array('scaffold'=>true, 'target_model'=>'Domain', 'group'=>'relationships', 'editable'=>true));
});

?>