<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteMap extends Model
{
    
	protected $table = 'SITE_MAP';
	
	protected $fillable = [
		'urlset',
		'url',
		'loc',
		'lastmod',
		'changefreq',
		'priority',
	];
	
}
