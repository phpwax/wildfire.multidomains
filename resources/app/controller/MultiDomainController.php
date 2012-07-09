<?php

class MultiDomainController extends ApplicationController{
  public $cms_content_class = "DomainContent";
  public $domain_class = "Domain";
  public $domain_base_content = false; //this is root of the domains tree

  //hook in to the 404 error state of cms content to hunt out dealer based urls
  protected function event_setup(){
    parent::event_setup();
    //look for cms content by calling functions etc
    WaxEvent::clear("cms.content.lookup");
    WaxEvent::add("cms.content.lookup", function(){
      $obj = WaxEvent::data();
      $server = $_SERVER['HTTP_HOST'];
      $dclass = $obj->domain_class;
      $domain = new $dclass;
      $lookup = false;
      //check to see if the domain name exists
      if(($found = $domain->filter("webaddress", $server)->filter("status", 1)->first()) && ($pages = $found->content) && ($page = $pages->scope("live")->first())){
        $obj->domain_base_content = $lookup = $page;
        //copy original stack
        $original_stack = $obj->cms_stack;
        //push the pages url on to the stack
        foreach(array_reverse(explode("/", trim($lookup->permalink,"/"))) as $push) array_unshift($obj->cms_stack, $push);
        $obj->content_lookup($obj);
        //this might be one of those magic internal pages then...
        if($obj->cms_throw_missing_content){
          $obj->cms_throw_missing_content = false;
          $obj->cms_stack = $original_stack;
          $obj->content_lookup($obj);
        }
      }else{
        $obj->content_lookup($obj);
      }


    });
  }

  public function content_lookup($obj){
    //revert to normal
    if(($preview_id = Request::param('preview')) && is_numeric($preview_id) && ($m = new $obj->cms_content_class($preview_id)) && $m && $m->primval){
      $obj->cms_content = $m;
    }elseif($content = $obj->content($obj->cms_stack, $obj->cms_mapping_class, $obj->cms_live_scope, $obj->cms_language_id) ){
      $obj->cms_content = $content;
    }elseif($content = $obj->content($obj->cms_stack, $obj->cms_mapping_class, $obj->cms_live_scope, array_shift(array_keys(CMSApplication::$languages)) )){
      $obj->cms_content = $content;
    }elseif(WaxApplication::is_public_method($obj, "method_missing")){
      return $obj->method_missing();
    }else $obj->cms_throw_missing_content = true;
  }


}

