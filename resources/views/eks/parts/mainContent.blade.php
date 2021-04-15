 <!-- newletter_area_start  -->
        <div class="newletter_area overlay">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-10"><form method="post" action="" class="fsubmit">
                        <div class="row align-items-center">
                            <div class="col-lg-5">
                                <div class="newsletter_text">
                                    <h4>Find videos!</h4>
                                    <p>You can find awesome videos here</p>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="mail_form">
                                    <div class="row no-gutters">
                                        
											<div class="col-lg-9 col-md-8">
												<div class="newsletter_field">
													<input type="text" class="text-find" value="{{ @$q }}" placeholder="Explore videos..." >
												</div>
											</div>
											<div class="col-lg-3 col-md-4">
												<div class="newsletter_btn">
													<button class="boxed-btn4 bfind" type="submit" >Search</button>
												</div>
											</div>
										
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div></form>
                </div>
            </div>
        </div>
        <!-- newletter_area_end  -->
    
	@if(isset($id))
	<section class="blog_area single-post-area section-padding">
      <div class="container">
         <div class="row">
            <div class="col-lg-12 posts-list">
               <div class="single-post">
				  <div>
					<h1>
					 {{ ucfirst(@$q) }}
                     </h1>
				  </div>
                  <div class="feature-img">
                     <div style="overflow:hidden;position: relative;" class="img-fluid">
							<style>
    .hytPlayerWrap {
        display: block;
        position: relative;
    }
    .hytPlayerWrap.ended::after {
        content:"";
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        cursor: pointer;
        background-color: black;
        background-repeat: no-repeat;
        background-position: center; 
        background-size: 64px 64px;
        background-image: url(data:image/svg+xml;utf8;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMjgiIGhlaWdodD0iMTI4IiB2aWV3Qm94PSIwIDAgNTEwIDUxMCI+PHBhdGggZD0iTTI1NSAxMDJWMEwxMjcuNSAxMjcuNSAyNTUgMjU1VjE1M2M4NC4xNSAwIDE1MyA2OC44NSAxNTMgMTUzcy02OC44NSAxNTMtMTUzIDE1My0xNTMtNjguODUtMTUzLTE1M0g1MWMwIDExMi4yIDkxLjggMjA0IDIwNCAyMDRzMjA0LTkxLjggMjA0LTIwNC05MS44LTIwNC0yMDQtMjA0eiIgZmlsbD0iI0ZGRiIvPjwvc3ZnPg==);
    }
    .hytPlayerWrap.paused::after {
        content:"";
        position: absolute;
        top: 70px;
        left: 0;
        bottom: 50px;
        right: 0;
        cursor: pointer;
        background-color: black;
        background-repeat: no-repeat;
        background-position: center; 
        background-size: 40px 40px;
        background-image: url(data:image/svg+xml;utf8;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEiIHdpZHRoPSIxNzA2LjY2NyIgaGVpZ2h0PSIxNzA2LjY2NyIgdmlld0JveD0iMCAwIDEyODAgMTI4MCI+PHBhdGggZD0iTTE1Ny42MzUgMi45ODRMMTI2MC45NzkgNjQwIDE1Ny42MzUgMTI3Ny4wMTZ6IiBmaWxsPSIjZmZmIi8+PC9zdmc+);
    }
</style>
							<div class="hytPlayerWrapOuter">
								<div class="hytPlayerWrap">
									<iframe
										width="100%" height="560"
										src="https://www.youtube.com/embed/{{ $id }}?rel=0&enablejsapi=1"
										frameborder="0"
									></iframe>
								</div>
							</div>
							<script>
    "use strict";
    document.addEventListener('DOMContentLoaded', function() {
        // Activate only if not already activated
        if (window.hideYTActivated) return;
        // Activate on all players
        let onYouTubeIframeAPIReadyCallbacks = [];
        for (let playerWrap of document.querySelectorAll(".hytPlayerWrap")) {
            let playerFrame = playerWrap.querySelector("iframe");
            
            let tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            let firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
            
            let onPlayerStateChange = function(event) {
                if (event.data == YT.PlayerState.ENDED) {
                    playerWrap.classList.add("ended");
                } else if (event.data == YT.PlayerState.PAUSED) {
                    playerWrap.classList.add("paused");
                } else if (event.data == YT.PlayerState.PLAYING) {
                    playerWrap.classList.remove("ended");
                    playerWrap.classList.remove("paused");
                }
            };
            
            let player;
            onYouTubeIframeAPIReadyCallbacks.push(function() {
                player = new YT.Player(playerFrame, {
                    events: {
                        'onStateChange': onPlayerStateChange
                    }
                });
            });
          
            playerWrap.addEventListener("click", function() {
                let playerState = player.getPlayerState();
                if (playerState == YT.PlayerState.ENDED) {
                    player.seekTo(0);
                } else if (playerState == YT.PlayerState.PAUSED) {
                    player.playVideo();
                }
            });
        }
        
        window.onYouTubeIframeAPIReady = function() {
            for (let callback of onYouTubeIframeAPIReadyCallbacks) {
                callback();
            }
        };
        
        window.hideYTActivated = true;
    });
</script>
					  </div>
                  </div>
                  <div class="blog_details">
                     
                     <ul class="blog-info-link mt-3 mb-4">
                        <li><a href="#"><i class="fa fa-clock-o"></i> {{ $met[0] }}</a></li>
						@if(isset($met[1]))
							<li><a href="#"><i class="fa fa-eye"></i> {{ $met[1] }}</a></li>
						@endif
                     </ul>
                     <p class="excert">
					 {!! str_replace('*dot*','.',urldecode($desc)) !!}
                     </p>
					 
					 <p>
						<a href="https://www.youtube.com/watch?v={{ $id }}" target="_blank" rel="nofollow">Source</a>
					 </p>
					 
					 <p>
					 <div>
						
						<div class="bagikan">
							<div class="col-md-12">
								Share this video!
							</div>
							<a target="_blank" href="{{ "http://www.facebook.com/share.php?u=http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]&title=$q" }}" class="fa fa-facebook"></a>
							<a target="_blank" href="{{ "http://twitter.com/home?status=$q+http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" }}" class="fa fa-twitter"></a>
							<a target="_blank" data-action="share/whatsapp/share" href="{{ "https://api.whatsapp.com/send?text=$q+http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" }}" class="fa fa-whatsapp"></a>
							<a target="_blank" href="{{ "http://www.linkedin.com/shareArticle?mini=true&url=http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]&title=$q&source=$_SERVER[HTTP_HOST]" }}" class="fa fa-linkedin"></a>
						</div>
					 </div>
					 </p>
                     
                  </div>
               </div>
            </div>
          </div>
      </div>
	</section>
	@endif
	
    <div class="popular_places_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
					<div class="row mb-3">
						<div class="section_title">
							@if(isset($title))
								<h2> Similar videos:</h2>
							@else
								<h1>{{ isset($q) ? urldecode(ucfirst($q)) : ucfirst(env('APP_NAME')) }}</h1>
								<article>
									You can find more videos like {{ isset($q) ? urldecode(ucfirst($q)) : ucfirst(env('APP_NAME')) }}. Don't forget to share this video :)
								</article>
							@endif
						</div>	
					</div>
					
					<div class="row">
						<div class="col-md-12">
						<!-- /14116792/japaninbottom -->
						<div id='div-gpt-ad-1584601354468-0' style='width: 728px; height: 90px;'>
						  <script>
							googletag.cmd.push(function() { googletag.display('div-gpt-ad-1584601354468-0'); });
						  </script>
						</div>
						</div>
					</div>
					
                    <div class="row target-list">
                     @if(isset($data['api']))   
						@foreach($data['api'] as $dt)
						<div class="col-lg-3 col-md-3">
                            <div class="single_place">
                                <div class="thumb">
								<?php 
								$oD = isset($dt['oriDesc']) ? base64_encode($dt['oriDesc']) : base64_encode('Watch now '.$dt['title']);
								if(isset($dt['meta']) && $dt['meta'] != ''){
									$iniURL = url('video/'.urlencode(str_replace(['.','/'],['%2E','-'],$dt['title'])).'/'.$dt['vid'].'/'.$oD.'/'.base64_encode($dt['meta']) );
								}else{
									$iniURL = url('video/'.urlencode(str_replace(['.','/'],['%2E','-'],$dt['title'])).'/'.$dt['vid'].'/'.$oD.'/'.base64_encode('Watch now!') );
								}
								?>
								@if(isset($dt['img']))
									<?php 
										if(substr($dt['img'],0,4) != 'http'){
											$dt['img'] = 'https:'.$dt['img'];
										}
									?>
                                    <a href="{{ $iniURL }}">
									<img src="{{ @$dt['img'] }}" alt="{{ @$dt['title'] }} - {{ env('APP_NAME') }}" title="{{ @$dt['title'] }}">
									</a>
								@endif	
									@if(@$dt['duration'])
                                    <a href="#" class="prise">{{ @$dt['duration'] }}</a>
									@endif
								</div>
                                <div class="place_info">
									@if(@$dt['vid'] != '')
										<a href="{{ $iniURL }}"><h3>{{ @$dt['title'] }}</h3></a>
									@else
									<h3>{{ @$dt['title'] }}</h3>
									@endif
									<p>Watch {{ @$dt['desc'] }}</p>
                                    <div class="rating_days d-flex justify-content-between">
									@php
									$m = explode('^nl',@$dt['meta'])
									@endphp
									
									@if(count($m) < 2)
										<span class="d-flex justify-content-center align-items-center days">
                                            <i class="fa fa-video-camera"></i> {{ @$m[0] }}
                                        </span>
									@else
										<span class="d-flex justify-content-center align-items-center days">
                                            <i class="fa fa-clock-o"></i> {{ @$m[0] }}
                                        </span>
                                        <div class="days">
                                            <i class="fa fa-eye"></i>
                                            <a href="#">{{ @$m[1] }}</a>
                                        </div>
									@endif
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
						@endforeach
					@endif	
					</div>
					
					<div class="row">
                        <div class="col-lg-12">
						{!! env('APP_AMAZON_ADS',null) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	@include('eks.parts.foot')
    
	<script>
	@if(isset($title))
	$(document).ready(()=>{
		$.ajax({
			type:'get',
			url:"{{ route('suggest') }}",
			data:"q={{ $title }}",
			cache:false,
			beforeSend:()=>{
				$('.target-list').html('Load similar data...')
			},
			complete:()=>{
				
			},
			success: (rsp)=>{
				$('.target-list').html(rsp)
			}
		})
	});
	@endif
	</script>
