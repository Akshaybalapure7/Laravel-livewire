<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Page;
use Illuminate\Support\Facades\DB;

class Frontpage extends Component
{
   public $title;
   public $content;
 
    
    /**
     * mount function in livewire
     *
     * @param  mixed $urlslug
     * @return void
     */
    public function mount($urlslug=null){
       $this->retrieveContent($urlslug);
    }
    
    /**
     * retrieve data from page model
     *
     * @param  mixed $urlslug
     * @return void
     */
    public function retrieveContent($urlslug){
       
       //Get home page if slug is empty

       if(empty($urlslug)){
           $data=Page::where('is_dafault_home',true)->first();

       }else{
            $data=Page::where('slug',$urlslug)->first();

            //If we cant retrieve anything , lets get the default 404 not found page status
            if(!$data){
                $data=Page::where('is_default_not_found',true)->first();
            }
       }
       
        $this->title=$data->title;
        $this->content=$data->content;
    }

    
    /**
     * sideBarLinks
     * Add sidebar link dynamically
     * @return void
     */
    private function sideBarLinks() { 
        return DB::table('navigation_menus')
        ->where('type','SidebarNav')
        ->orderBy('sequence','asc')
        ->get();
     }

    public function topNavLinks(){
        return DB::table('navigation_menus')
        ->where('type','TopNav')
        ->orderBy('sequence','asc')
        ->get();
    }  

    
    /**
     * render function in livewire
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.frontpage',[
            'sideBarLinks'=>$this->sideBarLinks(),
            'topNavLinks'=>$this->topNavLinks(),
        ])->layout('layouts.frontpage');
    }
}
