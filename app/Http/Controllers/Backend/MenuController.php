<?php

namespace App\Http\Controllers\Backend;

use App\Post;
use Illuminate\Http\Request;
use App\Menu;
use App\Menupo;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class MenuController extends Controller
{
    //

    public function getIndex(Request $request, $pgid=""){
        $input = $request->all();
        $cats       = Post::where("type","post category")->get();
        $custs      = Post::where("type","=","custom menu")->get();
        $pages      = Post::where("type","page")->get();
        $allPages   = Post::all();
        $menuPost   = Post::find($pgid);

        $mymenus    =  DB::table("menus")->where("post_menu_id",$pgid)->get() ;
        $menpos = DB::table("menupos")->get();
        $menus="";
        $menus="";
        $menuJsonData=[];

        if(!is_null($menuPost)){
            if(count($mymenus) >0){
                foreach($mymenus as $menu){
                    if($menu->menu_type ==$menuPost->type){
                        $menus .='<li class="dd-item" data-title="'.$menu->title.'" data-id="'.$menu->id.'" data-parent-id="'.$menu->parent_id.'" data-menu-id="'.$menu->post_menu_id.'" data-link="'.$menu->link.'" data-post-id="'.$menu->post_id.'">
                                    <div class="dd-handle">'.
                            $menu->title
                            .'</div>';

                        if($menu->has_child==1 ){
                            $menus .= '<ol class="dd-list" >';
                            $submenus = Menu::where("parent_id","=",$menu->id)->get();
                            foreach($submenus as $submenu1){
                                $menus .='<li class="dd-item"  data-title ="'.$submenu1->title.'" data-id="'.$submenu1->id.'" data-parent-id="'.$submenu1->parent_id.'" data-menu-id="'.$menu->post_menu_id.'" data-link="'.$submenu1->link.'" data-post-id="'.$submenu1->post_id.'">
                                    <div class="dd-handle">'.$submenu1->title.'</div>';
                                if($submenu1->has_child==1 && $submenu1->menu_type =="submenu1"){ //get second level menu for first level
                                    $menus .= '<ol class="dd-list" >';
                                    $submenus = \Menu::where("parent_id","=",$menu->id)->get();
                                    foreach($submenus as $submenu2){
                                        $menus .='<li class="dd-item"  data-title ="'.$submenu2->title.'" data-id="'.$submenu2->id.'" data-parent-id="'.$submenu2->parent_id.'" data-menu-id="'.$menu->post_menu_id.'" data-link="'.$submenu2->link.'" data-post-id="'.$submenu2->post_id.'" >
                                    <div class="dd-handle">'.$submenu2->title.'</div>';
                                        if($submenu2->has_child==1 && $submenu2->menu_type == "submenu2"){
                                            foreach($submenus as $submenu3){
                                                $menus .='<li class="dd-item"  data-title ="'.$submenu3->title.'" data-id="'.$submenu3->id.'" data-parent-id="'.$submenu3->parent_id.'" data-link="'.$submenu3->link.'" data-post-id="'.$submenu3->post_id.'" >
                                                    <div class="dd-handle">'.$submenu3->title.'</div>';
                                                $menus .='<i style="border-radius:13px; float:right; margin-top:-50px" class=" b fa fa-times-circle"></i></li>';
                                            }
                                            $menus .='</ol>';
                                        }
                                        $menus .='<i style="border-radius:13px; float:right; margin-top:-50px" class=" b fa fa-times-circle"></i></li>';
                                    }
                                    $menus .='</ol>';
                                }
                                $menus .='<i style="border-radius:13px; float:right; margin-top:-50px" class=" b fa fa-times-circle"></i></li>';
                            }
                            $menus .='</ol>';
                        }

                        $menus .='<i style="border-radius:13px; float:right; margin-top:-50px" class=" b fa fa-times-circle"></i></li>';
                    }
                }
            }
        }



        if($request->ajax()){
            if(isset($input['action'])){
                if($input['action'] == "edit"  ){
                    return response()->json(["status"=>200,"data"=>Post::find($pgid),"menus"=>$menus]);
                    exit;
                }elseif($input['action'] == "delete"){

                }
            }
        }
        return View("backend.menu.index",["page_title"=>"Menu Bar","title"=>"Menu Bar","thisMenu"=>Post::find($pgid),"categories"=>$cats,"pages"=>$pages,"menufposts"=>Post::where("post_type","menu category")->get(),"menus"=>$menus,"customs"=>$custs,"menupos"=>Menupo::where("id","<>","")->first()]);

    }

    public function postMenuHome(Request $request){
        $input = $request->all();
        if(isset($input['title']) && isset($input['id'])){
            if($input['id'] =="" && !empty($input['id'])){

            }else{
                $id = $input['id'];
                $menu = Menu::find($id);
                $postcheck = Menu::where("parent_id","=",$id)->get();
                if($postcheck->count()>=1){
                    foreach($postcheck as $sub){
                        $sub->delete();
                    }
                }
                $menu->delete();
                echo "Menu Item Deleted";
            }

            $menupos = Post::find($menu->post_menu_id);
            if(is_null($menupos)){

            }else{
                $menupos->post_meta = $input["val"];
                $menupos->update();
            }
            exit;
        }
        $pages  = DB::table("posts")->where("type","page")->get();
        $data = array();

        $data=( json_decode(Input::get("val")));

        $jjack = "";
        $mpos = 0;
        $post_menu_id = "";
        $parent_id="";
        foreach($data as $dat){

            $post_id = $dat->postId;
            $post_menu_id = $dat->menuId;
            $sort_order = $mpos;
            $menu_type = DB::table("posts")->where("id",$dat->menuId)->pluck("type");
            //dd($menu_type);
            $title = $dat->title;

            $isparent= (property_exists($dat,"children")) ?  1  :  0 ;


            if(property_exists($dat,"id")){
                $menu = Menu::find($dat->id);
            }else{
                $menu = new Menu();
            }

            $menu->post_id = $post_id;
            $menu->sort_order = $sort_order;
            $menu->menu_type = $menu_type[0];
            $menu->title= $title;
            $menu->link = $dat->link;
            $menu->post_menu_id = $post_menu_id;
            $menu->has_child = $isparent == 1 ? 1 : 0;
            $menu->position     = 0;

            $menu->save();
            $jjack .= $menu->id.",";
            if(property_exists($dat,"children")){ //1st level submenu
                $menu_type ="submenu1";
                $mcpos = 0;
                foreach($dat->children as $child1){
                    $post_id = $child1->postId;
                    $sort_order = $mcpos;
                    $parent_id = $menu->id;
                    $title = $child1->title;
                    (property_exists($child1,"children")) ? $isparent= 1  : $isparent= 0 ;
                    /**Check if child exist if yes find child ID
                     * if no create a new menu item at this point
                     */
                    if(property_exists($child1,"id")){
                        $submenu1               = Menu::find($child1->id);
                    }else{
                        $submenu1               = new Menu();
                    }
                    $submenu1->parent_id = $parent_id;
                    $submenu1->menu_type = $menu_type;
                    $submenu1->post_id = $post_id;
                    $submenu1->sort_order = $sort_order;
                    $submenu1->position     = 1;
                    $menu->post_menu_id = $post_menu_id;
                    $submenu1->link = $child1->link;
                    $submenu1->has_child     = $isparent;
                    $submenu1->title = $title;
                    $submenu1->save();

                    if(property_exists($submenu1,"children")){ // second level menu
                        $mccpos =0;
                        $menu_type ="submenu2";
                        foreach($submenu1->children as $child2){
                            $post_id                = $child2->id;
                            $title                = $child2->title;
                            $sort_order             = $mccpos;

                            (property_exists($child2,"children")) ? $isparent= 1  : $isparent= 0 ;
                            $parent_id              = $submenu1->id;

                            if(property_exists($child2,"id")){
                                $submenu1               = Menu::find($child2->id);
                            }else{
                                $submenu1               = new Menu();
                            }
                            $submenu1->parent_id    = $parent_id;
                            $submenu1->menu_type    = $menu_type;
                            $submenu1->post_id      = $post_id;
                            $submenu1->title        = $title;
                            $submenu1->has_child     = $isparent;
                            $submenu1->position     = 1;
                            $submenu1->link         = $child2->link;
                            $menu->post_menu_id = $post_menu_id;
                            $submenu1->sort_order   = $sort_order;

                            $submenu1->save();
                            $mccpos++;
                        }
                    }
                    $mcpos++;
                }
            }
            $mpos++;
        }

        $post = Post::find($post_menu_id);


        if(is_null($post) || $post == null){
            echo 0;
        }else{
            $post->post_meta = $input["val"];
            $post->updated_at = date("Y-m-d H:i:s");
            $post->update();
            echo 1;
        }
    }
}
