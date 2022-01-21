<?php

namespace App\Http\Controllers\V3;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Youtube;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;
use Google_Service_Books;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
	
    public function __construct(Request $req)
    {
		$this->key2 = 'AIzaSyBEbvqE5IXkGwlP515NQFGDzupWfW_xtNA';
		$this->key3 = 'AIzaSyC3YT1yWTE_XCVGAzEw2BH0jSp92UnnInI';
		if($req->header('token') != env('TOKENKU')){
			header('Content-Type: application/json');
			echo json_encode(['code' => '401', 'contents' => 'Invalid token']);
			die;
		}
    }
	
	public function gdrive_find(Request $req)
	{
		$client = $this->getClient()[1];
		if(!$this->getClient()[0]){
			$this->send_mail();
			die;
		}
		if($req->input('type') == 'folder'){
			$q = "name = '{$req->input('name')}' and mimeType = 'application/vnd.google-apps.folder' and trashed=false";
			$parents = ["0AJcO6d0iN8ynUk9PVA"];
		}else{
			$q = "name = '{$req->input('name')}' and mimeType contains 'audio' and trashed=false";
			$parents = [$req->input('folder')];
		}
		$service = new Google_Service_Drive($client);
		$optParams = array(
			'q' => $q,
			'spaces' => "drive",
			// 'fields' => 'nextPageToken, files(id, name)',
			'fields' => 'nextPageToken, files(id, name)',
			'supportsAllDrives' => true ,
			'corpora' => 'drive' ,
			'driveId' => '0AJcO6d0iN8ynUk9PVA' ,
			'includeItemsFromAllDrives' => true ,
		);
		$rsp = [];
		$rsp['code'] = 0;
		$results = $service->files->listFiles($optParams);
		// \Log::info('$results["files"]');
		// \Log::info($results['files']);
		// print_r($results);die;
		if(isset($results['files'])){
			if($req->input('type') == 'folder'){
				if($results['files']){
					$rsp['code'] = 1;
					$rsp['contents'] = [
						'id'=>$results['files'][0]['id'],
						'name'=>$results['files'][0]['name'],
						'files'=>$this->gdrive_list_by_folder($results['files'][0]['id'])
					];
					// \Log::info('Masuk A');
					// \Log::info($rsp);
				}else{
					$folder = new Google_Service_Drive_DriveFile();
					$folder->setName($req->input('name'));
					$folder->setParents(["0AJcO6d0iN8ynUk9PVA"]);
					$folder->setMimeType('application/vnd.google-apps.folder');
					$createdFolder = $service->files->create($folder, array(
						'supportsAllDrives' => true 
					));
					$rsp['code'] = 2;
					$rsp['contents'] = ['id'=>$createdFolder['id'],'name'=>$req->input('name')];
					// \Log::info('Masuk B');
					// \Log::info($rsp);
				}
			}else{
				if($results['files']){
					$rsp['code'] = 1;
					$rsp['contents'] = [
						'id'=>$results['files'][0]['id'],
						'name'=>$results['files'][0]['name'],
					];
				}				
			}
		}
		header('Content-Type: application/json');
		echo json_encode($rsp);
	}
	
	public function gdrive_find2(Request $req)
	{
		$client = $this->getClient()[1];
		if(!$this->getClient()[0]){
			$this->send_mail();
			die;
		}
		if($req->type == 'folder'){
			$q = "name = '{$req->name}' and mimeType = 'application/vnd.google-apps.folder' and trashed=false";
			$parents = ["0AJcO6d0iN8ynUk9PVA"];
		}else{
			$q = "name = '{$req->name}' and mimeType contains 'audio' and trashed=false";
			$parents = [$req->folder];
		}
		$service = new Google_Service_Drive($client);
		$file = new Google_Service_Drive_DriveFile();
		$file->setParents($parents);
		$optParams = array(
			'q' => $q,
			'spaces' => "drive",
			// 'fields' => 'nextPageToken, files(id, name)',
			'fields' => 'nextPageToken, files(id, name)',
			'supportsAllDrives' => true ,
			'corpora' => 'drive' ,
			'driveId' => '0AJcO6d0iN8ynUk9PVA' ,
			'includeItemsFromAllDrives' => true ,
		);
		$rsp = [];
		$rsp['code'] = 0;
		$results = $service->files->listFiles($optParams);
		// \Log::info('kuy ni');
		// \Log::info(json_encode($results));
		if(isset($results['files'])){
			if($req->type == 'folder'){
				if($results['files']){
					// \Log::info('A');
					$rsp['code'] = 1;
					$rsp['contents'] = [
						'id'=>$results['files'][0]['id'],
						'name'=>$results['files'][0]['name'],
						'files'=>$this->gdrive_list_by_folder($results['files'][0]['id'])
					];
				}else{
					// \Log::info('B');
					$folder = new Google_Service_Drive_DriveFile();
					$folder->setName($req->name);
					$folder->setParents(["0AJcO6d0iN8ynUk9PVA"]);
					$folder->setMimeType('application/vnd.google-apps.folder');
					$createdFolder = $service->files->create($folder, array(
						'supportsAllDrives' => true 
					));
					$rsp['code'] = 2;
					$rsp['contents'] = ['id'=>$createdFolder['id'],'name'=>$req->name];
				}
			}else{
				// \Log::info('C');
				if($results['files']){
					// \Log::info('D');
					$rsp['code'] = 1;
					$rsp['contents'] = [
						'id'=>$results['files'][0]['id'],
						'name'=>$results['files'][0]['name'],
					];
				}				
			}
		}
		header('Content-Type: application/json');
		echo json_encode($rsp);
	}
	
	public function gdrive_list_by_folder($folderId)
	{
		$client = $this->getClient()[1];
		if(!$this->getClient()[0]){
			$this->send_mail();
			die;
		}
		$service = new Google_Service_Drive($client);
		$optParams = array(
			'q'		 => "'$folderId' in parents and mimeType contains 'audio' and trashed=false",
			'spaces' => "drive",
			'fields' => 'nextPageToken, files(id, name)',
			'supportsAllDrives' => true ,
			'corpora' => 'drive' ,
			'driveId' => '0AJcO6d0iN8ynUk9PVA' ,
			'includeItemsFromAllDrives' => true ,
		);
		$rsp = [];
		$rsp['code'] = 0;
		$rsp['contents'] = [];
		$results = $service->files->listFiles($optParams);
		if(isset($results['files'])){
			$rsp['code'] = 1;
			foreach($results['files'] as $file){
				$rsp['contents'][] = ['download_url'=>'https://drive.google.com/uc?export=download&id='.$file['id'],'name'=>$file['name']];
			}
		}
		return $rsp['contents'];
		// return $folderId;
	}
	
	public function send_mail()
	{
		$to_name = 'Andi Levi';
		$to_email = 'andilevi@gmail.com';
		$data = array('name'=>'Bos Lev', 'body' => 'Token expired. Dan token refresh gagal. Butuh di tinjau bos');
		Mail::send('mail.gdrive_token', $data, function($message) use ($to_name, $to_email) {
			$message->to($to_email, $to_name)
				->subject('Laravel Test Mail');
			$message->from('adelw93us@gmail.com','TOKEN BERMASALAH');
		});
	}
	
	public function gdrive()
	{
		if (isset($_GET['code'])) {
			$this->gDriveToken($_GET['code']);
		}
		echo '<h1>Upload to GDrive</h1>
			<form method="post" enctype="multipart/form-data" action="upload_cek">
				Pilih File:
				  <input type="file" name="fileToUpload" id="fileToUpload">
				  <input type="submit" value="Upload File" name="submit">     
			</form>';
	}
	
	public function gDriveToken($code)
	{
		$client = new Google_Client();
		$client->setAuthConfig(base_path("public/gdrive_auth/oauth-credentials.json"));
		$client->addScope("https://www.googleapis.com/auth/drive");
		$client->setAccessType('offline');
		$client->setPrompt('force');
		$file = base_path("public/gdrive_auth/token.json");
		$token = $client->fetchAccessTokenWithAuthCode($code);
		$cont = json_encode($token);
		if (!file_exists(dirname($file))) {
			mkdir(dirname($tokenPath), 0700, true);
		}
		file_put_contents($file, $cont, LOCK_EX);
	}
	
	public function getClient()
	{
		header('Content-Type: application/json');
		$client = new Google_Client();
		$client->setAuthConfig(base_path("public/gdrive_auth/oauth-credentials.json"));
		$client->addScope("https://www.googleapis.com/auth/drive");
		$client->setAccessType('offline');
		
		$tokenPath = base_path("public/gdrive_auth/token.json");
		if (file_exists($tokenPath)) {
			$accessToken = json_decode(file_get_contents($tokenPath), true);
			$client->setAccessToken($accessToken);
		}
		
		if ($client->isAccessTokenExpired()) {
			if ($client->getRefreshToken()) {
				$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
			} else {
				
				$authUrl = $client->createAuthUrl();
				return [false, $authUrl];
				
			}
			
			if (!file_exists(dirname($tokenPath))) {
				mkdir(dirname($tokenPath), 0700, true);
			}
			file_put_contents($tokenPath, json_encode($client->getAccessToken()));
		}
		
		return [true, $client];
	}
	public function post_gdrive(Request $req)
	{
		$client = $this->getClient()[1];
		if(!$this->getClient()[0]){
			$this->send_mail();
			die;
		}
		$service = new Google_Service_Drive($client);
		try{		
			
			$file = new Google_Service_Drive_DriveFile();
			$file->setParents([$req->folder]);
			// $file->setName($_FILES["fileToUpload"]["name"]);
			$file->setName($req->fileName);
			$result = $service->files->create($file, array(
					// 'data' => file_get_contents($_FILES["fileToUpload"]["tmp_name"]),
					'data' => file_get_contents($req->filePath),
					'mimeType' => 'application/octet-stream',
					'uploadType' => 'multipart',
					'supportsAllDrives' => true ,
			));
			
			$permissionService = new Google_Service_Drive_Permission();
			$permissionService->role = "reader";
			$permissionService->type = "anyone"; // anyone with the link can view the file
			$service->permissions->create($result->id, $permissionService, array(
				'supportsAllDrives'=> true,
				// 'useDomainAdminAccess'=> true
			));
			
			// File::delete($req->filePath);
			
			echo json_encode([
				'file_name' => $result->name,
				'file_id' => $result->id,
			]);	
		}
		catch (\Exception $e) {
			// $msg = json_decode($e->getMessage());
			\Log::error($e->getMessage());
			// if($msg->error){
				// echo 'ADA ERR->'.$msg->error->code.' '.$msg->error->message;
				// \Log::error('ADA ERR->'.$msg->error->code.' '.$msg->error->message);
			// }
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
		
		$this->generate_desc($M->app_name, $M->playlist_id, $M->app_id, $M->app_lang);
		$this->generate_banner($M->app_name, $M->app_id);
		$this->generate_ss($M->app_id);
	}
	
	public function generate_desc($appName, $id, $app_id, $lang='id')
	{
		$video	= Youtube::getPlaylistItemsByPlaylistId($id);
		$file = "C:\ xampp\htdocs\mp3-maudi\KEYSTORE\ $app_id\DESC.html";
		$file = str_replace(' ','',$file);
		if($lang=='id'){
			$cont = "Halo guys. Buat kalian penggemar $appName, kalian bisa mendengarkan MP3 $appName yang populer dan sedang
			trending di aplikasi ini. Audio yang disediakan juga lengkap loh. <br/><br/>Kelebihan aplikasi ini: 
			<br/>✔️ Aplikasi ringan dan irit kuota<br/>✔️ MP3 bisa di dengarkan secara offline<br/>✔️ Ada fitur pencarian MP3,
			jika kamu mau mencari MP3 lainnya<br/>✔️ Bisa memutar acak dan mengulangi MP3
			<br/><br/>Dalam aplikasi ini terdapat audio MP3 hits yang mungkin kalian cari seperti daftar di bawah ini.<br/><br/>";
		}else{
			$cont = "Hello, for you fans of $appName, you can listen to MP3 $appName which is currently popular and trending using this application. The playlist is quite complete.. <br/><br/>Why choose this application? 
			<br/>✔️ Light and efficient on data<br/>✔️ Offline feature<br/>✔️ There is an audio search feature, if you want to find another MP3<br/>✔️ Can random play and repeat MP3
			<br/><br/>In this application there are several MP3 audio that you might be looking for, such as the list below.<br/><br/>";
		}
		$limit = 9;
		$arr_tit = [];
		foreach($video['results'] as $k=>$result){
			$tit = $this->replace($result->snippet->title);
			if($tit == 'DELETED '){
				$limit++;
				continue;
			}
			if(!in_array($tit, $arr_tit)){
				echo $tit.'<br>';
				$cont .= '💛 '.$tit."<br/>";
			}
			$arr_tit[] = $tit;
			
			if($k==$limit){
				break;
			}
		}
		if($lang=='id'){
			$cont .= "<br/>Dan Masih banyak MP3 lainnya.<br/>";
			$cont .= "<br/>Di aplikasi pemutar MP3 ini, kalian bisa menggunakan fitur pencarian untuk mencari dan menambahkan audio $appName yang mungkin tidak ada di playlist anda. Semoga teman-teman sekalian terhibur dengan aplikasi ini. Jika berkenan teman-teman bisa memberi rating di aplikasi ini untuk mensupport developer.";
			$cont .= "<br/><br/>Disclaimer: <br/>Ini adalah Aplikasi Tidak Resmi. Semua merek dagang dan hak cipta dilindungi oleh pemiliknya masing-masing. Kami tidak bertanggung jawab atas konten yang dihosting oleh pihak ketiga dan tidak terlibat dalam pengunduhan / pengunggahan. kami hanya menyajikan konten yang tersedia di Internet. Jika menurut Anda ada konten yang melanggar undang-undang kekayaan intelektual dan Anda memegang hak cipta dari konten tersebut, harap laporkan ke adelw93us@gmail.com dan konten tersebut akan segera dihapus. Dengan menggunakan Aplikasi ini, Anda menyatakan setuju terhadap kebijakan ini. Jika Anda tidak setuju dengan kebijakan ini, mohon untuk tidak menggunakannya.";
		}else{
			$cont .= "<br/>And many others.<br/>";
			$cont .= "<br/>In this MP3 player application, you can use the search feature to find and add audio that may not be in your playlist. Hope you guys are entertained with this application. All features are free, you just need to rate this application to support the developer, if you like.";
			$cont .= "<br/><br/>Disclaimer: <br/>This is an Unofficial Application. All trademarks and copyrights are protected by their respective owners. We are not responsible for the content hosted by third parties and are not involved in the download / upload. we only present content that is available on the Internet. If you think there is content that violates intellectual property laws and you hold the copyright of the content, please report it to adelw93us@gmail.com and the content will be removed immediately. By using this application, you agree to this policy. If you do not agree with this policy, please do not use it.";
		}
		file_put_contents($file, $cont, LOCK_EX);
	}
	
	public function generate_desc_java()
	{
		$appName 	= $_GET['appname']; 
		$id 		= $_GET['yuid']; 
		$app_id 	= $_GET['appid'];
		$lang		= $_GET['lang'];
		
		$video	= Youtube::getPlaylistItemsByPlaylistId($id);
		$file = "C:\ xampp\htdocs\apk\KEYSTORE\ $app_id\DESC.html";
		$file = str_replace(' ','',$file);
		if($lang=='id'){
			$cont = "Halo guys. Buat kalian penggemar $appName, kalian bisa mendengarkan MP3 $appName yang populer dan sedang
			trending di aplikasi ini. Audio yang disediakan juga lengkap loh. <br/><br/>Kelebihan aplikasi ini: 
			<br/>✔️ Aplikasi ringan dan irit kuota<br/>✔️ MP3 bisa di dengarkan secara offline<br/>✔️ Ada fitur pencarian MP3,
			jika kamu mau mencari MP3 lainnya<br/>✔️ Bisa memutar acak dan mengulangi MP3
			<br/><br/>Dalam aplikasi ini terdapat audio MP3 hits yang mungkin kalian cari seperti daftar di bawah ini.<br/><br/>";
		}else{
			$cont = "Hello, for you fans of $appName, you can listen to MP3 $appName which is currently popular and trending using this application. The playlist is quite complete.. <br/><br/>Why choose this application? 
			<br/>✔️ Light and efficient on data<br/>✔️ Offline feature<br/>✔️ There is an audio search feature, if you want to find another MP3<br/>✔️ Can random play and repeat MP3<br/>✔️ Equalizer Features<br/>✔️ Timer Features<br/>✔️ Favorite and Custom Playlist
			<br/><br/>In this application there are several MP3 audio that you might be looking for, such as the list below.<br/><br/>";
		}
		$limit = 9;
		$arr_tit = [];
		foreach($video['results'] as $k=>$result){
			$tit = $this->replace($result->snippet->title);
			if($tit == 'DELETED '){
				$limit++;
				continue;
			}
			if(!in_array($tit, $arr_tit)){
				echo $tit.'<br>';
				$cont .= '💛 '.$tit."<br/>";
			}
			$arr_tit[] = $tit;
			
			if($k==$limit){
				break;
			}
		}
		if($lang=='id'){
			$cont .= "<br/>Dan Masih banyak MP3 lainnya.<br/>";
			$cont .= "<br/>Di aplikasi pemutar MP3 ini, kalian bisa menggunakan fitur pencarian untuk mencari dan menambahkan audio $appName yang mungkin tidak ada di playlist anda. Semoga teman-teman sekalian terhibur dengan aplikasi ini. Jika berkenan teman-teman bisa memberi rating di aplikasi ini untuk mensupport developer.";
			$cont .= "<br/><br/>Disclaimer: <br/>Ini adalah Aplikasi Tidak Resmi. Semua merek dagang dan hak cipta dilindungi oleh pemiliknya masing-masing. Kami tidak bertanggung jawab atas konten yang dihosting oleh pihak ketiga dan tidak terlibat dalam pengunduhan / pengunggahan. kami hanya menyajikan konten yang tersedia di Internet. Jika menurut Anda ada konten yang melanggar undang-undang kekayaan intelektual dan Anda memegang hak cipta dari konten tersebut, harap laporkan ke adelw93us@gmail.com dan konten tersebut akan segera dihapus. Dengan menggunakan Aplikasi ini, Anda menyatakan setuju terhadap kebijakan ini. Jika Anda tidak setuju dengan kebijakan ini, mohon untuk tidak menggunakannya.";
		}else{
			$cont .= "<br/>And many others.<br/>";
			$cont .= "<br/>In this MP3 player application, you can use the search feature to find and add audio that may not be in your playlist. Hope you guys are entertained with this application. All features are free, you just need to rate this application to support the developer, if you like.";
			$cont .= "<br/><br/>Disclaimer: <br/>This is an Unofficial Application. All trademarks and copyrights are protected by their respective owners. We are not responsible for the content hosted by third parties and are not involved in the download / upload. we only present content that is available on the Internet. If you think there is content that violates intellectual property laws and you hold the copyright of the content, please report it to adelw93us@gmail.com and the content will be removed immediately. By using this application, you agree to this policy. If you do not agree with this policy, please do not use it.";
		}
		file_put_contents($file, $cont, LOCK_EX);
	}
	
	public function generate_banner()
	{
		$appName= $_GET['appName']; 
		$app_id = $_GET['appId'];
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
		$image_4 = imagecreatefrompng(base_path('public/assets/generated/logo512.png'));
		$image_2 = imagecreatefrompng(base_path('public/assets/images/phone.png'));
		$image_6 = imagecreatefrompng(base_path('public/assets/images/ps.png'));
		$myBG = "C:\ xampp\ htdocs\ apk\ KEYSTORE\ $app_id\ bg.jpg";
		
		$image_7 = imagecreatefromjpeg(str_replace(' ','',$myBG));
		$image_3 = imagecreatefrompng($capture[0]);
		imagealphablending($image_1, true);
		imagesavealpha($image_1, true);
		
		list($w, $h) = getimagesize(str_replace(' ','',$myBG));
		$x = (imagesx($image_1)/3) - ($w/2);
		$y = (imagesx($image_1)/4) - ($h/2);
		imagecopymerge($image_1, $image_7, $x+2990, 0, 0, 0, $w, $h, 20);
		
		
		$text = explode('-',$appName)[0]; //TITLE
		$text2 = "Download at Playstore"; //TITLE
		$white = imagecolorallocate($image_1, 255, 255, 255);
		$black = imagecolorallocate($image_1, 0, 0, 0);
		$font = base_path('public/assets/font/Degtan-PersonalUse.otf');
		$size = "200";
		$box = imageftbbox( $size, 0, $font, $text ); 
		$x = (410 - ($box[2] - $box[0])) / 2; 
		$y = (1700 - ($box[1] - $box[7])) / 2; 
		$y -= $box[7]; 
		
		$fontwidth = 50;
		
		$center = (imagesx($image_1)/2) - ($fontwidth*(strlen($text)/2));
		$y = (imagesy($image_1)/2) - 300;
		
		imagettftext(
			$image_1, 
			$size, 
			0, 
			$center-100, // margin left
			$y+200, // margin top
			$white, 
			$font, 
			$text);
			
		imagettftext(
			$image_1, 
			$size, 
			0, 
			$center-100, // margin left
			$y+450, // margin top
			$black, 
			$font, 
			$text2);
			
		
		
		list($w, $h) = getimagesize(base_path('public/assets/images/ps.png'));
		imagecopy($image_1, $image_6, $center-100, $y+500, 0, 0, $w, $h);
		
		
		
		list($w, $h) = getimagesize(base_path('public/assets/images/phone.png'));
		$x = (imagesx($image_1)/3) - ($w/2);
		$y = (imagesx($image_1)/4) - ($h/2);
		imagecopy($image_1, $image_2, $center-1500, $y, 0, 0, $w, $h);
		
		list($w, $h) = getimagesize($capture[0]);
		$x = (imagesx($image_1)/3) - ($w/2);
		$y = (imagesx($image_1)/4) - ($h/2);
		imagecopy($image_1, $image_3, $center-1450, $y+50, 0, 0, $w, $h);
		
		
		imagepng($image_1, base_path("public/assets/playstore/banner.png"));
		
		//resize to playstore format
		// $this->resizeImage(2598,2598,base_path("public/assets/playstore/banner.png"),base_path("public/assets/playstore/banner_2598.png")	);
		$deskuy = "C:\ xampp\htdocs\apk\KEYSTORE\ $app_id\banner_1024.png";
		$deskuy = str_replace(' ','',$deskuy);
		$this->resizeImage(1024,500,base_path("public/assets/playstore/banner.png"),$deskuy);
		
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
	
	public function generate_ss($app_id)
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
		
		$caption = [
			"Fitur Utama Aplikasi",
			"Daftar Playlist Kamu",
			"Pemutar Lagu Yang Keren",
			"Cari Lagu Apapun Disini",
		];
		
		foreach($capture as $k=>$cap){
		
			$image_1 = imagecreatefromjpeg(base_path("public/assets/images/bg$k.jpg"));
			$image_2 = imagecreatefrompng(base_path('public/assets/images/phone.png'));
			$image_3 = imagecreatefrompng($cap);
			imagealphablending($image_1, true);
			imagesavealpha($image_1, true);
			
			list($w, $h) = getimagesize(base_path('public/assets/images/phone.png'));
			$cen = (imagesx($image_1)/2) - ($w/2);
			$cen2 = (imagesx($image_1)/0.95) - ($h/2);
			imagecopy($image_1, $image_2, $cen, $cen2, 0, 0, $w, $h);
			
			list($w, $h) = getimagesize($cap);
			$cen = (imagesx($image_1)/2) - ($w/2);
			$cen2 = (imagesx($image_1)/0.95) - ($h/2);
			imagecopy($image_1, $image_3, $cen, $cen2, 0, 0, $w, $h);
			
			$text = $caption[$k]; 
			$white = imagecolorallocate($image_1, 255, 255, 255);
			$black = imagecolorallocate($image_1, 0, 0, 0);
			$font = base_path('public/assets/font/arlrdbd.ttf');
			$size = "60";
			
			$bbox = imagettfbbox($size, 0, $font, $text);
			$center = (imagesx($image_1) / 2) - (($bbox[2] - $bbox[0]) / 2);
			$top = (imagesy($image_1))-(imagesy($image_1)/1.06);
			
			imagettftext(
				$image_1, 
				$size, 
				0, 
				$center+0, // margin left
				$top+0, // margin top
				$black, 
				$font, 
				$text);
				
			imagettftext(
				$image_1, 
				$size, 
				0, 
				$center+2, // margin left
				$top+2, // margin top
				$white, 
				$font, 
				$text);
			
			$deskuy = "C:\ xampp\htdocs\mp3-maudi\KEYSTORE\ $app_id\capture_$k.jpg";
			$deskuy = str_replace(' ','',$deskuy);
			imagejpeg($image_1, $deskuy);
			// break;
		}
	}
	
	public function generate_icon($title,$subtitle)
	{
		
		$dest = imagecreatefromjpeg(base_path('public/assets/images/img1.jpg'));
		$logo = base_path('public/assets/images/sample.jpg');
		$src = imagecreatefromjpeg($logo);
		
		list($w, $h) = getimagesize($logo);
		$cen = (imagesx($dest)/2) - ($w/2);
		$cen2 = (imagesx($dest)/2.5) - ($h/2);
		imagecopymerge($dest, $src, $cen, 0, 0, 0, $w, $h, 80);
		
		$white = imagecolorallocate($dest, 255, 255, 255);
		$grey = imagecolorallocate($dest, 128, 128, 128);
		$black = imagecolorallocate($dest, 0, 0, 0);
		$yellow = imagecolorallocate($dest, 221, 255, 44);
		$yellow2 = imagecolorallocate($dest, 209, 243, 41);
		
		if(isset($_GET['lagu'])){
			$text = 'Lagu '.urldecode($title); //TITLE
		}else{
			$text = urldecode($title); //TITLE
		}
		
		$text2 = urldecode($subtitle);
		$font = base_path('public/assets/font/BackToBlackDemo-Z5mZ.ttf');
		$fon2 = base_path('public/assets/font/Dead Revolution.otf');
		$size = 60;
		$size2 = 20;
		$box = imageftbbox( $size, 0, $font, $text ); 
		$y = (1700 - ($box[1] - $box[7])) / 2; 
		$y -= $box[7]; 
		
		$bbox = imagettfbbox($size, 0, $font, $text);
		$bbox2 = imagettfbbox($size2, 0, $fon2, $text2);
		$center1 = (imagesx($dest) / 2) - (($bbox[2] - $bbox[0]) / 2);
		$center2 = (imagesx($dest) / 2) - (($bbox2[2] - $bbox2[0]) / 2);
		
		imagettftext(
			$dest, 
			$size, 
			0, 
			$center1, // margin left
			$h/1.3, // margin top
			$black, 
			$font, 
			$text);
		imagettftext(
			$dest, 
			$size, 
			0, 
			$center1+3, // margin left
			($h/1.3)+3, // margin top
			$yellow, 
			$font, 
			$text);
		
		imagettftext(
			$dest, 
			$size2, 
			0, 
			$center2, // margin left
			$h/1.06, // margin top
			$black, 
			$fon2, 
			$text2);
		
		imagettftext(
			$dest, 
			$size2, 
			0, 
			$center2+3, // margin left
			($h/1.06)+3, // margin top
			$yellow2, 
			$fon2, 
			$text2);
		
		
		$size = [
			'hdpi'=>[72,300],
			'ldpi'=>[36,112],
			'mdpi'=>[48,150],
			'xhdpi'=>[96,450],
			'xxhdpi'=>[144,600],
			'xxxhdpi'=>[192,750],
		];
		
		imagepng($dest, base_path("public/assets/generated/sample_large.png"));
		$this->generate_image(base_path("public/assets/generated/sample_large.png"), '512', base_path("public/assets/generated/logo512.png"));
		
		// foreach($size as $k=>$s){
			// foreach($s as $kk=>$v){
				// $source = base_path("public/assets/generated/sample_large.png");
				// $nmFile = $kk==0?'icon':'logo';
				// $this->generate_image($source, $v, base_path("public/assets/generated/drawable-$k/$nmFile.png"));
			// }
		// }
		
		// $this->replace_xml_string($text);
		
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
		$day = 7;
		if (Cache::has($q)){
		// if (1==2){
			$respon['contents'] = Cache::get($q);
		}else{
			$video = [];
		  try{	
			$video = Youtube::
				// setApiKey('AIzaSyC0CwcHEkQIEVw0w_DAmt-WzSyNGoXVmo8')->
				getPlaylistItemsByPlaylistId($q);
		  }
		  catch (\Exception $e) {
			  $msg = $e->getMessage();
			  if( \Illuminate\Support\Str::contains($msg, ['exceeded'])){
				  try{
					$video = Youtube::setApiKey($this->key2)->getPlaylistItemsByPlaylistId($q);
				  }catch (\Exception $e) {
					  $msg = $e->getMessage();
					  if( \Illuminate\Support\Str::contains($msg, ['exceeded'])){
						  try{
							$video = Youtube::setApiKey($this->key3)->getPlaylistItemsByPlaylistId($q);
						  }catch (\Exception $e) {
							  $video = [];
						  }	
					  }
				  }	
			  }
		  }
			
		  if($video){
			$respon['contents'] = Cache::remember($q, (60*(24*$day)), function () use($video) {
				foreach($video['results'] as $result){
					if(@$result->snippet->thumbnails->high->url == ''){
						continue;
					}
					
					
					$ddetail['vid'] 		= $result->contentDetails->videoId;
					$ddetail['title'] 		= htmlspecialchars_decode($this->replace($result->snippet->title), ENT_QUOTES);
					$ddetail['url'] 		= 'http://216.158.233.15:8889/yt-convert?id='.$ddetail['vid'].'&video_url=https://www.youtube.com/watch?v='.$ddetail['vid'].'&title='.$ddetail['title'].'&folder=0AJcO6d0iN8ynUk9PVA';
					
					if(@$result->snippet->thumbnails->high->url != ''){
						$ddetail['img']			= route('alias',['url'=>base64_encode($result->snippet->thumbnails->high->url)]);
					}
					$data[] = $ddetail;
				}
				
				return $data;	
			 });
		  } 
		}
		
		echo json_encode($respon
			, JSON_PRETTY_PRINT
			// ,JSON_UNESCAPED_UNICODE
		);
	}
	
	public function search($q, $stop = false)
	{
		
		header('Content-Type: application/json');
		$respon = [];
		$data = [];
		$day = 7;
		
		if (Cache::has($q)){
			$respon['contents'] = Cache::get($q);
		}else{
			$f = file_get_contents(base_path('public').'/youtube_key.json');
			$mKey = json_decode($f);
			
			// \Log::info($mKey->current);
		
			if($mKey->current < 0){
				echo json_encode($respon,TRUE);die;
			}
			
			$key= $mKey->key[$mKey->current];
			
			$output = $this->curlSearch($q, $key);
			if ($output === FALSE) {
				echo json_encode($respon,TRUE);die;
			}
			$op = json_decode($output);
			
			if(isset($op->error->message)){
				if( \Illuminate\Support\Str::contains($op->error->message, ['exceeded']) ){
					if ( ((int)$mKey->current+1) == count($mKey->key)) {
						$mKey->current = 0;
						$tx = (string) json_encode($mKey, TRUE);
						$file = fopen(base_path('public').'/youtube_key.json',"w");
						fwrite($file,$tx);
						fclose($file);
						
						$this->search($q,true);
					}else{
						if($stop){
							echo json_encode($respon,TRUE);die;
						}
						$mKey->current = $mKey->current+1;
						$tx = (string) json_encode($mKey, TRUE);
						$file = fopen(base_path('public').'/youtube_key.json',"w");
						fwrite($file,$tx);
						fclose($file);
						
						$this->search($q);
					}
				}
			}
			if(isset($op->items)){
				if(count((array)$op->items)>0){
					$respon['contents'] = Cache::remember($q, (60*(24*$day)), function () use($op) {
						foreach($op->items as $result){
							$ddetail['vid'] 		= $result->id->videoId;
							$ddetail['title'] 		= htmlspecialchars_decode($this->replace($result->snippet->title), ENT_QUOTES);
							$ddetail['url'] 		= 'http://216.158.233.15:8889/yt-convert?id='.$ddetail['vid'].'&video_url=https://www.youtube.com/watch?v='.$ddetail['vid'].'&title='.$ddetail['title'].'&folder=0AJcO6d0iN8ynUk9PVA';
							
							
							$ddetail['img']			= @$result->snippet->thumbnails->high->url ? route('alias',['url'=>base64_encode($result->snippet->thumbnails->high->url)]) : '';
							$data[] = $ddetail;
						}
						
						return $data;	
					 });
				}
			}	
		}	
		echo json_encode($respon,TRUE);
	}
	
	public function xxx_search($q)
	{
		header('Content-Type: application/json');
		$respon = [];
		$data = [];
		$day = 7;
		
		if (Cache::has($q)){
			$respon['contents'] = Cache::get($q);
		}else{
			$key= env('YOUTUBE_API_KEY');
			
			$output = $this->curlSearch($q, $key);
			if ($output === FALSE) {
				echo json_encode($respon,TRUE);die;
			}
			$op = json_decode($output);
			
			if(isset($op->error->message)){
				if( \Illuminate\Support\Str::contains($op->error->message, ['exceeded']) ){
					$key= $this->key2;
					$output = $this->curlSearch($q, $key);
					if ($output === FALSE) {
						echo json_encode($respon,TRUE);die;
					}
					$op = json_decode($output);
					
					if(isset($op->error->message)){
						if( \Illuminate\Support\Str::contains($op->error->message, ['exceeded']) ){
							$key= $this->key3;
							$output = $this->curlSearch($q, $key);
							if ($output === FALSE) {
								echo json_encode($respon,TRUE);die;
							}
							$op = json_decode($output);
						}
					}
				}
			}
			if(isset($op->items)){
				if(count((array)$op->items)>0){
					$respon['contents'] = Cache::remember($q, (60*(24*$day)), function () use($op) {
						foreach($op->items as $result){
							$ddetail['duration']	= '';
							
							if(strlen($ddetail['duration']) > 4 || strlen($ddetail['duration']) < 1){
								// continue;
							}
							$ddetail['title'] 		= base64_encode(htmlspecialchars_decode($this->replace($result->snippet->title), ENT_QUOTES));
							$ddetail['vid'] 		= $result->id->videoId;
							$ddetail['oriDesc']		= '';
							
							$ddetail['img']			= @$result->snippet->thumbnails->high->url ? route('alias',['url'=>base64_encode($result->snippet->thumbnails->high->url)]) : '';
							$data[] = $ddetail;
						}
						
						return $data;	
					 });
				}
			}	
		}	
		echo json_encode($respon,TRUE);
	}
	
	public function curlSearch($q, $key){
		$ch = curl_init(); 
		$url = "https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=20&q=$q&type=video&key=$key";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($ch); 
		curl_close($ch);      
		return $output;
	}
	
	public function xxsearch($q)
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
		$a = [
			'MV',
			'Mv',
			'mv',
			'M/V',
			'm/v',
			'VIDEO',
			'Video',
			'video',
			'LYRIC',
			'Lyric',
			'lyric',
			'LYRICS',
			'Lyrics',
			'lyrics',
			'LIRIK',
			'Lirik',
			'lirik',
			'CLIP',
			'Clip',
			'clip',
			'KLIP',
			'Klip',
			'klip',
		];
		$b = [
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
		];
		$text = str_replace($a, $b, ($str));
		
		$tmp = (($text));
		$a = ['( ',' )','()','  ','[]'];
		$b = ['(',')','',' ',''];
		return $text = str_replace($a, $b, ($tmp));
	}
}
