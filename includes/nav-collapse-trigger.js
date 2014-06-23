$j=jQuery.noConflict();
$j(document).ready(function() {
var n=$j("#nav-top select").length;
if (n > 1) {
$j("#nav-top .tinynav").first().remove();
}
$j("ul.sf-menu").find(".current,.current_page_item,.current_page_parent,.current_page_ancestor,.current-cat,.current-cat-parent,.current-cat-ancestor,.current-menu-item,.current-menu-ancestor,.current-menu-parent,.current-post-ancestor,.current-post-parent").addClass('active');
    var id = "tinynav";
    $j('.'+id).after("<ul class='nav-collapse' />")
        .children("option").each(function() {
            $j(".nav-collapse").append('<li><a href="'+$j(this).val()+'">'+$j(this).text()+"</a></li>");
        })
        .end().remove();
	$j('.nav-collapse li a').each(function() {
		if ($j.trim ($j(this).text()) === "") {
			var path_home_icon=$j('.home-icon')[0].src;
			$j(this).prepend('<img class="home-icon" src="' + path_home_icon + '" alt="home-icon" />');
		}
	});
     var navigation = responsiveNav(".nav-collapse", {
        animate: true,                    // Boolean: Use CSS3 transitions, true or false
        transition: 284,                  // Integer: Speed of the transition, in milliseconds
        label: "Menu",                    // String: Label for the navigation toggle
        insert: "before",                  // String: Insert the toggle before or after the navigation
        customToggle: "",                 // Selector: Specify the ID of a custom toggle
        closeOnNavClick: false,           // Boolean: Close the navigation when one of the links are clicked
        openPos: "relative",              // String: Position of the opened nav, relative or static
        navClass: "nav-collapse",         // String: Default CSS class. If changed, you need to edit the CSS too!
        navActiveClass: "active",         // String: Class that is added to <html> element when nav is active
        jsClass: "js",                    // String: 'JS enabled' class which is added to <html> element
        init: function(){},               // Function: Init callback
        open: function(){},               // Function: Open callback
        close: function(){}               // Function: Close callback
      });
});