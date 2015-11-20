

 $(document).ready(function($) {

	$('#pc-message').keyup(function () {
	  var max = 350;
	  var len = $(this).val().length;
	  if (len >= max) {
	    $('#charNum').text('You have reached the limit');
	    $(this).val($(this).val().substring(0, max));
	  } else {
	    var char = max - len;
	    $('#charNum').text(char + ' characters left');
	  }
	});
	
 });

(function($) {

    $.fn.pcFormWizard = function(options) {
    
        options = $.extend({  
            submitButton: "",
            submitStep: ""
        }, options); 
        
        
        var element = this;

        var steps = $(element).find("fieldset");
        var count = steps.size();
        var submmitButtonName = "#" + options.submitButton;     //alert( submmitButtonName );
        $(submmitButtonName).hide();
        
        var submitStep = options.submitStep;    //alert( submitStep );
		
        $(element).before("<ul class='nav nav-bar' id='steps'></ul>");

        steps.each(function(i) {
            //alert(i);

			
            $(this).wrap("<div id='step" + i + "'></div>");
            $(this).append("<p id='step" + i + "commands'></p>");

            var name = $(this).find("legend").html();
            
            $(this).find("legend").hide();
            
            $("#steps").append("<li id='stepDesc" + i + "'>" + (i + 1) + ". " + name + "</li>");
            
            if (i == 0) {
                createNextButton(i);
                selectStep(i);
            }
            else if (i == count - 1) {
                $("#step" + i).hide();
                createPrevButton(i);
            }
            else {
                $("#step" + i).hide();
                createPrevButton(i);
                createNextButton(i);
            }
        });

        function createPrevButton(i) {
            var stepName = "step" + i;
            $("#" + stepName + "commands").append("<a href='#' id='" + stepName + "Prev' class='prev'>< Back</a>");

            $("#" + stepName + "Prev").bind("click", function(e) {
                $("#" + stepName).hide();
                $("#step" + (i - 1)).show();
                $(submmitButtonName).hide();
                selectStep(i - 1);
            });
        }

        function createNextButton(i) {
        
            if (i + 2 == count)
                $(submmitButtonName).show(); 
			   
			if( i < 3 ) {
	            var stepName = "step" + i;
	            
	            $("#" + stepName + "commands").append("<a href='#' id='" + stepName + "Next' class='next'>Next ></a>");
	
	            $("#" + stepName + "Next").bind("click", function(e) {
	                $("#" + stepName).hide();
	                $("#step" + (i + 1)).show();
	 
	                selectStep(i + 1);
	            });
	        }
        }

        function selectStep(i) {
            if( submitStep == '4' )
				i = 4;
            $("#steps li").removeClass("current");
            $("#stepDesc" + i).addClass("current");
        }

    }
})(jQuery); 
