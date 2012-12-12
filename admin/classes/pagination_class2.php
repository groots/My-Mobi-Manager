<?
/*
Developed by Reneesh T.K
reneeshtk@gmail.com
You can use it with out any worries...It is free for you..It will display the out put like:
First | Previous | 3 | 4 | 5 | 6 | 7| 8 | 9 | 10 | Next | Last
Page : 7  Of  10 . Total Records Found: 20
*/
class Pagination_class2{
	var $result;
	var $anchors;
	var $total;
	function Pagination_class2($qry1,$starting1,$recpage1)
	{
		
		$rst		=	mysql_query($qry1) or die(mysql_error());
		$numrows	=	mysql_num_rows($rst);
		$qry1		 .=	" limit $starting1, $recpage1";
		$this->result	=	mysql_query($qry1) or die(mysql_error());
		$next		=	$starting1+$recpage1;
		$var		=	((intval($numrows/$recpage1))-1)*$recpage1;
		$page_showing	=	intval($starting1/$recpage1)+1;
		$total_page	=	ceil($numrows/$recpage1);
		
		if ($total_page > 1) {
			if($numrows % $recpage1 != 0){
				$last = ((intval($numrows/$recpage1)))*$recpage1;
			}else{
				$last = ((intval($numrows/$recpage1))-1)*$recpage1;
			}
			$previous = $starting1-$recpage1;
			$anc = "<ul id='pagination-flickr'>";
			if($previous < 0){
				$anc .= "<li class='previous-off'> << </li>";
				$anc .= "<li class='previous-off'> < </li>";
			}else{
				$anc .= "<li class='next'><a href='javascript:pagination2(0);'> << </a></li>";
				$anc .= "<li class='next'><a href='javascript:pagination2($previous);'> < </a></li>";
			}
			
			################If you dont want the numbers just comment this block###############	
			$norepeat = 2;//no of pages showing in the left and right side of the current page in the anchors 
			$j = 1;
			$anch = "";
			for($i=$page_showing; $i>1; $i--){
				$fpreviousPage = $i-1;
				$page = ceil($fpreviousPage*$recpage1)-$recpage1;
				$anch = "<li><a href='javascript:pagination2($page);'>$fpreviousPage </a></li>".$anch;
				if($j == $norepeat) break;
				$j++;
			}
			$anc .= $anch;
			$anc .= "<li class='active'>".$page_showing."</li>";
			$j = 1;
			for($i=$page_showing; $i<$total_page; $i++){
				$fnextPage = $i+1;
				$page = ceil($fnextPage*$recpage1)-$recpage1;
				$anc .= "<li><a href='javascript:pagination2($page);'>$fnextPage</a></li>";
				if($j==$norepeat) break;
				$j++;
			}
			############################################################
			if($next >= $numrows){
				$anc .= "<li class='previous-off'> > </li>";
				$anc .= "<li class='previous-off'> >> </li>";
			}else{
				$anc .= "<li class='next'><a href='javascript:pagination2($next);'> >  </a></li>";
				$anc .= "<li class='next'><a href='javascript:pagination2($last);'> >> </a></li>";
			}
				$anc .= "</ul>";
			$this->anchors = $anc;
		}
		$this->total = "Page: $page_showing <i> Of  </i> $total_page . Total Sites: $numrows";
	}
}
?>