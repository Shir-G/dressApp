<?php

// It may take a whils to crawl a site ...
set_time_limit(10000);

// Inculde the phpcrawl-mainclass
include("PHPCrawl_083/libs/PHPCrawler.class.php");

// Extend the class and override the handleDocumentInfo()-method 
class MyCrawler extends PHPCrawler 
{
  function handleDocumentInfo($DocInfo) 
  {
    //if($DocInfo->http_status_code==200){

      // Just detect linebreak for output ("\n" in CLI-mode, otherwise "<br>").
      if (PHP_SAPI == "cli") $lb = "\n";
      else $lb = "<br />";

      // Print the URL and the HTTP-status-Code
      echo "Page requested: ".$DocInfo->url." (".$DocInfo->http_status_code.")".$lb;
      
      // Print the refering URL
      echo "Referer-page: ".$DocInfo->referer_url.$lb;
      
      // Print if the content of the document was be recieved or not
      if ($DocInfo->received == true)
        echo "Content received: ".$DocInfo->bytes_received." bytes".$lb;
      else
        echo "Content not received".$lb; 



      /* start implementation */
      // 1. check if does not exist in db
      // 2. $html = file_get_contents('http://stackoverflow.com/questions/ask');
      //            
      // 3. save image,title etc... in db

    echo $lb;
    //}





    
    // Now you should do something with the content of the actual
    // received page or file ($DocInfo->source), we skip it in this example 
    

    
    flush();
  } 
}
// ourimp//

//$html = file_get_contents('https://www.pullandbear.com/il/woman-c1010141503.html');
//$html = $html->getElementsByTagName('li');

///////////


// Now, create a instance of your class, define the behaviour
// of the crawler (see class-reference for more options and details)
// and start the crawling-process.

$crawler = new MyCrawler();

// URL to crawl
//http://localhost/PHPCrawl_083/example.php
$crawler->setURL("https://www.pullandbear.com/il/woman/clothing/coats-and-jackets-c1030009518.html");

// Only receive content of files with content-type "text/html"
$crawler->addContentTypeReceiveRule("#text/html#");

// Add links to follow - all links that end with "c[number]p[number].html"
//$crawler->addURLFilterRule("#\.(jpg|jpeg|gif|png)$# i");
$crawler->addURLFollowRule("#((c)\w+([0-9])+(p)+([0-9])+\w.html)$# i");

// Store and send cookie-data like a browser does
$crawler->enableCookieHandling(true);

// Set the traffic-limit to 1 MB (in bytes,
// for testing we dont want to "suck" the whole site)
//$crawler->setTrafficLimit(1000 * 1024);

// Thats enough, now here we go
$crawler->go();

// At the end, after the process is finished, we print a short
// report (see method getProcessReport() for more information)
$report = $crawler->getProcessReport();

if (PHP_SAPI == "cli") $lb = "\n";
else $lb = "<br />";
    
echo "Summary:".$lb;
echo "Links followed: ".$report->links_followed.$lb;
echo "Documents received: ".$report->files_received.$lb;
echo "Bytes received: ".$report->bytes_received." bytes".$lb;
echo "Process runtime: ".$report->process_runtime." sec".$lb; 
?>