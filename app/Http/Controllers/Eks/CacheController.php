<?php

namespace App\Http\Controllers\Eks;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CacheController extends Controller
{
	
    public function __construct()
    {
    }
	
	
	public function clear()
	{
		Cache::flush();die;
	}
	
	public function alias($url)
	{
		$img = base64_decode($url);
		$fp = fopen($img, 'rb');

		header('Content-type: image/jpeg;');
		foreach ($http_response_header as $h) {
			if (strpos($h, 'Content-Length:') === 0) {
				header($h);
				break;
			}
		}

		fpassthru($fp);
		exit;
	}
	
}
