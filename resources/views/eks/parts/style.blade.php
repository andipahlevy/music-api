<style>
.logo>a {
    font-weight: 700;
    color: {{ env('APP_PRIMARY_COLOR') }};
}
.header-area .seach_icon{
	background: {{ env('APP_PRIMARY_COLOR') }};
}
.boxed-btn4{
	background: {{ env('APP_PRIMARY_COLOR') }};
    color: #fff !important;
}
.boxed-btn4:hover{
	background: {{ env('APP_SECONDARY_COLOR') }};
    color: #fff !important;
}
.header-area .main-header-area .main-menu ul li a:hover {
    color: {{ env('APP_SECONDARY_COLOR') }};
}
.popular_places_area .single_place .thumb .prise, .custom_search_pop .modal-content .serch_form button{
	background: {{ env('APP_PRIMARY_COLOR') }};
}
.popular_places_area .single_place:hover .place_info h3 {
    color: {{ env('APP_SECONDARY_COLOR') }};
}
a.slicknav_btn.slicknav_collapsed{
	margin: 0px !important;
}
.bagikan {
    text-align: center;
    margin: 20px;
    font-size: 15pt;
    font-weight: 400;
}
.bagikan>a {
    font-size: 11pt;
    padding: 10px;
    color: #fff !important;
}
.fa-facebook { background: #3B5998; color: white; } .fa-twitter { background: #55ACEE; color: white; } .fa-whatsapp { background: #3db24c; color: white; } .fa-linkedin { background: #007bb5; color: white; }
</style>