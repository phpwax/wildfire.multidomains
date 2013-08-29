<?
class Domain extends WaxModel{

  public function setup(){
    $this->define("webaddress", "CharField", array('scaffold'=>true,'group'=>'content', 'primary_group'=>1));
    $this->define("status", "BooleanField", array('label'=>'Live','scaffold'=>true,'group'=>'content', 'primary_group'=>1));
    $this->define("content", "ManyToManyField", array('target_model'=>CONTENT_MODEL,'scaffold'=>true, 'group'=>'relationships'));
  }

  public function before_save(){
    if(!$this->webaddress) $this->webaddress = "example.com";
  }
}
?>