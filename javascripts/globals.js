jQuery(document).ready(function() { 
	// Get social links as array
	var sociallinks=new Array();
	var selected=jQuery('.social-media-links a').clone();
	for(var i=0; i<=selected.length; i++){
		sociallinks.push( selected[i] );
	}
	// Header Nav Menu
	jQuery('header#main #menu-open').on('click',function(){
	  	jQuery("#mmenu").mmenu({
		   // options
	       extensions: ["pagedim-black","position-right"],
	       navbars: [{position: "top",},{position: "bottom",content: sociallinks}],
	       slidingSubmenus:false,
	  	},{
			// configuration
			clone:true,
	  	});
	});
	// Inline footer navigation
	var showfooternav=jQuery('footer .site-map-container').attr('data-show-footer-navigation'); 
	if(showfooternav==0){
		jQuery('footer .site-map-container').hide();
	}	
	// Header Search
	jQuery('header#main #search-open').on('click',function(e){
		e.preventDefault();
		jQuery('#header-search').toggle();
		jQuery('#header-search:visible input#query').focus();
	});	
	jQuery('#content,#banner').on('click',function(e){
		jQuery('#header-search').hide();
		jQuery('#header-search:visible input#query').blur();
	});		
});