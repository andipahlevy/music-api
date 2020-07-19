<?php

namespace App\Http\Controllers\Eks;
use App\Http\Controllers\Controller;
use App\Providers\Master;
use Illuminate\Support\Facades\Cache;
use App\Models\SiteMap;
use App\Jobs\AddSitemap;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
	private $cmd = ['videv:FlushCache','videv:FlushSitemap'];
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Cache::flush();
    }

    public function index()
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

    public function find($q)
	{
		$q = str_replace(['+','-'],[' ',' '],urldecode($q));
		$Master = new Master;
		
		if (Cache::has($q)){
			$RestAPI = Cache::get($q);
		} else {
			$RestAPI = Cache::remember($q, (60*24*15), function () use($Master, $q) {
				$output =  $Master->setEndpoint('youtube/search')
						->setQuery([
							'q'=>$q
						])
						->get();
				return $output;
			});
		}
		$data['api'] = $RestAPI;
		$cond = [
			'loc'	=> url(urlencode($q))
		];
		$save = [
			'lastmod'	=> date('Y-m-d H:i:s'),
			'changefreq'	=> 'monthly',
			'priority'	=> '0.5',
		];
		dispatch((new AddSitemap($cond, $save))->onQueue('low'));
		$mainPage = 'mainContent';
		return view('eks.welcome', compact('data','q','mainPage'));
	}
	
	public function detail($title, $id,$desc, $meta)
	{
		$urlTitle = $title;
		$urlDesc = $desc;
		$title = urldecode($title);
		$met = explode('^nl',base64_decode($meta));
		
		$desc = str_replace(
			['*sls*','*hstag*','*nl*'],
			['/','#','</br>'],
			base64_decode($desc)
		);
		
		$q = $title;
		
		$q = str_replace('+',' ',urldecode($q));
		
		// $Master = new Master;
		// if (Cache::has($q)){
			// $RestAPI = Cache::get($q);
		// } else {
			// $RestAPI = Cache::rememberForever($q, function () use($Master, $title) {
				// $output =  $Master->setEndpoint('youtube/search')
						// ->setQuery([
							// 'q'=>$title
						// ])
						// ->get();
				// return $output;
			// });
		// }
		// $data['api'] = $RestAPI;
		$cond = [
			'loc'	=> url('video/'.$urlTitle.'/'.$id.'/'.$urlDesc.'/'.$meta)
		];
		$cond2 = [
			'loc'	=> url($urlTitle)
		];
		$save = [
			'lastmod'	=> date('Y-m-d H:i:s'),
			'changefreq'	=> 'monthly',
			'priority'	=> '0.5',
		];
		dispatch((new AddSitemap($cond, $save))->onQueue('low'));
		dispatch((new AddSitemap($cond2, $save))->onQueue('low'));
		$mainPage = 'mainContent';
		return view('eks.welcome', compact('q','id','title','desc', 'met','mainPage'));
	}
	
	public function suggest(Request $req)
	{
		$q = $req->input('q');
		$Master = new Master;
		if (Cache::has($q)){
			$RestAPI = Cache::get($q);
		} else {
			$RestAPI = Cache::rememberForever($q, function () use($Master, $q) {
				$output =  $Master->setEndpoint('youtube/search')
						->setQuery([
							'q'=>$q
						])
						->get();
				return $output;
			});
		}
		$data['api'] = $RestAPI;
		return view('eks.list', compact('data'));
	}
	
	public function about()
	{
		$title = env('APP_NAME');
		$desc = env('APP_ABOUT',env('APP_NAME').' collections');
		$mainPage = 'aboutPage';
		return view('eks.welcome', compact('title','desc','mainPage'));
	}
	
	public function contact()
	{
		$title = 'Contact Us';
		$desc = 'For informations you can email us at <a href="mailto:'.env('APP_CONTACT','cascadejeans@gmail.com').'">'.env('APP_CONTACT','cascadejeans@gmail.com').'</a>';
		$mainPage = 'aboutPage';
		return view('eks.welcome', compact('title','desc','mainPage'));
	}
	
	public function shop()
	{
		$title = env('APP_NICK').' Products';
		$desc = env('APP_AMAZON_ADS2',null);
		$mainPage = 'aboutPage';
		return view('eks.welcome', compact('title','desc','mainPage'));
	}
	
	public function cmdrun($cmd)
	{
		if(in_array($cmd, $this->cmd)){
			$exitCode = Artisan::call($cmd);
		}else{
			return '<p style="color:red;">command not found!</p>';
		}
		
		return $exitCode == 0 ? '<p style="color:green;">Command executed!</p>' : '<p style="color:orange;">Something wrong!</p>';
	}
	
	public function sitemap()
	{
		$content = "<?xml version='1.0' encoding='UTF-8'?>"."\n";
		$content .= "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>"."\n";

		$content .= "
		<url>
		 <loc>".url()."</loc>
		 <lastmod>2020-03-05T18:00:15+00:00</lastmod>
		 <priority>1.00</priority>
		 <changefreq>daily</changefreq>
		</url>
		<url>
		 <loc>".url('sitemap/xml')."</loc>
		 <lastmod>2020-03-05T18:00:15+00:00</lastmod>
		 <priority>0.8</priority>
		 <changefreq>daily</changefreq>
		</url>";
		
		$sm = SiteMap::all();
		foreach($sm as $row)
		{
		 $locc = preg_replace('/&(?!#?[a-z0-9];)/', '&amp;', $row['loc']);
		 $content .= "<url>";
		 $content .= "<loc>".str_replace(' ','+',$locc)."</loc>";
		 $content .= "<lastmod>".gmdate('Y-m-d\TH:i:s+00:00', strtotime($row['lastmod']))."</lastmod>";
		 $content .= "<priority>0.5</priority>";
		 $content .= "<changefreq>monthly</changefreq>";
		 $content .= "</url>";
		 
		}

		$content .= "</urlset>";
		
		$response = Response::create($content, 200);
		$response->header('Content-Type', 'text/xml');
        $response->header('Cache-Control', 'public');
        $response->header('Content-Description', 'File Transfer');
        // $response->header('Content-Disposition', 'attachment; filename=sitemap.xml');
        $response->header('Content-Transfer-Encoding', 'binary');
        return $response;
	}
}
