<?php
class Pager
{
	public $records = 0;
	public $pages = 0;
	public $page = 0;
	public $offset = 0;
	public $limit = 0;
	public $mode = 'all'; //or 'fixed';

	private $links = 0;
	private $html = array('');
	private $url = '';
	private $info = array('');
	private $call = 0;
	private $max_records = 0;

	function init($records)
	{
		//trace($this);
		$this->call++;
		
		$call = $this->call;

		$records = intval($records);
				
		$pages = ceil($records/$this->listing);

		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		
		$page = $page < 1 ? 1 : ($page > $pages ? $pages : $page);
		
		$this->limit = $this->getLimit($this->listing, $page, $records);
		$this->offset = $this->getOffset($page, $this->listing, $records);
		$this->setInfo($this->offset + 1, $this->offset + $this->limit, $records, $call);
		
		$html = $this->getHtml($pages, $page, $this->links);

		if($this->mode == 'all') $this->setHtml($call, $html);	
		
		if($call == 1 || $records > $this->max_records)
		{
			$this->max_records = $records;
			$this->setHtml(0, $html);
		}

		$this->records = $records;
		$this->pages = $pages;
		$this->page = $page;
		//trace('call = '.$this->call);
		//trace('records = '.$this->records);
		// trace('pages = '.$this->pages);
		// trace('page = '.$this->page);
		// trace('offset = '.$this->offset);
		// trace('limit = '.$this->limit);
		// trace($this->info);
		// trace($this->html);
		// trace('<hr>');
		//trace($this);
	}

	private function setHtml($call, $html)
	{
		$this->html[$call] = $html;
	}

	private function getLimit($listing, $page, $records)
	{
		if($records == 0) return 0;
		$limit = $listing * $page; 
		$limit = $limit > $records ? $listing - $limit + $records : $listing;
		if($limit < 0) $limit = 0;
		return $limit;
	}

	private function getOffset($page, $listing, $records)
	{
		if($records == 0) return 0;
		
		if($page == 0) $page = 1;
		
		$offset = ($page - 1) * $listing;
		
		if($offset < 0) $offset = 0;

		return $offset;
	}

	private function setInfo($from, $to, $records, $call)
	{
		if($records == 0) $from = 0;
		
		$this->info[$call] = $from.' to '.$to.' of '. $records;
	}

	function __construct($listing = 20, $links = 10)
	{
		$this->listing = intval($listing);
		$this->links = intval($links);

		$this->setUrl();
	}

	private function getHtml($pages, $page, $links)
	{
		if($pages < 2) return '';
		
		$links = $pages < $links ? $pages : $links;
		$odd = $links % 2;
		$mid = floor($links / 2);
		$start = $page - $mid;
		$end = $page + $mid;
		$left = 1 - $start;
		$right = $end - $pages;

		if($left > 0)
		{
			$start += $left;
			$end += $left - ($odd ? 0 : 1);

		}
		elseif($right > 0)
		{
			$start -= $right - ($odd ? 0 : 1);
			$end -= $right;
		}

		$html = '<div class="paging">';

		if($start != 1) $html .= '<a href="'.$this->getUrl(1).'" title="go to first page">&lt;&lt;</a>';
		if($page != 1) $html .= '<a href="'.$this->getUrl($page - 1).'" title="go to previous page">&lt;</a>';

		for($cpage = $start; $cpage <= $end; $cpage++)
		{
			if($cpage == $page) $html .= '<a class="current" title="current page">'.$cpage.'</a>';
			else $html .= '<a href="'.$this->getUrl($cpage).'" title="go to page '.$cpage.'">'.$cpage.'</a>';
		}

		if($page != $pages) $html .= '<a href="'.$this->getUrl($page + 1).'" title="go to next page">&gt;</a>';
		if($end != $pages) $html .= '<a href="'.$this->getUrl($pages).'" title="go to last page">&gt;&gt;</a>';

		$html .= '</div>';

		return $html;
	}

	private function setUrl()
	{
		$_GET['page'] = isset($_GET['page']) ? intval($_GET['page']) : 1;

		$this->url = SITE_URL.substr($_SERVER['PHP_SELF'], 13);
		$append = '?';
		
		foreach($_GET as $key=>$value)
		{
			$this->url .= $append.$key.'='.$value;
			$append = '&';
		}
	}

	private function getUrl($page)
	{
		return preg_replace('/page=\d+/', '\1page='.$page, $this->url);
	}

	function getLinks($call = 0)
	{
		if($this->mode == 'multiple' && $call > 0) return '';
		
		return $this->html[$call + 0];
	}

	function getInfo($call = 1)
	{
		if($this->mode == 'multiple' && $call > 1) return '';
		
		return $this->info[$call + 0];
	}
	
	function multiple($lists)
	{
		$this->mode = 'multiple';
	}
}