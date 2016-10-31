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
	"dashboard" => array(
		"title" => "Dashboard",
		"url" => '/backend/dashboard/index',
		"icon" => "fa-home"
	),
	"pages" => array(
		"title" => "Pages",
		"icon" => "fa-code",
		"sub" => array(

			"list" => array(
				"title" => "All Pages",
				"url" => '/backend/pages/index'
			),
			"addnew" => array(
				"title" => "Add New",
				"url" => '/backend/pages/addnew'
			)
		)
	),

	"posts" => array(
		"title" => "Posts",
		"icon" => "fa-bar-chart-o",
		"sub" => array(
			"list" => array(
				"title" => "All Post",
				"url" => '/backend/posts/index'
                
			),
			"addnew" => array(
				"title" => "Add New",
				"url" => '/backend/posts/addnew'
			),
            "categories" => array(
                "title" => "All Categories",
                "url" => "/backend/categories/index"
            )
		)
	),

	"frontend" => array(
		"title" => "Frontend",
		"icon" => "fa-windows",
		"sub" => array(
			"slideshow" => array(
		        "title" => "Slide Show",
		        "icon" => "fa-file",
		        "sub" => array(
		            "list" => array(
		                "title" => "All Slides",
		                "url" => "/backend/sliders/index"
		            ),
		            "slideimage" => array(
		                "title" => "Manage Slide Image",
		                "url" => "/backend/sliders/manageimages"
		            )
		        )
		    ),
            "menu" => array(
				"title" => "Manage Frontend Menu",
				"url" => "/backend/menu/index"
			),
            "preview" => array(
				"title" => "Preview Website",
				"url" => "/"
			),
            "document"=>array(
                "title"=>"Documents",
                "icon"=>"fa-download",
                "sub" => array(
                    "list" => array(
                        "title" => "All Listing",
                        "url"=>"/backend/documents/index"
                    ),
                    "category" => array(
                        "title" => "Category Listing",
                        "url"=>"/backend/documents/category"
                    )
                )

            ),
            "pageblock"=>array(
                "title"=>"Page Blocks",
                "url"=>"/backend/pageblocks/index"
            )

		)
	),

    "account" => array(
        "title" => "Accounts",
        "icon" => "fa-windows",
        "sub"=>array(
            "individual"=>array(
                "title"=>"Individual Account",
                "url"=>"/backend/accounts/individual"
            ),
            
            "corporate"=>array(
                "title"=>"Corporate Account",
                "url"=>"/backend/accounts/corporate"
            )

        )

    ),
    "research" => array(
        "title" => "Reserach",
        "icon" => "fa-windows",
        "sub"=>array(
            "corporate"=>array(
                "title"=>"Corporate Action",
                "url"=>"/backend/researches/listing"
            )
        )

    ),
    "results"=>array(
        "title"=>"Companies Results",
        "icon"=>"fa-building",
        "sub"=>array(
            "list" => array(
                "title" => "All Listing",
                "url"=>"/backend/companyresults/index"
            ),
            "category" => array(
                "title" => "Category Listing",
                "url"=>"/backend/companyresults/category"
            )
        )

    ),
    "survey"=>array(
        "title" => "Survey",
        "icon" => "fa-tasks",
        "sub"=>array(
            "listing"=>array(
                "title"=>"Survey Listing",
                "url"=>"/backend/survey/index",
                "icon" => "fa-list",
            )
        )
    ),

    "stock" => array(
        "title" => "Stock Price & Broking Fee",
        "icon" => "fa-windows",
        "sub"=>array(
            "stockprice"=>array(
                "title"=>"Stock Price",
                "url"=>"/backend/stock/index"
            ),
            "brokingfee"=>array(
                "title"=>"Broking Fees",
                "url"=>"/backend/stock/brokingfees"
            ),            
            "stocindex"=>array(
                "title"=>"NSE Index",
                "url"=>"/backend/stock/nseindex"
            )
        )

    ),
   
    "admin"=>array(
        "title"=>"Administrator",
        "icon"=>"fa-users",
        "sub"=>array(
            "list"=>array(
                "title"=>"Admin Listing",
                "url"=>"/backend/administrators/index"
            ),
            "addnew"=>array(
                "title"=>"Add New",
                "url"=>"/backend/administrators/addnew"
            ),
            "logs"=>array(
                "title"=>"Logs",
                "icon"=>"fa-file",
                "url"=>"/backend/administrators/loglist"
            ),"role"=>array(
                "title"=>"Roles",
                "sub"=>array(
                    "list"=>array(
                        "title"=>"Role Listing",
                        "url"=>"/backend/roles/index",
                    )
                )
            ),
            
            "audit"=>array(
                "title"=>"Audit Trail",
                "icon"=>"fa-file",
                "url"=>"/backend/administrators/audit"
            )
        )
    ),
    "script"=>array(
        "title" =>"Scripts",
        "icon"=>"fa-file",
        "sub"=>array(
            "sidebar"=>array(
                "title"=>"Sidebar Script",
                "url"=>"/backend/scripts/sidebar"
            ),
            "footer"=>array(
            "title"=>"Footer Script",
            "url"=>"/backend/scripts/footer"
),
            "home"=>array(
            "title"=>"Home Page Script",
            "url"=>"/backend/scripts/home"
)
        )

    ),
    "setting"=>array(
        "title"=>"Settings",
        "icon"=>"fa-wrench",
        "url"=>"/backend/settings"
    )
);

//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
?>