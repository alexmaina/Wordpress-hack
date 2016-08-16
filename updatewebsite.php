<?php
/*****************************************************************************
The MIT License (MIT)

Copyright (c) 2016 Alex Maina

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
/*****************************************************************************
For any details please feel free to contact me at afroscholar@users.sourceforge.net or alexmaina@afroscholar.info
Or for snail mail. P. O. Box 71044,Nairobi-00610, East Africa-Kenya.
http://www.afroscholar.info  Git: https://github.com/alexmaina/kwtrpspace
/*****************************************************************************/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "data.php";
define('WP_USE_THEMES', false);
require('../wp-load.php');
$user_id = 77;
$con = dbConnect();

$query="select author,year,title,pages,secondary_title,volume,number,abstract,date,custom_2,accession_number from refs where pubid between 3137 and 3144";
$sql=$con->prepare($query);
$sql->execute();
$sql->SetFetchMode(PDO::FETCH_ASSOC);
while ($row=$sql->fetch()){
	//$ID =0;
	$author = $row['author'];
	$issue = $row['number'];
	$volume = $row['volume'];
	$pages = $row['pages'];
	$journals = $row['secondary_title'];
	$pubmed_link = 'http://www.ncbi.nlm.nih.gov/pubmed';
	$pmid = $row['accession_number'];
	$link_to_pubmed = "$pubmed_link/$pmid";
	$post_author = $user_id;
	$date = $row['date'];
	$post_date = date("Y-m-d H:i:s");
	$gmt = 3*60*60;
	$post_date_gmt = gmdate($post_date,time()+$gmt);
	$post_content = $row['abstract'];
	$post_title = $row['title'];
	$post_excerpt = '';
	$post_status = 'publish';
	$comment_status = 'open';
	$ping_status = 'open';
	$post_password = '';
	//$post_name = str_replace(' ','-',$post_title);
	$post_name = sanitize_title($post_title);
	$to_ping = '';
	$pinged = '';
	$post_modified = date("Y-m-d H:i:s");
	$post_modified_gmt = gmdate($post_modified,time()+$gmt);
	$post_content_filtered = '';
	$post_parent = 0;
	
	$url = 'http://uat/newsite?p=';
	$guid = 'http://uat/newsite?p=';
	$menu_order = 0;
	$post_type = 'publications';
	$post_mime_type = '';
	$comment_count = 0;
	$year = $row['year'];
	$pmid = $row['accession_number'];
	
	$query2 = "insert into wp_posts(post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count) values(:post_author,:post_date,:post_date_gmt,:post_content,:post_title,:post_excerpt,:post_status,:comment_status,:ping_status,:post_password,:post_name,:to_ping,:pinged,:post_modified,:post_modified_gmt,:post_content_filtered,:post_parent,:guid,:menu_order,:post_type,:post_mime_type,:comment_count) ";
	$stm=$con->prepare($query2);
	$stm->bindValue(':post_author', $post_author, PDO::PARAM_INT);
	$stm->bindValue(':post_date', $post_date, PDO::PARAM_STR);
	$stm->bindValue(':post_date_gmt', $post_date_gmt, PDO::PARAM_STR);
	$stm->bindValue(':post_content', $post_content, PDO::PARAM_STR);
	$stm->bindValue(':post_title', $post_title, PDO::PARAM_STR);
	$stm->bindValue(':post_excerpt', $post_excerpt, PDO::PARAM_STR);
	$stm->bindValue(':post_status', $post_status, PDO::PARAM_STR);
	$stm->bindValue(':comment_status', $comment_status, PDO::PARAM_STR);
	$stm->bindValue(':ping_status', $ping_status, PDO::PARAM_STR);
	$stm->bindValue(':post_password', $post_password, PDO::PARAM_STR);
	$stm->bindValue(':post_name', $post_name, PDO::PARAM_STR);
	$stm->bindValue(':to_ping', $to_ping, PDO::PARAM_STR);
	$stm->bindValue(':pinged', $pinged, PDO::PARAM_STR);
	$stm->bindValue(':post_modified', $post_modified, PDO::PARAM_STR);
	$stm->bindValue(':post_modified_gmt', $post_modified_gmt, PDO::PARAM_STR);
	$stm->bindValue(':post_content_filtered', $post_content_filtered, PDO::PARAM_STR);
	$stm->bindValue(':post_parent', $post_parent, PDO::PARAM_INT);
	$stm->bindValue(':guid', $guid, PDO::PARAM_STR);
	$stm->bindValue(':menu_order', $menu_order, PDO::PARAM_INT);
	$stm->bindValue(':post_type', $post_type, PDO::PARAM_STR);
	$stm->bindValue(':post_mime_type', $post_mime_type, PDO::PARAM_STR);
	$stm->bindValue(':comment_count', $comment_count, PDO::PARAM_INT);
	
	$stm->execute();
        $ID = $con->lastInsertId();
	
	$publications[] = array(
		'post_id' => $ID,
		'_Issue' => 'field_573d7fa8454e9',
		'Issue' => $issue,
		'_volume' => 'field_573d7f79ef9ab',
		'volume' => $volume,
		'_journals' => 'field_56d3de5ddc04d',
		'pages' => $pages,
		'authors' => $author,
		'_publication_date' => 'field_5729cc7e5b832',
		'publication_date' => $date,
		'_banner_text' => 'field_56cfed156f70a',
		'_link_to_pubmed' => 'field_573d7fe145230',
		'_authors' => 'field_56d3de4edc04c',
		'journals' => $journals,
		'url' => '',
		'_url' => 'field_56dd48d6ee6bb',
		'_assign_multiple' => 'field_570f3b71e3c3f',
		'banner_text' => '',
		'_pages' => 'field_573d7fbe06a50',
		'link_to_pubmed' => $link_to_pubmed
		
		
		);
		
}
	foreach($publications as $publication){
		$post_id = $publication['post_id'];
		unset($publication['post_id']);
			foreach($publication as $key=>$metadata){
		 		$query3 = "insert into wp_postmeta (post_id, meta_key, meta_value) 
                      		values (:post_id,:meta_key,:meta_value)";
				$stm2=$con->prepare($query3);
				$stm2->bindValue(':post_id',$post_id,PDO::PARAM_INT);
				$stm2->bindValue(':meta_key',$key,PDO::PARAM_STR);
				$stm2->bindValue(':meta_value',$metadata,PDO::PARAM_STR);
				$stm2->execute();
			}
	$query4 = "select * from wp_postmeta where meta_key = 'authors' and post_id = $post_id";
	$sql=$con->prepare($query4);
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
		while($row=$sql->fetch()){

			$meta_id = $row['meta_id'];
			$post_id = $row['post_id'];
			$meta_key = $row['meta_key'];
			$meta_value = $row['meta_value'];
			$meta_value = substr($meta_value,0, -1);
			$authors = explode('., ',$meta_value);
			
				foreach ($authors as $author){
					list ($name1, $name2) = explode(', ',$author);
					$name = str_replace('. ','', $name2);
					$initials = rtrim($name,'.');
					$initialsx = ltrim($initials);
					$medline_name = $name1 . ' ' . $initialsx;
					$query5 = "insert into author_publication (post_id,surname,initials,name,medline_name) values (:post_id, :name1, :initials,:name,:medline_name)";
					$stm3 = $con->prepare($query5);
					$stm3->bindValue(':post_id', $post_id, PDO::PARAM_INT);
		   			$stm3->bindValue(':name1', $name1, PDO::PARAM_STR);
		   			$stm3->bindValue(':initials', $initialsx, PDO::PARAM_STR);
		   			$stm3->bindValue(':name', $name, PDO::PARAM_STR);
		   			$stm3->bindValue(':medline_name', $medline_name, PDO::PARAM_STR);
					$stm3->execute();
					//echo "success-2!";
				}

	$query5 = " select apid, post_id, ID, email from author_publication inner join people on author_publication.medline_name = people.medline_name inner join wp_users on people.email = wp_users.user_email";
	$sql=$con->prepare($query5);
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
		while($row=$sql->fetch()){
			$apid = $row['apid'];
			$post_id = $row['post_id'];
			$ID = $row['ID'];
			$query6 = "insert into people_publication (apid,post_id,ID) values (:apid,:post_id,:ID)";
			$stm4 =$con->prepare($query6);
			$stm4->bindValue(':apid', $apid, PDO::PARAM_INT);
		   	$stm4->bindValue(':post_id', $post_id, PDO::PARAM_INT);
		   	$stm4->bindValue(':ID', $ID, PDO::PARAM_INT);
		   	$stm4->execute();
			//echo "success-3!";
		}
			//
		}		
}	

//*********************************//

$con = dbConnect();
$query = "create temporary table tableX(meta_id int(11) not null auto_increment, post_id int(11) not null, meta_key varchar(255), meta_value varchar(255), primary key(meta_id))";
$sql=$con->prepare($query);
$sql->execute();
//
//
//

$query = "SELECT t1.post_id,'multiple' AS multiple,COUNT(*) as count FROM people_publication AS t1 GROUP BY t1.post_id UNION SELECT t2.post_id, REPLACE(CONCAT('multiple_', @curRow:=CASE WHEN @postId = t2.post_id THEN @curRow + 1 ELSE 0 END, @postId:=t2.post_id), t2.post_id,'') AS multiple, t2.ID FROM people_publication AS t2 ORDER BY post_id, multiple";
$sql=$con->prepare($query);
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
	while($row=$sql->fetch()){
		$post_id = $row['post_id'];
		$meta_key = $row['multiple'];
		$meta_value = $row['count'];
		

		$query2 = "insert into tableX (post_id,meta_value,meta_key) values(:post_id,:meta_value,:meta_key)";
		$stm=$con->prepare($query2);
		$stm->bindValue(':post_id',$post_id, PDO::PARAM_INT);
		$stm->bindValue(':meta_key',$meta_key, PDO::PARAM_STR);
		$stm->bindValue(':meta_value',$meta_value, PDO::PARAM_STR);
		$stm->execute();
		
	}
//**************************************//
	$query2 = "select * from tableX";
	$sql = $con->prepare($query2);
	$sql->execute();
	$row = $sql->fetchAll(PDO::FETCH_ASSOC);
	echo "<pre>";//print_r($row);
	$newmetakey = array();
	$update = array();

//**************************************//
	foreach ($row as $key => $value) {
		echo "<pre>";
		//print_r($key);
		//print_r($row);
    		$newmetakey[$value["post_id"]]["post_id"] = $value["post_id"];

    		if (!isset($newmetakey[$value["post_id"]]["count"])) {
        		$newmetakey[$value["post_id"]]["count"] = -1;
   		 } else {
        		$newmetakey[$value["post_id"]]["count"] ++;
    			}
		
    		$newmetakey[$value["post_id"]]["meta_key"][$value["meta_id"]] = "assign_multiple_" . $newmetakey[$value["post_id"]]["count"] . "_assign";
    		$update[] = "UPDATE tableX SET meta_key = '{$newmetakey[$value["post_id"]]["meta_key"][$value["meta_id"]]}' WHERE meta_id = {$value["meta_id"]};";
	}
		
	$update = implode("",$update);
	$sql = $con->prepare($update);
	$sql->execute();
	

foreach($newmetakey as $newmeta){
$post_id = $newmeta['post_id'];
unset($newmeta['post_id']);
foreach($newmeta as $k=>$v){
print_r($v);
}

//
}

	$query3 = "update tableX set meta_key = replace(meta_key, 'assign_multiple_-1_assign', 'assign_multiple')";
	$sql = $con->prepare($query3);
	$sql->execute();

	$query4 = "select post_id, meta_key, meta_value from tableX";
	$sql= $con->prepare($query4);
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	
	//
	while($row=$sql->fetch()){
	$post_id = $row['post_id'];
	$meta_key = $row['meta_key'];
	$meta_value = $row['meta_value'];
	echo "$meta_key <br>";

	//print_r($meta_key);
	$query5 = "insert into wp_postmeta (post_id,meta_value,meta_key) values(:post_id,:meta_value,:meta_key)";
		$stm=$con->prepare($query5);
		$stm->bindValue(':post_id',$post_id, PDO::PARAM_INT);
		$stm->bindValue(':meta_key',$meta_key, PDO::PARAM_STR);
		$stm->bindValue(':meta_value',$meta_value, PDO::PARAM_STR);
		$stm->execute();
	      }
	
?>


