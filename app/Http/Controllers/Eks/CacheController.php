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
	
}
