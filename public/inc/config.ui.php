<?php

//CONFIGURATION for SmartAdmin UI

//ribbon breadcrumbs config
//array("Display Name" => "URL");
$breadcrumbs = array(
	"Home" => APP_URL
);

/*navigation array config
ex:
"dashboard" => array(
	"title" => "Display Title",
	"url" => "http://yoururl.com",
	"url_target" => "_self",
	"icon" => "fa-home",
	"label_htm" => "<span>Add your custom label/badge html here</span>",
	"sub" => array() //contains array of sub items with the same format as the parent
)
*/
$page_nav = array(
	"dashboard" =>array(
		"title" => "Dashboard",
		"url" => APP_URL."/backend",
		"icon" => "fa-home"
    ),
	"inbox" => array(
		"title" => "Inbox",
		"url" => APP_URL."/backend/inbox.php",
		"icon" => "fa-inbox",

	),
    "pages"=>array(
        "title"=>"Pages",
        "icon"=>"fa-clone",
        "sub"=>array(
            "list" =>array(
                "title" => "Page Listing",
                "icon" => "fa-stack-overflow",
                "url"=>APP_URL."/backend/pages/index"
            ),
            "addnew"=>array(
                "title"=>"Add New Page","icon"=>"fa-external-link","url"=>APP_URL."/backend/pages/addnew"
            )
        )
    ),
    "posts"=>array(
        "title"=>"Posts",
        "icon"=>"fa-wpforms",
        "sub"=>array(
            "list" =>array(
                "title" => "Post Listing",
                "icon" => "fa-stack-overflow",
                "url"=>APP_URL."/backend/posts/index"
            ),
            "categories"=>array(
                "title"=>"Post Categories","icon"=>"fa-external-link","url"=>APP_URL."/backend/posts/categories"
            ),
            "addnew"=>array(
                "title"=>"Add New Post","icon"=>"fa-external-link","url"=>APP_URL."/backend/posts/addnew"
            )
        )
    ),
    "events"=>array(
        "title"=>"Events",
        "icon"=>"fa-calendar",
        "sub"=>array(
            "list" =>array(
                "title" => "Events Listing",
                "icon" => "fa-stack-overflow",
                "url"=>APP_URL."/backend/events/index"
            ),
            "addnew"=>array(
                "title"=>"Add New Event","icon"=>"fa-external-link","url"=>APP_URL."/backend/events/addnew"
            ),
            "categories"=>array(
                "title"=>"Event Categories","icon"=>"fa-external-link","url"=>APP_URL."/backend/events/categories"
            )
        )
    ),
    "menu"=>array(
        "title"=>"Menu",
        "icon"=>"fa-navicon",
        "url"=>APP_URL."/backend/menu/index"
    ),
    "slider"=>array(
        "title"=>"Slider",
        "icon"=>"fa-camera",
        "url"=>APP_URL."/backend/sliders/index"
    )


);

//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
?>