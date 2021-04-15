@foreach($data['api'] as $dt)
						<div class="col-lg-3 col-md-3">
                            <div class="single_place">
                                <div class="thumb">
								@if(isset($dt['img']))
									<?php 
										if(substr($dt['img'],0,4) != 'http'){
											$dt['img'] = 'https:'.$dt['img'];
										}
									?>
                                    <img src="{{ @$dt['img'] }}" alt="{{ @$dt['title'] }}" title="{{ @$dt['title'] }}">
								@endif	
									@if(@$dt['duration'])
                                    <a href="#" class="prise">{{ @$dt['duration'] }}</a>
									@endif
								</div>
                                <div class="place_info">
									@if(@$dt['vid'] != '')
										@if(isset($dt['meta']) && $dt['meta'] != '')
											<a href="{{ url('video/'.urlencode(str_replace(['.','/'],['%2E','-'],$dt['title'])).'/'.$dt['vid'].'/'.base64_encode(@$dt['oriDesc']).'/'.base64_encode($dt['meta']) ) }}"><h3>{{ @$dt['title'] }}</h3></a>
										@else
											@php
												$oD = @$dt['oriDesc'] ? base64_encode($dt['oriDesc']) : base64_encode('Watch now '.$dt['title']);
											@endphp
											<a href="{{ url('video/'.urlencode(str_replace(['.','/'],['%2E','-'],$dt['title'])).'/'.$dt['vid'].'/'.$oD.'/'.base64_encode('Watch now!') ) }}"><h3>{{ @$dt['title'] }}</h3></a>
										@endif
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