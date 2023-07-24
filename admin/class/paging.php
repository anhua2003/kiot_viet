<?php
class paging
{
	public $total;			// Total records in DB  
	public $limit;		// Records per page to display
	//public $total_page;			// Total Pages
	public $page;			// Fix Page length to display
	public $maxpage=15;
	private	$limitpage = 7;
	private $total_page;
	public $html;// Html Code for display
	public $url;
	
	public function totalpage(){
		if ($this->total > $this->limit ){
			$res = @ceil($this->total/$this->limit);
			$this->total_page = $res;
			return $res;
		}
	}

	public function display_ajax(){
		if ($this->totalpage()){
			if ($this->total_page > $this->maxpage){
				// $this->html.='<li><a> page '.$this->page."/".$this->totalpage()."</a></li>";
				$start = $this->page - $this->limitpage;
				if (($this->page - $this->limitpage) > 0) $this->html.="<li> <a class='demtrang' onclick='return paging_ajax(1)' href='javascript:;'>First</a></li><li style='border:none;background:none;padding-top:10px;color:black'><a> ... </a></li><li><a title='Back' class='demtrang' onclick='return paging_ajax(".$start.")' href='javascript:;'> << </a></li>";
				// ======================
				if ($this->page > $this->limitpage){
					if (($this->page + $this->limitpage) >= $this->total_page) $end = $this->total_page;
					else $end = $this->page + $this->limitpage;					
					for ($i = $start; $i <= $end; $i++ ){
						if ($this->page == $i){
							$this->html .= "<li class=\"active\"> <a class='demtrang' onclick='return paging_ajax(".$i.")' href='javascript:;'> ".$i." </a> </li>";
						} else {
							$this->html .= "<li> <a onclick='return paging_ajax(".$i.")' class='demtrang' href='javascript:;'> ".$i." </a> </li>";
						}
					}
				} else {
					for ($i = 1; $i <= $this->maxpage ; $i++ ){
						if ($this->page == $i) {
							$this->html .= "<li class=\"active\"> <a class='demtrang' onclick='return paging_ajax(".$i.")' href='javascript:;'> ".$i." </a> </li>";
						} else {
							$this->html .= "<li> <a class='demtrang' onclick='return paging_ajax(".$i.")' href='javascript:;'> ".$i." </a> </li>";
						}
					}
				}
				// ======================
				
				
				if ((($this->page - $this->limitpage) < $this->total_page) & ($this->total_page - $this->page) > $this->limitpage){
					$this->html .= "<li> <a title='trang tiếp theo' class='demtrang' onclick='return paging_ajax(".$i.")' href='javascript:;'> >> </li> </a> <li><a title='Đi đến trang cuối cùng' class='demtrang' onclick='return paging_ajax(".$this->total_page.")' href='javascript:;'>".($this->total_page)."</a></li>";
				
					$this->html.="<li> <a class='demtrang' onclick='return paging_ajax(".$this->total_page.")' href='javascript:;'> Last </a></li>";
				}
			} else {
				for($i=1;$i<=$this->total_page;$i++) {
					if ($this->page == $i){
						$this->html .= "<li class=\"active\"><a class='demtrang' onclick='return paging_ajax(".$i.")' href='javascript:;'>".$i."</a></li>";
					} else {
						$this->html .= "<li><a class='demtrang' onclick='return paging_ajax(".$i.")' href='javascript:;'>".$i."</a></li>";
					}
				}
				
			}
		}
		if( $this->html !='' ){
			return "<ul class=\"store-pagination\">".$this->html."</ul>";
		}else{
			return "<ul class=\"store-pagination\"><li class=\"active\"><a class='demtrang' onclick='return paging_ajax(1)' href='javascript:;'>1</a></li></ul>";
		}
	}
	
	public function display_ajax2(){
		if ($this->totalpage()){
			if ($this->total_page > $this->maxpage){
				// $this->html.='<li> <a>Trang '.$this->page."/".$this->totalpage()."</a></li>";
				$start = $this->page - $this->limitpage;
				if (($this->page - $this->limitpage) > 0) $this->html.="<li><a class='demtrang' onclick='return paging_ajax2(1)' href='javascript:;'>First</a></li><li style='border:none;background:none;padding-top:10px;color:black'><a>...</a></li><li><a title='trở lại' class='demtrang' onclick='return paging_ajax2(".$start.")' href='javascript:;'> << </a> </li>";
				// ======================
				if ($this->page > $this->limitpage){
					if (($this->page + $this->limitpage) >= $this->total_page) $end = $this->total_page;
					else $end = $this->page + $this->limitpage;					
					for ($i = $start; $i <= $end; $i++ ){
						if ($this->page == $i){
							$this->html .= "<li class=\"active\"><a class='demtrang' onclick='return paging_ajax2(".$i.")' href='javascript:;'>".$i."</a></li>";
						} else {
							$this->html .= "<li><a onclick='return paging_ajax2(".$i.")' class='demtrang' href='javascript:;'>".$i."</a></li>";
						}
					}
				} else {
					for ($i = 1; $i <= $this->maxpage ; $i++ ){
						if ($this->page == $i) {
							$this->html .= "<li class=\"active\"><a class='demtrang' onclick='return paging_ajax2(".$i.")' href='javascript:;'>".$i."</a></li>";
						} else {
							$this->html .= "<li><a class='demtrang' onclick='return paging_ajax2(".$i.")' href='javascript:;'>".$i."</a></li>";
						}
					}
				}
				// ======================
				
				
				if ((($this->page - $this->limitpage) < $this->total_page) & ($this->total_page - $this->page) > $this->limitpage){
					$this->html .= "<li><a title='next' class='demtrang' onclick='return paging_ajax2(".$i.")' href='javascript:;'> >> </a> </li> <li><a title='Đi đến trang cuối cùng' class='demtrang' onclick='return paging_ajax2(".$this->total_page.")' href='javascript:;'>".($this->total_page)."</a></li>";
					
					$this->html.="<li><a class='demtrang' onclick='return paging_ajax2(".$this->total_page.")' href='javascript:;'>Trang cuối</a></li>";
				}
			} else {
				for($i=1;$i<=$this->total_page;$i++) {
					if ($this->page == $i){
						$this->html .= "<li class=\"active\"><a class='demtrang' onclick='return paging_ajax2(".$i.")' href='javascript:;'>".$i."</a></li>";
					} else {
						$this->html .= "<li><a class='demtrang' onclick='return paging_ajax2(".$i.")' href='javascript:;'>".$i."</a></li>";
					}
				}
				
			}
		}
		if($this->html!=''){
			return "<ul class=\"pagination L\">".$this->html."</ul>";
		}else{
			return "<ul class=\"pagination L\"><li class=\"active\"><a class='demtrang' onclick='return paging_ajax2(1)' href='javascript:;'> 1 </a></li></ul>";
		}
	}
	public function display_ajax3(){//No default page 1
		if ($this->totalpage()){
			if ($this->total_page > $this->maxpage){
				// $this->html.='<li>Trang '.$this->page."/".$this->totalpage()."</li>";
				$start = $this->page - $this->limitpage;
				if (($this->page - $this->limitpage) > 0) $this->html.="
					<li class='demtrang'  onclick='return paging_ajax3(1)'><a  href='javascript:;'>Trang đầu</a></li><li style='border:none;background:none;padding-top:10px;color:black'>...</li>
					<li class='demtrang' onclick='return paging_ajax3(".$start.")' ><a title='trở lại'  href='javascript:;'> << </a></li>";
				// ======================
				if ($this->page > $this->limitpage){
					if (($this->page + $this->limitpage) >= $this->total_page) $end = $this->total_page;
					else $end = $this->page + $this->limitpage;					
					for ($i = $start; $i <= $end; $i++ ){
						if ($this->page == $i){
							$this->html .= "<li class='demtrang active' onclick='return paging_ajax3(".$i.")' ><a  href='javascript:;'>".$i."</a></li>";
						} else {
							$this->html .= "<li class='demtrang' onclick='return paging_ajax3(".$i.")'><a  href='javascript:;'>".$i."</a></li>";
						}
					}
				} else {
					for ($i = 1; $i <= $this->maxpage ; $i++ ){
						if ($this->page == $i) {
							$this->html .= "<li class='demtrang active' onclick='return paging_ajax3(".$i.")'><a href='javascript:;'>".$i."</a></li>";
						} else {
							$this->html .= "<li class='demtrang'  onclick='return paging_ajax3(".$i.")' ><a href='javascript:;'>".$i."</a></li>";
						}
					}
				}
				// ======================
				
				
				if ((($this->page - $this->limitpage) < $this->total_page) & ($this->total_page - $this->page) > $this->limitpage){
					$this->html .= "<li class='demtrang' onclick='return paging_ajax3(".$i.")'><a title='trang tiếp theo' href='javascript:;'>>></a></li><li onclick='return paging_ajax3(".$this->total_page.")'><a title='Đi đến trang cuối cùng' class='demtrang'  href='javascript:;'>".($this->total_page)."</a></li>";
				
					$this->html.="<li class='demtrang' onclick='return paging_ajax3(".$this->total_page.")'> <a href='javascript:;'>Trang cuối </a></li>";
				}
			} else {
				for($i=1;$i<=$this->total_page;$i++) {
					if ($this->page == $i){
						$this->html .= "<li  class='demtrang active' onclick='return paging_ajax3(".$i.")'><a  href='javascript:;'>".$i."</a></li>";
					} else {
						$this->html .= "<li class='demtrang' onclick='return paging_ajax3(".$i.")'><a onclick='return paging_ajax3(".$i.")' href='javascript:;'>".$i."</a></li>";
					}
				}
				
			}
		}
		if($this->html != '') $this->html = "<ul class='pagination L'>".$this->html."</ul>";

		return $this->html.'';	
	}

	public function display_ajax4(){//No default page 1
		if ($this->totalpage()){
			if ($this->total_page > $this->maxpage){
				// $this->html.='<li>Trang '.$this->page."/".$this->totalpage()."</li>";
				$start = $this->page - $this->limitpage;
				if (($this->page - $this->limitpage) > 0) $this->html.="
					<li class='demtrang'  onclick='return paging_ajax4(1)'><a  href='javascript:;'>Trang đầu</a></li><li style='border:none;background:none;padding-top:10px;color:black'>...</li>
					<li class='demtrang' onclick='return paging_ajax4(".$start.")' ><a title='trở lại'  href='javascript:;'> << </a></li>";
				// ======================
				if ($this->page > $this->limitpage){
					if (($this->page + $this->limitpage) >= $this->total_page) $end = $this->total_page;
					else $end = $this->page + $this->limitpage;					
					for ($i = $start; $i <= $end; $i++ ){
						if ($this->page == $i){
							$this->html .= "<li class='demtrang active' onclick='return paging_ajax4(".$i.")' ><a  href='javascript:;'>".$i."</a></li>";
						} else {
							$this->html .= "<li class='demtrang' onclick='return paging_ajax4(".$i.")'><a  href='javascript:;'>".$i."</a></li>";
						}
					}
				} else {
					for ($i = 1; $i <= $this->maxpage ; $i++ ){
						if ($this->page == $i) {
							$this->html .= "<li class='demtrang active' onclick='return paging_ajax4(".$i.")'><a href='javascript:;'>".$i."</a></li>";
						} else {
							$this->html .= "<li class='demtrang'  onclick='return paging_ajax4(".$i.")' ><a href='javascript:;'>".$i."</a></li>";
						}
					}
				}
				// ======================
				
				
				if ((($this->page - $this->limitpage) < $this->total_page) & ($this->total_page - $this->page) > $this->limitpage){
					$this->html .= "<li class='demtrang' onclick='return paging_ajax4(".$i.")'><a title='trang tiếp theo' href='javascript:;'>>></a></li><li onclick='return paging_ajax4(".$this->total_page.")'><a title='Đi đến trang cuối cùng' class='demtrang'  href='javascript:;'>".($this->total_page)."</a></li>";
				
					$this->html.="<li class='demtrang' onclick='return paging_ajax4(".$this->total_page.")'> <a href='javascript:;'>Trang cuối </a></li>";
				}
			} else {
				for($i=1;$i<=$this->total_page;$i++) {
					if ($this->page == $i){
						$this->html .= "<li  class='demtrang active' onclick='return paging_ajax4(".$i.")'><a  href='javascript:;'>".$i."</a></li>";
					} else {
						$this->html .= "<li class='demtrang' onclick='return paging_ajax4(".$i.")'><a onclick='return paging_ajax4(".$i.")' href='javascript:;'>".$i."</a></li>";
					}
				}
				
			}
		}
		if($this->html != '') $this->html = "<ul class='pagination L'>".$this->html."</ul>";

		return $this->html.'';	
	}

	/*<ul class="pagination m-n" style="margin-bottom: 0px;">
		<li><a href="#"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
		<li class="active"><span>1</span></li>
		<li><a href="#">2</a></li>
		<li><a href="#">3</a></li>
		<li><a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
	</ul> */
	public function display( $name_function ){
		if ($this->totalpage()){
			if ( $this->total_page > $this->maxpage ){
				
				//Trường hợp phải thêm dấu mũi tên đầu cuối do số lượng trang vượt maxpage
				$start = $this->page - $this->limitpage;
				if ( ($this->page - $this->limitpage) > 0 ) $this->html.="
															<li onclick='return ".$name_function."(1)'>
																<a  href='javascript:;'><i class='fa fa-angle-double-left' aria-hidden='true'></i></a>
															</li>
															<li onclick='return ".$name_function."(".$start.")' ><a title='trở lại'  href='javascript:;'> <i class='fa fa-angle-left' aria-hidden='true'></i> </a></li>";
															
				// ======================
				if ( $this->page > $this->limitpage ){

					if ( ($this->page + $this->limitpage) >= $this->total_page )
						$end = $this->total_page;
					else 
						$end = $this->page + $this->limitpage;
					
					for ( $i = $start; $i <= $end; $i++ ){
						$this->html .= "<li class='".($this->page == $i ? "active":"")."' onclick='return ".$name_function."(".$i.")'><a href='javascript:;'>".$i."</a></li>";
					}
				} else {
					for ($i = 1; $i <= $this->maxpage ; $i++ ){
						$this->html .= "<li class='".($this->page == $i ? "active":"")."' onclick='return ".$name_function."(".$i.")'><a href='javascript:;'>".$i."</a></li>";
					}
				}
				// ======================
				

				if ( ( ($this->page - $this->limitpage) < $this->total_page ) && ($this->total_page - $this->page) > $this->limitpage){
					$this->html .= "<li class='' onclick='return ".$name_function."(".$i.")'>
										<a title='trang tiếp theo' href='javascript:;'>
										<i class='fa fa-angle-right' aria-hidden='true'></i>
										</a>
									</li>";
					
					$this->html.="	<li class='' onclick='return ".$name_function."(".$this->total_page.")'>
										<a  title='Đi đến trang cuối cùng' href='javascript:;'><i class='fa fa-angle-double-right' aria-hidden='true'></i></a>
									</li>";
				}

			} else {
				for( $i=1; $i <= $this->total_page; $i++) {
					$this->html .= "<li class='".($this->page == $i ? "active":"")."' onclick='return ".$name_function."(".$i.")'><a href='javascript:;'>".$i."</a></li>";
				}
			}
		}

		if($this->html != '') $this->html = "<ul class='pagination m-n' style='margin-bottom: 0px;'>".$this->html."</ul>";

		return $this->html.'';	
	}

}
$paging = new paging();

