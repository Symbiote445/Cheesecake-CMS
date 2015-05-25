//Sliding panel
function collapse(target) {
	if($(target).is(":visible")){
		$(target).slideUp();
		$(target).attr("data-expanded" == "false");
		return false;
	} else {
		$(target).slideDown();
		$(target).attr("data-expanded" == "true");
		return false;
	}
}
//Tabs
$(document).ready(function() {
  $('ul.tabs').each(function(){
    var $active, $content, $links = $(this).find('a');
    $active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
    $active.addClass('active');
    $content = $($active[0].hash);
    $links.not($active).each(function () {
      $(this.hash).hide();
    });
    $(this).on('click', 'a', function(e){
      $active.removeClass('active');
      $content.hide();
      $active = $(this);
      $content = $(this.hash);
      $active.addClass('active');
      $content.show();
      e.preventDefault();
    });
  });	
});
//Div toggle for single page website or
//multiple divs of information on one page
function toggleDiv(divId, navCaret) {
    if($('div.collapse.visible').is(":visible")){
    console.log($('div.collapse.visible').data("expanded"));
    if($('div.collapse.visible').data("expanded") == true){
        $('div.collapse.visible').slideUp();
        $('div.collapse.visible').attr("data-expanded", "false");
		$('div.collapse.visible').removeClass("visible");
    }
        $(".collapse#"+divId).slideDown("fast");
        $(".collapse#"+divId).attr("data-expanded", "true");
		$(".collapse#"+divId).addClass("visible");
		if(navCaret == true){
			$(".chevLink").hide();
			$(".chevLink#"+divId).show();
		}
		
        return false;
    }
}

//Carousel
//Done with ID's (#) to avoid
//Issues when having two carousels
//one one page
$(window).ready(function() {
    $("#slide-next").click(function() {
        // instead of fadeout use `hide` instead to immediately hide 
        $(".carousel-item.visible").hide();
      
        var current = $(".carousel-item.visible");
        // if last child then you are clicking next
        if ( current.is( ".carousel-list li:last-child" ) ) {
          $(".carousel-item:first-child").fadeIn("fast", function() {
              $(".carousel-item.visible").removeClass("visible");
              $(".carousel-item:first-child").addClass("visible");
          });
        }
        else {
          $(".carousel-item.visible").next().fadeIn("fast", function() {
              $(".carousel-item.visible").removeClass("visible");
              $(this).addClass("visible");
          });
        }
    });
    $("#slide-prev").click(function() {
        // instead of fadeout use `hide` instead to immediately hide
        $(".carousel-item.visible").hide();
        var current = $(".carousel-item.visible");
        // if you're on first element then you clicked on prev
        if ( current.is( ".carousel-list li:first-child" ) ) {
          $(".carousel-item:last-child").fadeIn("fast", function() {
              $(".carousel-item.visible").removeClass("visible");
              $(".carousel-item:last-child").addClass("visible");
          });
        }
        else {
          $(".carousel-item.visible").prev().fadeIn("fast", function() {
              $(".carousel-item.visible").removeClass("visible");
              $(this).addClass("visible");
          });
        }
    });
});