$(document).ready(function() {

		
		 		 
		 //------------------------------------//
	  //Scroll To//
	  //------------------------------------//
	  $(".scroll").click(function(event){		
	  	event.preventDefault();
	  	$('html,body').animate({scrollTop:$(this.hash).offset().top}, 800);
	  	
	  });
  

		//------------------------------------//
		//Scroll To Top//
		//------------------------------------// 
		        
			//Check to see if the window is top if not then display button
			$(window).scroll(function(){
				if ($(this).scrollTop() > 700) {
					$('.scrollToTop').fadeIn();
				} else {
					$('.scrollToTop').fadeOut();
				}
			});
			//Click event to scroll to top
			$('.scrollToTop').click(function(){
				$('html, body').animate({scrollTop : 0},800);
				return false;
			});


		//------------------------------------//
	  //WOW Animation//
	  //------------------------------------//
	  wow = new WOW(
	    {
	      boxClass:     'wow',      // animated element css class (default is wow)
	      animateClass: 'animated', // animation css class (default is animated)
	      offset:       0,          // distance to the element when triggering the animation (default is 0)
	      mobile:       false        // trigger animations on mobile devices (true is default)
	    }
	  );
	  wow.init();
	  
	  
	  
	   //------------------------------------//
	  //Accordion Toggle//
	  //------------------------------------//
        function toggleChevron(e) {
          $(e.target)
              .prev('.panel-heading')
              .find("i.fa")
              .toggleClass('fa-minus fa-plus');
      }
      $('#accordion').on('hidden.bs.collapse', toggleChevron);
      $('#accordion').on('shown.bs.collapse', toggleChevron); 
    
	  
	  
	  
	 	  
	   //------------------------------------//
	  //General Contact Form//
	  //------------------------------------//

       $('#contact-form').validate({
        rules: {
          name: {
            minlength: 2,
            required: true
          },
          email: {
            required: true,
            email: true
          },
            message: {
            minlength: 2,
            required: true
          }
        },
        highlight: function(element) {
          $(element)
          .closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
          element
          .text('\uf00c').addClass('valid')
          .closest('.form-group').removeClass('error').addClass('success');
        }
       });    
       
	  
	 

});