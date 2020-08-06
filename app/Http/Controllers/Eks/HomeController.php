<?php

namespace App\Http\Controllers\Eks;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Youtube;

class HomeController extends Controller
{
	
    public function __construct(Request $req)
    {
		if($req->header('Authorization') != env('TOKENKU')){
			// header('Content-Type: application/json');
			// echo json_encode(['code' => '401', 'contents' => 'Invalid token']);
			// die;
		}
		// Cache::flush();die;
    }
	
	public function generate_banner()
	{
		$dest = imagecreatefromjpeg(base_path('public/assets/images/bg1.jpg'));
		$logo = base_path('public/assets/images/phone.png');
		$src = imagecreatefrompng($logo);
		$size = getimagesize($logo);
		
		list($w, $h) = getimagesize($logo);
		$cen = (imagesx($dest)/2) - ($w/2);
		$cen2 = (imagesx($dest)/2.5) - ($h/2);
		imagecopymerge($dest, $src, $cen, $cen2, 0, 0, $size[0], $size[1], 80);
		
		$white = imagecolorallocate($dest, 255, 255, 255);
		$grey = imagecolorallocate($dest, 128, 128, 128);
		$black = imagecolorallocate($dest, 0, 0, 0);
		
		$text = 'Download App'; //TITLE
		
		$font = base_path('public/assets/font/Dead Revolution.otf');
		$size = "20";
		$box = imageftbbox( $size, 0, $font, $text ); 
		$x = (410 - ($box[2] - $box[0])) / 2; 
		$y = (1700 - ($box[1] - $box[7])) / 2; 
		$y -= $box[7]; 
		
		$fontwidth = 50;
		
		$center = (imagesx($dest)/2) - ($fontwidth*(strlen($text)/2));
		
		imagettftext(
			$dest, 
			70, 
			0, 
			$center, // margin left
			$y, // margin top
			$black, 
			$font, 
			$text);
		
		header('Content-Type: image/jpeg');
		imagejpeg($dest, base_path("public/assets/banner/sample_large.jpg"));
		//echo '<img src="'.base_path("public/assets/banner/sample_large.jpg").'" alt="">';
	}
	
	public function generate_icon($title)
	{
		
		$dest = imagecreatefromjpeg(base_path('public/assets/images/img1.jpg'));
		$logo = base_path('public/assets/images/sample.jpg');
		$src = imagecreatefromjpeg($logo);
		$size = getimagesize($logo);
		
		list($w, $h) = getimagesize($logo);
		$cen = (imagesx($dest)/2) - ($w/2);
		$cen2 = (imagesx($dest)/2.5) - ($h/2);
		imagecopymerge($dest, $src, $cen, $cen2, 0, 0, $size[0], $size[1], 80);
		
		$white = imagecolorallocate($dest, 255, 255, 255);
		$grey = imagecolorallocate($dest, 128, 128, 128);
		$black = imagecolorallocate($dest, 0, 0, 0);
		
		$text = urldecode($title); //TITLE
		
		$font = base_path('public/assets/font/Dead Revolution.otf');
		$size = "20";
		$box = imageftbbox( $size, 0, $font, $text ); 
		$x = (410 - ($box[2] - $box[0])) / 2; 
		$y = (1700 - ($box[1] - $box[7])) / 2; 
		$y -= $box[7]; 
		
		$fontwidth = 50;
		
		$center = (imagesx($dest)/2) - ($fontwidth*(strlen($text)/2));
		
		imagettftext(
			$dest, 
			70, 
			0, 
			$center, // margin left
			$y, // margin top
			$black, 
			$font, 
			$text);
		
		// header('Content-Type: image/jpeg');
		
		$size = [
			'hdpi'=>[72,300],
			'ldpi'=>[36,112],
			'mdpi'=>[48,150],
			'xhdpi'=>[96,450],
			'xxhdpi'=>[144,600],
			'xxxhdpi'=>[192,750],
		];
		
		imagepng($dest, base_path("public/assets/generated/sample_large.png"));
		// die;
		$this->generate_image(base_path("public/assets/generated/sample_large.png"), '512', base_path("public/assets/generated/logo512.png"));
		
		foreach($size as $k=>$s){
			foreach($s as $kk=>$v){
				$source = base_path("public/assets/generated/sample_large.png");
				$nmFile = $kk==0?'icon':'logo';
				$this->generate_image($source, $v, base_path("public/assets/generated/drawable-$k/$nmFile.png"));
			}
		}
		
		$this->replace_xml_string($text);
		
	}
	
	public function generate_image($source, $v, $desti){
		list($width, $height) = getimagesize($source);
		$newwidth = $v;
		$newheight = $v;
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		$source = imagecreatefrompng($source);
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagepng($thumb, $desti);	
	}
	
	public function replace_xml_string($app_name){
		$str='<?xml version="1.0" encoding="utf-8"?>
				<resources>
					<string name="app_name">'.$app_name.'</string>
					<string name="title_activity_kimera">'.$app_name.'</string>
				</resources>
				';

		file_put_contents(base_path("public/assets/generated/values/strings.xml"), $str);
		file_put_contents(base_path("public/assets/generated/values-v21/strings.xml"), $str);
	}
	
	public function playlist($q){
		header('Content-Type: application/json');
		$respon = [];
		$data = [];
		$day = 1;
		if (Cache::has($q)){
			$respon['contents'] = Cache::get($q);
		}else{
			$video = Youtube::getPlaylistItemsByPlaylistId($q);
			$respon['contents'] = Cache::remember($q, (60*(24*$day)), function () use($video) {
				foreach($video['results'] as $result){
					$ddetail['duration']	= '';
					
					if(strlen($ddetail['duration']) > 4 || strlen($ddetail['duration']) < 1){
						// continue;
					}
					$ddetail['title'] 		= $this->replace($result->snippet->title);
					$ddetail['vid'] 		= $result->contentDetails->videoId;
					$ddetail['oriDesc']		= '';
					
					$ddetail['img']			= $result->snippet->thumbnails->medium->url;
					$data[] = $ddetail;
				}
				
				return $data;	
			 });
		}
		
		echo json_encode($respon
			//, JSON_PRETTY_PRINT
		);
	}
	
	public function search($q){
		header('Content-Type: application/json');
		$respon = [];
		$data = [];
		$day = 1;
		if (Cache::has($q)){
			$respon['contents'] = Cache::get($q);
		}else{
			$params = [
				'q'             => $q,
				'type'          => 'video',
				'part'          => 'id, snippet',
				'maxResults'    => 20
			];
			$video = Youtube::searchAdvanced($params, true);
			if(isset($video['results'])){
				$respon['contents'] = Cache::remember($q, (60*(24*$day)), function () use($video) {
					foreach($video['results'] as $result){
						$ddetail['duration']	= '';
						
						if(strlen($ddetail['duration']) > 4 || strlen($ddetail['duration']) < 1){
							// continue;
						}
						$ddetail['title'] 		= $this->replace($result->snippet->title);
						$ddetail['vid'] 		= $result->id->videoId;
						$ddetail['oriDesc']		= '';
						
						$ddetail['img']			= $result->snippet->thumbnails->medium->url;
						$data[] = $ddetail;
					}
					
					return $data;	
				 });
			}else{
				$respon['contents'];
			}
		}
		
		echo json_encode($respon
			//, JSON_PRETTY_PRINT
		);
	}
	
	public function xsearch($q){
		$respon = [];
		$data = [];
		if (Cache::has($q)){
			// echo 1;die;
			$respon['contents'] = Cache::get($q);
		}else{
			// echo 2;die;
			$html = $this->get_html(urlencode($q));
			echo($html);die;
			$exp = explode('"itemSectionRenderer":{"contents":',$html)[1];
			$exp = explode('"continuations":',$exp)[0];
			$html = str_replace(';','',$exp);
			$html = $html.'<endHTML>';
			$data = str_replace(',<endHTML>','',$html);
			$datax = [];
			$datax = (json_decode($data));
			print_r($datax);die;
			if($datax){
				$jmld = count($datax);
				$day = env('CACHE_DAY',30);
				$respon['contents'] = Cache::remember($q, (60*(24*$day)), function () use($datax,$jmld) {
					foreach($datax as $k=> $e){
						if(isset($e->videoRenderer)){
							$ddetail['duration']	= $e->videoRenderer->lengthText->simpleText;
							if(strlen($ddetail['duration']) > 4 || strlen($ddetail['duration']) < 1){
								continue;
							}
							$ddetail['title'] 		= $e->videoRenderer->title->runs[0]->text;
							$ddetail['vid'] 		= $e->videoRenderer->videoId;
							$ddetail['oriDesc']		= $e->videoRenderer->descriptionSnippet->runs[0]->text;
							
							$ddetail['img']			= $e->videoRenderer->thumbnail->thumbnails[(count($e->videoRenderer->thumbnail->thumbnails) - 1)]->url;

							$data[] = $ddetail;
							if($jmld > 15 && $k===15) 
								break;
						}
					}
					return $data;	
				 });
				
			}else{
				$respon['contents'] = [];
			}
		}
		
		echo json_encode($respon
			//, JSON_PRETTY_PRINT
		);
	}

    public function xindex()
	{
		echo 1;die;
		// $Master = new Master;
		
		if (Cache::has('ytrend')){
			$RestAPI = Cache::get('ytrend');
		} else {
			$RestAPI = Cache::remember('ytrend', (60*24), function () use($Master) {
				return  $Master->setEndpoint('youtube/search')
						->setQuery([
							'q'=>env('APP_NAME')
						])
						->get();
			});
		}
		
		$data['api'] = $RestAPI;
		$mainPage = 'mainContent';
		return view('eks.welcome', compact('data','mainPage'));
	}
	
	function get_html($query){
		return file_get_html("https://m.youtube.com/results?search_query=$query");
	}

	function clean($string) {
	   // $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

	   // return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	   return preg_replace("/[^A-Za-z0-9\-\']/", '', $string); // Removes special chars.
	}

	function replace($str){
		$a = ['VIDEO','LYRIC','LYRICS','LIRIK'];
		$b = ['','','',''];
		$text = str_replace($a, $b, strtoupper($str));
		
		$tmp = ucwords(strtolower($text));
		$a = ['( ',' )','()'];
		$b = ['(',')',''];
		return $text = str_replace($a, $b, strtoupper($tmp));
	}
}
