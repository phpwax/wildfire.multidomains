<?
class DomainContent extends WildfireContent{
  public $table = "wildfire_content";



  public function permalink($obj=false){
    if(!$obj) return $this->permalink;
    else return "/".ltrim(rtrim(str_replace($obj->permalink, "", $this->permalink), "/")."/", "/");
  }
}
?>