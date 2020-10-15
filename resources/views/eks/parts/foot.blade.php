<footer class="footer">
        <div class="copy-right_text">
            <div class="container">
                <div class="footer_border"></div>
                <div class="row">
                    <div class="col-xl-12">
                        <p class="copy_right text-center">
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy; {{ env('APP_NAME') }} 2020
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>


  <!-- Modal -->
  <div class="modal fade custom_search_pop" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="serch_form">
		<form action="" method="post" class="fmodalfind">
            <input type="text" class="fmfind-text" placeholder="Search" >
            <button type="submit">search</button>
		</form>
        </div>
      </div>
    </div>
  </div>
    <!-- link that opens popup -->
    

    <!-- JS here -->
	<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5e689ad5a6c3be00121b3c40&product=inline-share-buttons&cms=sop' async='async'></script>

    <script src="{{ url('theme/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <script src="{{ url('theme/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ url('theme/js/popper.min.js') }}"></script>
    <script src="{{ url('theme/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('theme/js/owl.carousel.min.js') }}"></script>
    <script src="{{ url('theme/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ url('theme/js/ajax-form.js') }}"></script>
    <script src="{{ url('theme/js/waypoints.min.js') }}"></script>
    <script src="{{ url('theme/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ url('theme/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ url('theme/js/scrollIt.js') }}"></script>
    <script src="{{ url('theme/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ url('theme/js/wow.min.js') }}"></script>
    <script src="{{ url('theme/js/jquery-ui.min.js') }}"> </script>
    <script src="{{ url('theme/js/nice-select.min.js') }}"></script>
    <script src="{{ url('theme/js/jquery.slicknav.min.js') }}"></script>
    <script src="{{ url('theme/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ url('theme/js/plugins.js') }}"></script>
    <script src="{{ url('theme/js/range.js') }}"></script>
        <!-- <script src="{{ url('theme/js/gijgo.min.js') }}"></script> -->
    <script src="{{ url('theme/js/slick.min.js') }}"></script>
   

    
    <!--contact js-->
    <script src="{{ url('theme/js/contact.js') }}"></script>
    <script src="{{ url('theme/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ url('theme/js/jquery.form.js') }}"></script>
    <script src="{{ url('theme/js/jquery.validate.min.js') }}"></script>
    <script src="{{ url('theme/js/mail-script.js') }}"></script>


    <script src="{{ url('theme/js/main.js') }}"></script>
    <script>
        $('#datepicker').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
             rightIcon: '<span class="fa fa-caret-down"></span>'
         }
        });
		
		$('.fsubmit').submit(()=>{
			var q = beautyUrl(decodeURIComponent($('.text-find').val()))
			if(q==''){
				location.href="{{ route('home') }}/"
			}else{
				location.href="{{ route('home') }}/"+q
			}
			return false;
		});
		
		$('.fmodalfind').submit(()=>{
			var q = beautyUrl(decodeURIComponent($('.fmfind-text').val()))
			if(q==''){
				location.href="{{ route('home') }}/"
			}else{
				location.href="{{ route('home') }}/"+q
			}
			return false;
		});
		
		function beautyUrl(s){
			return s.split(' ').join('-')
		}
    </script>