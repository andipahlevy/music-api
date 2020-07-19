<?php

namespace App\Http\Controllers\Eks;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
	
    public function __construct()
    {
        // Cache::flush();
    }
	
	public function search($q){
		$respon = [];
		$data = [];
		if (Cache::has($q)){
			$respon['contents'] = Cache::get($q);
		}else{
			$html = $this->get_html(urlencode($q));
			$exp = explode('"itemSectionRenderer":{"contents":',$html)[1];
			$exp = explode('"continuations":',$exp)[0];
			$html = str_replace(';','',$exp);
			$html = $html.'<endHTML>';
			$data = str_replace(',<endHTML>','',$html);
			$datax = (json_decode($data));
			$respon['contents'] = Cache::remember($q, (60*24), function () use($datax) {
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
						if($k===15) 
							break;
					}
				}
				return $data;	
			 });
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
	   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

	   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}

	function replace($str){
		$a = ['VIDEO','LYRIC','LYRICS','LIRIK','  '];
		$b = ['','','','',' '];
		$text = str_replace($a, $b, strtoupper($str));
		
		return ucwords(strtolower($text));
	}
}
