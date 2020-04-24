<?php
namespace App\Market\Traits;

Trait  MetaTags{
	public $metaTagList = [];
	public $metaTags = '';
	public $metaUrl = '';

	function generateMetaTags(){

			$meta = $this->metaTagList;
			// var_dump($meta);
			// die();
			if(is_array($meta)){
			$ogTags  = $twitter = '';$metadesc='';
			$metaLink = '';
			foreach ($meta as $title => $content) {
			$content = preg_replace('#["]#', '', $content);


			if($title == "name"){
			// <meta name="'.$title.'" content="'.$content.'" />
			$metaLink .= '
			<meta itemprop="'.$title.'" content="'.$content.'" />
			';
			$twitter .= '
			<meta name="twitter:title" content="'.$content.'" />';
			$ogTags .= '
			<meta property="og:title" content="'.$content.'" />
			';
			continue;
			} elseif($title == 'image'){
			$metaLink .= '
			<meta itemprop="image" content="'.$content.'" />';
			$twitter .='
			<meta name="twitter:image:src" content="'.$content.'" />';
			$ogTags .= '
			<meta property="og:image" itemprop="image"  content="'.$content.'" />
			';
			continue;
			} elseif($title == 'site' || $title == 'creator' ){
			$twitter .= '
			<meta name="twitter:'.$title.'" content="'.$content.'" />
			';
			continue;
			} elseif($title == 'site_name' || $title == 'url' || $title == "type"){
			$ogTags .= '
			<meta property="og:'.$title.'" content="'.$content.'" />
			';
			continue;
			}

			if($title=='description'){
			$metadesc = '<meta name="description" content="'.$content.'">
			';
			}

			$metaLink .= '
			<meta itemprop="'.$title.'" content="'.$content.'" />
			';
			$twitter .= '
			<meta name="twitter:'.$title.'" content="'.$content.'" />
			';
			$ogTags .= '
			<meta property="og:'.$title.'" content="'.$content.'" />
			';

			}

			$this->metaTags = $metadesc.' <!-- Google / Search Engine Tags --> '. $metaLink.' <!-- Facebook Meta Tags --> '.$ogTags.'  <!-- Twitter Meta Tags --> '.$twitter;

			}
			return $this->metaTags;
		}

		public function googleReviewTag()
		{
			# code...
		}

		public function googleProductTag()
		{
			# code...
		}

		public function facebookProductTag()
		{
			# code...
		}
}
