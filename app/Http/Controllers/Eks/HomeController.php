<?php

namespace App\Http\Controllers\Eks;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Youtube;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;


class HomeController extends Controller
{
	
    public function __construct(Request $req)
    {
		if($req->header('Authorization') != env('TOKENKU')){
			header('Content-Type: application/json');
			echo json_encode(['code' => '401', 'contents' => 'Invalid token']);
			die;
		}
    }
	
	public function myapp()
	{
		$query = 'Berita';
        $url = "https://play.google.com/store/apps/developer?id=Videv+Studio";
        // $url = "https://play.google.com/store/apps/developer?id=ValiantKiwi+Industries";
        $goutteClient = new Client();
		new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $goutteClient->request('GET', $url);
		
		$content = [];
		$len = count($crawler->filterXPath('//body/div[1]/div[4]/c-wiz/div/div[2]/c-wiz/c-wiz/c-wiz/div/div[2]/div'));
		for($i=1; $i<=$len; $i++){
			$name = $crawler->filterXPath('//body/div[1]/div[4]/c-wiz/div/div[2]/c-wiz/c-wiz/c-wiz/div/div[2]/div['.$i.']/c-wiz/div/div/div[2]/div/div/div[1]/div/div/div[1]/a/div')->text();
			$img  = $crawler->filterXPath('//body/div[1]/div[4]/c-wiz/div/div[2]/c-wiz/c-wiz/c-wiz/div/div[2]/div['.$i.']/c-wiz/div/div/div[1]/div/span[1]/img')->attr('data-src');
			$url  = $crawler->filterXPath('//body/div[1]/div[4]/c-wiz/div/div[2]/c-wiz/c-wiz/c-wiz/div/div[2]/div['.$i.']/c-wiz/div/div/div[2]/div/div/div[1]/div/div/div[1]/a')->attr('href');
			if($name == 'Moon Hunter Game'){
				continue;
			}
			$content[] = [
				'name'	=>$name,
				'img'	=>route('alias',['url'=>base64_encode($img)]),
				'url'	=>explode('?',$url)[1],
			];
		}
		
        if(count($content) > 0) {
            $result['code'] = "200";
            $result['contents'] = $content;
        }else{
            $result['code'] = "404";
            $result['contents'] = "Empty";
        }

        return response()->json($result);
	}
	
	public function urlalias(){
		$route = route('alias',['url'=>base64_encode('https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png')]);
		// die;
		echo '<img src="'.$route.'" alt="">';
	}
	
	public function generate_all()
	{
		$get = file_get_contents('C:\xampp\htdocs\mp3-maudi\app\data.json');
		$M = json_decode($get);
		
		$this->generate_desc($M->app_name, $M->playlist_id);
		$this->generate_banner($M->app_name, $M->playlist_id);
		$this->generate_ss();
		// $this->generate_icon($M->app_name);
	}
	
	public function generate_desc($appName, $id)
	{
		$video	= Youtube::getPlaylistItemsByPlaylistId($id);
		$file = base_path('public/assets/playstore/DESC.txt');
		$cont = "Halo guys, kalo kalian ingin mendengarkan lagu $appName kalian bisa mendownload aplikasi pemutar musik ini.\r\nAnda tidak perlu lagi menghabiskan waktu untuk googling untuk mencari lagu $appName. Dalam aplikasi ini terdapat lagu-lagu hits yang mungkin anda cari seperti musik-musik di bawah ini.\r\n\r\n";
		$limit = 9;
		foreach($video['results'] as $k=>$result){
			$tit = $this->replace($result->snippet->title);
			if($tit == 'DELETED '){
				$limit++;
				continue;
			}
			$cont .= $tit."\r\n";
			if($k==$limit){
				break;
			}
		}
		$cont .= $tit."\r\nDan Masih banyak lagu lainnya.\r\n";
		$cont .= "\r\nKamu juga bisa menggunakan fitur pencarian jika lagu kesukaan kamu tidak ada di list. Semoga teman-teman sekalian terhibur dengan aplikasi ini.";
		// file_put_contents($file, $cont, FILE_APPEND | LOCK_EX);
		file_put_contents($file, $cont, LOCK_EX);
	}
	
	public function generate_banner($appName)
	{
		$capture = [];
		if ($handle = opendir(base_path('public/assets/capture/'))) {

			while (false !== ($entry = readdir($handle))) {

				if ($entry != "." && $entry != "..") {
					$capture[] = base_path('public/assets/capture/'.$entry);
				}
			}

			closedir($handle);
		}
		$image_1 = imagecreatefrompng(base_path("public/assets/images/bannerBg.png"));
		$image_2 = imagecreatefromjpeg($capture[1]);
		$image_3 = imagecreatefrompng(base_path('public/assets/images/phone.png'));
		imagealphablending($image_1, true);
		imagesavealpha($image_1, true);
		
		list($w, $h) = getimagesize($capture[1]);
		$x = (imagesx($image_1)/3) - ($w/2);
		$y = (imagesx($image_1)/3.85) - ($h/2);
		imagecopy($image_1, $image_2, $x-200, $y, 0, 0, $w, $h);
		
		list($w, $h) = getimagesize(base_path('public/assets/images/phone.png'));
		$x = (imagesx($image_1)/3) - ($w/2);
		$y = (imagesx($image_1)/4) - ($h/2);
		imagecopy($image_1, $image_3, $x-200, $y+50, 0, 0, $w, $h);
		
		$text = "Download Aplikasi \r\nPemutar Musik \r\n$appName \r\nDi Google Playstore"; //TITLE
		$white = imagecolorallocate($image_1, 255, 255, 255);
		$font = base_path('public/assets/font/ARI.ttf');
		$size = "150";
		$box = imageftbbox( $size, 0, $font, $text ); 
		$x = (410 - ($box[2] - $box[0])) / 2; 
		$y = (1700 - ($box[1] - $box[7])) / 2; 
		$y -= $box[7]; 
		
		$fontwidth = 50;
		
		$center = (imagesx($image_1)/2) - ($fontwidth*(strlen($text)/2));
		
		imagettftext(
			$image_1, 
			$size, 
			0, 
			$center+1200, // margin left
			$y+600, // margin top
			$white, 
			$font, 
			$text);
		
		imagepng($image_1, base_path("public/assets/playstore/banner.png"));
		
		//resize to playstore format
		// $this->resizeImage(2598,2598,base_path("public/assets/playstore/banner.png"),base_path("public/assets/playstore/banner_2598.png")	);
		$this->resizeImage(1024,500,base_path("public/assets/playstore/banner.png"),base_path("public/assets/playstore/banner_1024.png"));
		
	}
	
	public function resizeImage($p,$l, $s, $o)
	{
		list($width, $height) = getimagesize($s);
		$newwidth = 1024 ;
		$newheight = 500 ;
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		$source = imagecreatefrompng($s);
		imageCopyResampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagepng($thumb, $o);
	}
	
	public function generate_ss()
	{
		$capture = [];
		if ($handle = opendir(base_path('public/assets/capture/'))) {

			while (false !== ($entry = readdir($handle))) {

				if ($entry != "." && $entry != "..") {
					$capture[] = base_path('public/assets/capture/'.$entry);
				}
			}

			closedir($handle);
		}
		
		foreach($capture as $k=>$cap){
		
			$image_1 = imagecreatefromjpeg(base_path("public/assets/images/bg$k.jpg"));
			$image_2 = imagecreatefromjpeg($cap);
			$image_3 = imagecreatefrompng(base_path('public/assets/images/phone.png'));
			imagealphablending($image_1, true);
			imagesavealpha($image_1, true);
			
			list($w, $h) = getimagesize($cap);
			$cen = (imagesx($image_1)/2) - ($w/2);
			$cen2 = (imagesx($image_1)/0.95) - ($h/2);
			imagecopy($image_1, $image_2, $cen, $cen2, 0, 0, $w, $h);
			
			list($w, $h) = getimagesize(base_path('public/assets/images/phone.png'));
			$cen = (imagesx($image_1)/2) - ($w/2);
			$cen2 = (imagesx($image_1)/0.97) - ($h/2);
			imagecopy($image_1, $image_3, $cen, $cen2, 0, 0, $w, $h);
			
			imagejpeg($image_1, base_path("public/assets/playstore/capture_$k.jpg"));
		}
	}
	
	public function generate_icon($title)
	{
		
		$dest = imagecreatefromjpeg(base_path('public/assets/images/img1.jpg'));
		$logo = base_path('public/assets/images/sample.jpg');
		$src = imagecreatefromjpeg($logo);
		
		list($w, $h) = getimagesize($logo);
		$cen = (imagesx($dest)/2) - ($w/2);
		$cen2 = (imagesx($dest)/2.5) - ($h/2);
		imagecopymerge($dest, $src, $cen, $cen2, 0, 0, $w, $h, 80);
		
		$white = imagecolorallocate($dest, 255, 255, 255);
		$grey = imagecolorallocate($dest, 128, 128, 128);
		$black = imagecolorallocate($dest, 0, 0, 0);
		
		$text = 'Lagu '.urldecode($title); //TITLE
		
		$font = base_path('public/assets/font/Dead Revolution.otf');
		$size = "60";
		$box = imageftbbox( $size, 0, $font, $text ); 
		$y = (1700 - ($box[1] - $box[7])) / 2; 
		$y -= $box[7]; 
		
		$bbox = imagettfbbox($size, 0, $font, $text);
		$center1 = (imagesx($dest) / 2) - (($bbox[2] - $bbox[0]) / 2);
		
		
		// $center = (imagesx($dest)/2) - ($fontwidth*(strlen($text)/2));
		
		imagettftext(
			$dest, 
			$size, 
			0, 
			$center1, // margin left
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
	
	public function generate_image($source, $v, $desti)
	{
		list($width, $height) = getimagesize($source);
		$newwidth = $v;
		$newheight = $v;
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		$source = imagecreatefrompng($source);
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagepng($thumb, $desti);	
	}
	
	public function replace_xml_string($app_name)
	{
		$str='<?xml version="1.0" encoding="utf-8"?>
				<resources>
					<string name="app_name">'.$app_name.'</string>
					<string name="title_activity_kimera">'.$app_name.'</string>
				</resources>
				';

		file_put_contents(base_path("public/assets/generated/values/strings.xml"), $str);
		file_put_contents(base_path("public/assets/generated/values-v21/strings.xml"), $str);
	}
	
	public function playlist($q)
	{
		header('Content-Type: application/json');
		$respon = [];
		$data = [];
		$day = 1;
		if (Cache::has($q)){
			$respon['contents'] = Cache::get($q);
		}else{
			$video = Youtube::getPlaylistItemsByPlaylistId($q);
			
			// echo json_encode($video['results']);die;
			
			$respon['contents'] = Cache::remember($q, (60*(24*$day)), function () use($video) {
				foreach($video['results'] as $result){
					if(@$result->snippet->thumbnails->medium->url == ''){
						continue;
					}
					$ddetail['duration']	= '';
					
					if(strlen($ddetail['duration']) > 4 || strlen($ddetail['duration']) < 1){
						// continue;
					}
					$ddetail['title'] 		= base64_encode(htmlspecialchars_decode($this->replace($result->snippet->title), ENT_QUOTES));
					$ddetail['vid'] 		= $result->contentDetails->videoId;
					$ddetail['oriDesc']		= '';
					
					if(@$result->snippet->thumbnails->medium->url != ''){
						$ddetail['img']			= route('alias',['url'=>base64_encode($result->snippet->thumbnails->medium->url)]);
					}
					$data[] = $ddetail;
				}
				
				return $data;	
			 });
		}
		
		echo json_encode($respon
			//, JSON_PRETTY_PRINT
		);
	}
	
	public function search($q)
	{
		
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
			// dd($video);
			if($video['results']){
				$respon['contents'] = Cache::remember($q, (60*(24*$day)), function () use($video) {
					foreach($video['results'] as $result){
						$ddetail['duration']	= '';
						
						if(strlen($ddetail['duration']) > 4 || strlen($ddetail['duration']) < 1){
							// continue;
						}
						$ddetail['title'] 		= base64_encode(htmlspecialchars_decode($this->replace($result->snippet->title), ENT_QUOTES));
						$ddetail['vid'] 		= $result->id->videoId;
						$ddetail['oriDesc']		= '';
						
						$ddetail['img']			= @$result->snippet->thumbnails->medium->url ? route('alias',['url'=>base64_encode($result->snippet->thumbnails->medium->url)]) : '';
						$data[] = $ddetail;
					}
					
					return $data;	
				 });
			}else{
				$respon['contents'] = [];
			}
		}
		
		echo json_encode($respon,TRUE);die;
		
	}
	
	public function xsearch($q)
	{
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

	function clean($string)
	{
	   // $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

	   // return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	   return preg_replace("/[^A-Za-z0-9\-\']/", '', $string); // Removes special chars.
	}

	function replace($str)
	{
		$a = ['VIDEO','LYRIC','LYRICS','LIRIK','CLIP','KLIP'];
		$b = ['','','','','',''];
		$text = str_replace($a, $b, strtoupper($str));
		
		$tmp = ucwords(strtolower($text));
		$a = ['( ',' )','()','  '];
		$b = ['(',')','',' '];
		return $text = str_replace($a, $b, strtoupper($tmp));
	}
}
