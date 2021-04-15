<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <!--  This file has been downloaded from bootdey.com    @bootdey on twitter -->
      <!--  All snippets are MIT license http://bootdey.com/license -->
      <title>Prototype Filter PPM</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
	  <link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>
      <style type="text/css">
         body{margin-top:20px;
         background:#eee;
         }
         .btn {
         margin-bottom: 5px;
         }
         .grid {
         position: relative;
         width: 100%;
         background: #fff;
         color: #666666;
         border-radius: 2px;
         margin-bottom: 25px;
         box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.1);
         }
         .grid .grid-body {
         padding: 15px 20px 15px 20px;
         font-size: 0.9em;
         line-height: 1.9em;
         }
         .search table tr td.rate {
         color: #f39c12;
         line-height: 50px;
         }
         .search table tr:hover {
         cursor: pointer;
         }
         .search table tr td.image {
         width: 50px;
         }
         .search table tr td img {
         width: 50px;
         height: 50px;
         }
         .search table tr td.rate {
         color: #f39c12;
         line-height: 50px;
         }
         .search table tr td.price {
         font-size: 1.5em;
         line-height: 50px;
         }
         .search #price1,
         .search #price2 {
         display: inline;
         font-weight: 600;
         }
		 button.multiselect-option.dropdown-item {
    width: 100%;
    text-align: left;
}
.multiselect-container .multiselect-filter > input.multiselect-search {
    margin-left: 0px !important;
} 
      </style>
   </head>
   <body>
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
      <div class="container">
         <div class="row">
            <!-- BEGIN SEARCH RESULT -->
            <div class="col-md-12">
               <div class="grid search">
                  <div class="grid-body">
                     <div class="row">
                        <!-- BEGIN FILTERS -->
                        <div class="col-md-3" style="display:none;">
                           <h2 class="grid-title"><i class="fa fa-filter"></i> Filters</h2>
                           <hr>
                           <!-- BEGIN FILTER BY CATEGORY -->
                           <h4>By category:</h4>
                           <div class="checkbox">
                              <label><input type="checkbox" class="icheck"> Application</label>
                           </div>
                           <div class="checkbox">
                              <label><input type="checkbox" class="icheck"> Design</label>
                           </div>
                           <div class="checkbox">
                              <label><input type="checkbox" class="icheck"> Desktop</label>
                           </div>
                           <div class="checkbox">
                              <label><input type="checkbox" class="icheck"> Management</label>
                           </div>
                           <div class="checkbox">
                              <label><input type="checkbox" class="icheck"> Mobile</label>
                           </div>
                           <!-- END FILTER BY CATEGORY -->
                           <div class="padding"></div>
                           <!-- BEGIN FILTER BY DATE -->
                           <h4>By date:</h4>
                           From
                           <div class="input-group date form_date" data-date="2014-06-14T05:25:07Z" data-date-format="dd-mm-yyyy" data-link-field="dtp_input1">
                              <input type="text" class="form-control">
                              <span class="input-group-addon bg-blue"><i class="fa fa-th"></i></span>
                           </div>
                           <input type="hidden" id="dtp_input1" value="">
                           To
                           <div class="input-group date form_date" data-date="2014-06-14T05:25:07Z" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2">
                              <input type="text" class="form-control">
                              <span class="input-group-addon bg-blue"><i class="fa fa-th"></i></span>
                           </div>
                           <input type="hidden" id="dtp_input2" value="">
                           <!-- END FILTER BY DATE -->
                           <div class="padding"></div>
                           <!-- BEGIN FILTER BY PRICE -->
                           <h4>By price:</h4>
                           Between 
                           <div id="price1">$300</div>
                           to 
                           <div id="price2">$800</div>
                           <div class="slider-primary">
                              <div class="slider slider-horizontal" style="width: 152px;">
                                 <div class="slider-track">
                                    <div class="slider-selection" style="left: 30%; width: 50%;"></div>
                                    <div class="slider-handle round" style="left: 30%;"></div>
                                    <div class="slider-handle round" style="left: 80%;"></div>
                                 </div>
                                 <div class="tooltip top hide" style="top: -30px; left: 50.1px;">
                                    <div class="tooltip-arrow"></div>
                                    <div class="tooltip-inner">300 : 800</div>
                                 </div>
                                 <input type="text" class="slider" value="" data-slider-min="0" data-slider-max="1000" data-slider-step="1" data-slider-value="[300,800]" data-slider-tooltip="hide">
                              </div>
                           </div>
                           <!-- END FILTER BY PRICE -->
                        </div>
                        <!-- END FILTERS -->
                        <!-- BEGIN RESULT -->
                        <div class="col-md-12">
                           <h2><i class="fa fa-file-o"></i> Kegiatan Dan Pelatihan</h2>
                           <hr>
                           <!-- BEGIN SEARCH INPUT -->
                           <div class="input-group">
                              <input type="text" class="form-control" value="" placeholder="Filter by title">
                              <span class="input-group-btn">
                              <button class="btn btn-default" data-toggle="collapse" data-target="#demo" type="button"><i class="fa fa-filter"></i> Pencarian Lanjutan</button>
                              <button class="btn btn-primary" type="button"><i class="fa fa-search"></i> Cari</button>
                              </span>
                           </div>
						   <div id="demo" class="collapse">
								<div class="row">
									<div class="col-md-4">
										<h4>Price Range:</h4>
										<input type="range" min="1" max="100" value="50">
									</div>
									<div class="col-md-4">
										<h4>Duration Range:</h4>
										<input type="range" min="1" max="100" value="50">
									</div>
									<div class="col-md-4">
										<h4>Jenis Kegiatan:</h4>
										<select id="multi" multiple="multiple">
											<option value="cheese"> Live Training Webinar</option>
											<option value="tomatoes"> All / Saleable / Program Pengembangan Eksekutif / Executive Development Program / Directorship</option>
											<option value="mozarella"> Semua Kegiatan / In-Class Training / Business Enhancement</option>
											<option value="mushrooms"> Semua Kegiatan / In Class Training / Human Capital Management</option>
											<option value="pepperoni"> Semua Kegiatan / Blended Learning / Human Capital Management</option>
											<option value="onions"> Personal Effectiveness</option>
											<option value="Strategic Management"> Strategic Management</option>
											<option value="Pemerintahan"> Pemerintahan</option>
										</select>										
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<h4>Bidang Keahlian:</h4>
									   <div class="checkbox">
										  <label><input type="checkbox" class="icheck"> Financial Management</label>
									   </div>
									   <div class="checkbox">
										  <label><input type="checkbox" class="icheck"> General Management</label>
									   </div>
									   <div class="checkbox">
										  <label><input type="checkbox" class="icheck"> Human Resource Management</label>
									   </div>
									   <div class="checkbox">
										  <label><input type="checkbox" class="icheck"> Live Training Webinar</label>
									   </div>
									   <div class="checkbox">
										  <label><input type="checkbox" class="icheck"> Managing Other</label>
									   </div>
									</div>
									<div class="col-md-4">
										<h4>Lokasi:</h4>
									   <div class="checkbox">
										  <label><input type="checkbox" class="icheck"> Jakarta</label>
									   </div>
									   <div class="checkbox">
										  <label><input type="checkbox" class="icheck"> Makassar</label>
									   </div>
									   <div class="checkbox">
										  <label><input type="checkbox" class="icheck"> Surabaya</label>
									   </div>
									   <div class="checkbox">
										  <label><input type="checkbox" class="icheck"> Jababeka</label>
									   </div>
									   <div class="checkbox">
										  <label><input type="checkbox" class="icheck"> Yogyakarta</label>
									   </div>
									</div>
									<div class="col-md-4">
										<h4>Tingkat Pengalaman:</h4>
									   <div class="checkbox">
										  <label><input type="checkbox" class="icheck"> Staff</label>
									   </div>
									   <div class="checkbox">
										  <label><input type="checkbox" class="icheck"> Supervisor</label>
									   </div>
									   <div class="checkbox">
										  <label><input type="checkbox" class="icheck"> Manager</label>
									   </div>
									   <div class="checkbox">
										  <label><input type="checkbox" class="icheck"> Senior Manager</label>
									   </div>
									   <div class="checkbox">
										  <label><input type="checkbox" class="icheck"> Direktur</label>
									   </div>
									</div>
								</div>
							</div>
                           <!-- END SEARCH INPUT -->
                           <p>Hasil pencarian...</p>
                           <div class="padding"></div>
                           <div class="row">
                              <!-- BEGIN ORDER RESULT -->
                              <div class="col-sm-6">
                                 <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    Sorting by <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                       <li><a href="#">Title A-Z</a></li>
                                       <li><a href="#">Title Z-A</a></li>
                                       <li><a href="#">Price (Low-High)</a></li>
                                       <li><a href="#">Price (High-Low)</a></li>
                                       <li><a href="#">Duration (Short-Long)</a></li>
                                       <li><a href="#">Duration (Long-Short)</a></li>
                                       <li><a href="#">Highest Rating</a></li>
                                       <li><a href="#">Lowest Rating</a></li>
                                    </ul>
                                 </div>
                              </div>
                              <!-- END ORDER RESULT -->
                              <div class="col-md-6 text-right">
                                 <div class="btn-group">
                                    <button type="button" class="btn btn-default active"><i class="fa fa-list"></i></button>
                                    <button type="button" class="btn btn-default"><i class="fa fa-th"></i></button>
                                 </div>
                              </div>
                           </div>
                           <!-- BEGIN TABLE RESULT -->
                           <div class="table-responsive">
                              <table class="table table-hover">
                                 <tbody>
								 <?php 
								 $data = [
									[
										'title'=>'Company Strategic Planning [Blended Learning]',
										'desc'=>'Blended Learning merupakan program pelatihan yang mengkombinasikan pembelajaran melalui Learning Management System (LMS) serta pembelajaran Virtual menggunakan Zoom live Meeting sehingga lebih flexible, tetap interaktif, aplikatif dan impactful learning',
										'price'=>'Rp 3.200.000,00/ peserta',
										'duration'=>'10 Hari',
									],
									[
										'title'=>'Advance Competitive Marketing Strategy [In-ClassTraining]',
										'desc'=>'Perebutan pasar semakin tidak lagi didominasi oleh pemain besar saja, namun juga oleh banyak perusahaan pendatang baru dengan skala kecil sangat intens dalam membangun hubungan pelanggannya. Perusahaan-perusahaan ini meningkat dengan cepat dan perlu diwaspadai. Oleh karenanya, pemilihan strategi pemasaran yang tepat menjadi sangat penting.',
										'price'=>'Rp 6.200.000,00/ peserta',
										'duration'=>'12 Hari',
									],
									[
										'title'=>'Advance Competitive Marketing Strategy [Live Virtual Training]',
										'desc'=>'Perebutan pasar semakin tidak lagi didominasi oleh pemain besar saja, namun juga oleh banyak perusahaan pendatang baru dengan skala kecil sangat intens dalam membangun hubungan pelanggannya. Perusahaan-perusahaan ini meningkat dengan cepat dan perlu diwaspadai. Oleh karenanya, pemilihan strategi pemasaran yang tepat menjadi sangat penting.',
										'price'=>'Rp 3.400.000,00/ peserta',
										'duration'=>'4 Hari',
									],
									[
										'title'=>'Applied Marketing Research [Live Training Webinar]',
										'desc'=>'Informasi mengenai pasar yang tajam dan akurat dapat dihasilkan melalui riset pemasaran yang tepat. Riset pemasaran yang kuat akan menghasilkan kemampuannya melihat potensi pasar, karakteristik pasar dan perilaku konsumen yang nantinya digunakan untuk membangun perencanaan pemasaran yang tepat. Dalam pelatihan ini peserta akan dibekali kemampuan praktis untuk mengadakan riset terapan dan mengolah data menggunakan SPSS.',
										'price'=>'Rp 2.200.000,00/ peserta',
										'duration'=>'10 Hari',
									],
									[
										'title'=>'Assessment Center Assessor Certification [ACAC]',
										'desc'=>'Program ini dirancang dengan memperhatikan prinsip-prinsip pelatihan assessor yang termuat dalam The Guidelines and Ethical Considerations for Asessment Center Operation. Membantu Anda dalam membangun keterampilan fundamental sebagai Assessment Center Assessor, mulai dari prinsip dasar penilaian kompetensi, pengenalan jenis-jenis perangkat dalam metode Assessment Center, keterampilan observasi, assessor meeting dan penulisan laporan.
Jakarta Supervisor Manager Senior Manager',
										'price'=>'Rp 13.200.000,00/ peserta',
										'duration'=>'10 Hari',
									],
								 ];
								 
								 foreach($data as $dt){
								 ?>
                                    <tr>
                                       <td class="image"><img src="https://via.placeholder.com/400x300/FF8C00" alt=""></td>
                                       <td class="product"><strong><?php echo $dt['title'] ?></strong><br><?php echo substr($dt['desc'],0,60).'...' ?>
										<br/><i class="fa fa-clock-o"></i> <?php echo $dt['duration'] ?>
									   </td>
                                       <td class="rate text-right">
										<span>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-half-o"></i>
										</span>
										</td>
                                       <td class="price text-right"><?php echo $dt['price'] ?></td>
                                    </tr>
								 <?php } ?>
                                 </tbody>
                              </table>
                           </div>
                           <!-- END TABLE RESULT -->
                           <!-- BEGIN PAGINATION -->
                           <ul class="pagination">
                              <li class="disabled"><a href="#">«</a></li>
                              <li class="active"><a href="#">1</a></li>
                              <li><a href="#">2</a></li>
                              <li><a href="#">3</a></li>
                              <li><a href="#">4</a></li>
                              <li><a href="#">5</a></li>
                              <li><a href="#">»</a></li>
                           </ul>
                           <!-- END PAGINATION -->
                        </div>
                        <!-- END RESULT -->
                     </div>
                  </div>
               </div>
            </div>
            <!-- END SEARCH RESULT -->
         </div>
      </div>
      <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
      <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	  <script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
      <script type="text/javascript">
    $(document).ready(function() {
			$('#multi').multiselect({
				enableFiltering: true,
				includeFilterClearBtn: false
			});
		});
	</script>
   </body>
</html>