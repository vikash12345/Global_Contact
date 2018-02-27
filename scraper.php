<?
// This is a template for a PHP scraper on morph.io (https://morph.io)
// including some code snippets below that you should find helpful

require 'scraperwiki.php';
require 'scraperwiki/simple_html_dom.php';
// Global Directory for USA 
//http://globalcontact.com/gc/directory/search.php?table=USBIZ&company=a&search=&search_sic=&page=1
//My Scraper will scrape data A to Z and check whole pagination.
$Alpha=array('1');
//$Alpha=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
for ($outterloop = 0; $outterloop < sizeof($Alpha); $outterloop++) 
{
	
	$NewLink	=	'http://globalcontact.com/gc/directory/search.php?table=USBIZ&company='.$Alpha[$outterloop].'&search=&search_sic=&page=1';
	$html		=	file_get_html($NewLink);
	sleep(5);
	if($html)
	{
		$link		=	$html->find("/html/body/center/table/tbody/tr[2]/td[2]/div/div[2]/table/tbody/tr/td[2]/div/div[4]/center/div/a[11]", 0);
		$checker	=	 $link->href.'<br>';
		$paginationlink	=	'http://www.globalcontact.com/gc/directory/'.$checker;
		$pages= substr(strrchr($paginationlink, "="), 1);
		for ($pagestart = 1; $pagestart <= $pages; $pagestart++)
		{
			$pagination = "http://globalcontact.com/gc/directory/search.php?table=USBIZ&company=$Alpha[$outterloop]&search=&search_sic=&page=$pagestart";
			$mainpage	=	file_get_html($pagination);
			if($mainpage)
			{
				echo $mainpage;
			}
			
		}
				
	}
	
}

?>
