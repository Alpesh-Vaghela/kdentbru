<?php
class links{
	
	public function link($pagename,$panel=NULL,$query=NULL)
	{
		
if($panel==admin){
	return SITE_URL."/index.php?".admin."=".$pagename.$query;
}
else {
    
    
    
    
	return SITE_URL.'/index.php?'.user.'='.$pagename.$query;
}	
		
		
	}
	public function hrefquery()
	{
		$request=$_SERVER['REQUEST_URI'];

		$parsed= explode('?', $request);
	
		
       $parsed=explode('=',$parsed['2']);
      
	return $parsed;
	
		
		
	}
	
}
?>