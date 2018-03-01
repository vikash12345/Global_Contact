<?
require 		'scraperwiki.php';
require 		'scraperwiki/simple_html_dom.php';
// Global Directory for USA 
//http://globalcontact.com/gc/directory/search.php?table=USBIZ&company=a&search=&search_sic=&page=1
//My Scraper will scrape data A to Z and check whole pagination.
$Alpha=array('1');
//$Alpha=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
for ($outterloop = 0; $outterloop < sizeof($Alpha); $outterloop++) 
{
	
	$NewLink	=	"http://globalcontact.com/gc/directory/search.php?table=USBIZ&company=$Alpha[$outterloop]&search=&search_sic=&page=1";
	$html		=	file_get_html($NewLink);
	sleep(5);
	if($html)
	{
		$link		=	$html->find("/html/body/center/table/tbody/tr[2]/td[2]/div/div[2]/table/tbody/tr/td[2]/div/div[4]/center/div/a[11]", 0);
		$checker	=	 $link->href.'<br>';
		$paginationlink	=	"http://www.globalcontact.com/gc/directory/$checker";
		$pages= substr(strrchr($paginationlink, "="), 1);
		for ($pagestart = 1; $pagestart <= $pages; $pagestart++) 	
		{
			$pagination = "http://globalcontact.com/gc/directory/search.php?table=USBIZ&company=$Alpha[$outterloop]&search=&search_sic=&page=$pagestart";
			$mainpage	=	file_get_html($pagination);
			sleep(20);
			if($mainpage)
			{
				foreach($mainpage->find("/html/body/center/table/tbody/tr[2]/td[2]/div/div[2]/table/tbody/tr/td[2]/div/div[4]/div") as $element)
				{										                       
					$linkofinnerpages	=	$element->find("table/tbody/tr[3]/td/div/table/tbody/tr/td[1]/a",0)->href;
					$innerpage			=	'http://globalcontact.com/gc/directory/'.$linkofinnerpages;
					
					if($innerpage 		!= 'http://globalcontact.com/gc/directory/')
					{
						$inpage			 =	$innerpage;
						$html	   		 =		file_get_html($inpage);
						sleep(8);
						
						//Name of Company 	
						$name 	=	$html->find("/html/body/center/table/tbody/tr[2]/td[2]/div/div[2]/table/tbody/tr/td[2]/div/div[1]/b",0)->plaintext;;

						//address.
						$address 	=	$html->find("/html/body/center/table/tbody/tr[2]/td[2]/div/div[2]/table/tbody/tr/td[2]/div/div[3]/table/tbody/tr/td[1]/table/tbody/tr[1]/td[2]",0)->plaintext;;
						
						
						//This is for city
						$city 	=	$html->find("/html/body/center/table/tbody/tr[2]/td[2]/div/div[2]/table/tbody/tr/td[2]/div/div[3]/table/tbody/tr/td[1]/table/tbody/tr[2]/td[2]",0)->plaintext;;
						
						//This is for State
						$state 	=	$html->find("/html/body/center/table/tbody/tr[2]/td[2]/div/div[2]/table/tbody/tr/td[2]/div/div[3]/table/tbody/tr/td[1]/table/tbody/tr[3]/td[2]",0)->plaintext;;
						
						//This is for Zipcode
						$zipcode 	=	$html->find("/html/body/center/table/tbody/tr[2]/td[2]/div/div[2]/table/tbody/tr/td[2]/div/div[3]/table/tbody/tr/td[1]/table/tbody/tr[4]/td[2]",0)->plaintext;;
						
						//This is for Website
						$website 	=	$html->find("/html/body/center/table/tbody/tr[2]/td[2]/div/div[2]/table/tbody/tr/td[2]/div/div[3]/table/tbody/tr/td[1]/table/tbody/tr[5]/td[2]",0)->plaintext;;
						
						//This is for contact
						$contact 	=	$html->find("/html/body/center/table/tbody/tr[2]/td[2]/div/div[2]/table/tbody/tr/td[2]/div/div[3]/table/tbody/tr/td[2]/table/tbody/tr[1]/td[2]",0)->plaintext;;
						
						
						//This is for title
						$title 	=	$html->find("/html/body/center/table/tbody/tr[2]/td[2]/div/div[2]/table/tbody/tr/td[2]/div/div[3]/table/tbody/tr/td[2]/table/tbody/tr[2]/td[2]",0)->plaintext;;
						
						//This is for phone
						$phone 	=	$html->find("/html/body/center/table/tbody/tr[2]/td[2]/div/div[2]/table/tbody/tr/td[2]/div/div[3]/table/tbody/tr/td[2]/table/tbody/tr[3]/td[2]",0)->plaintext;;
						
						
						//This is for fax
						$fax 	=	$html->find("/html/body/center/table/tbody/tr[2]/td[2]/div/div[2]/table/tbody/tr/td[2]/div/div[3]/table/tbody/tr/td[2]/table/tbody/tr[4]/td[2]",0)->plaintext;;
						
						
						//This is for email
						$email 	=	$html->find("/html/body/center/table/tbody/tr[2]/td[2]/div/div[2]/table/tbody/tr/td[2]/div/div[3]/table/tbody/tr/td[2]/table/tbody/tr[5]/td[2]/a",0)->plaintext;;
						
						
						
						 echo 'name '.$name.
						' address ' . $address.
						' city ' . $city.
						' state ' . $state.
						' zipcode ' . $zipcode.
						' website ' . $website.
						' contact ' . $contact.
						' title ' . $title.
						' phone ' . $phone.
						' fax ' . $fax.
						' email ' . $email;
						
						
						
					
		$record = array( 'name' =>$name, 
		   'address' => $address,
		   'city' => $city, 
		   'state' => $state, 
		   'zipcode' => $zipcode, 
		   'website' => $website, 
		   'contact' => $contact, 
		   'title' => $title, 
		   'phone' => $phone,
		   'fax' => $fax,
		   'email' => $email,
		   'inpage' => $inpage);
						
						
           scraperwiki::save(array('name','address','city','state','zipcode','website','contact','title','phone','fax','email','inpage'), $record);
					
						
						
						
						
						
						
						
						
						
						
						
						
					}

				}
			}
			
		}
				
	}
	
}



?>
