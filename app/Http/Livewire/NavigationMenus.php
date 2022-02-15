<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use \App\Models\NavigationMenu;
use Illuminate\Support\Str; 
class NavigationMenus extends Component
{
    public $modalFormVisible;
    public $modelId;
    public $label;
    public $slug;
    public $sequence=1;
    public $type="SidebarNav";
    public $modalConfirmDelete;
    
 
    public function rules() {
        return [
            'label'=>'required',
            'slug'=>'required',
            'type'=>'required',
            'sequence'=>'required'        
        ];
    }
      
    /**
     * Open model for create functionality
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible=true;
    }

    
    /**
     * updateShowModal
     *Show modal for update
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible=true;
        $this->modelId=$id;
        $this->loadModal();
    }
    
    /**
     * loadModal
     * load data in updateModal
     * @return void
     */
    public function loadModal()
    {
        $data=NavigationMenu::find($this->modelId);
        $this->label=$data->label;
        //$this->generateSlug($data->label);
        $this->slug=$data->slug;
        $this->sequence=$data->sequence;
        $this->type=$data->type;
    }

     public function updatedLabel($value)
     {
         $this->slug=Str::slug($value);
     }
    /**
     * read function for getting data
     *
     * @return void
     */
    public function read()
    {
         
        return NavigationMenu::paginate(5);
    
    }
    
    /**
     * Add data 
     * Create new navigation
     * @return void
     */
    public function create()
    {
        
        $this->validate();
        NavigationMenu::create($this->modalData());
        $this->modalFormVisible= false;
        $this->reset();
    }
    
    /**
     * update
     * navigation menu
     * @return void
     */
    public function update(){
        $this->validate();
        NavigationMenu::find($this->modelId)->update($this->modalData());
        $this->modalFormVisible=false;
    }
    
    
    /**
     * deleteShowModal
     * Show modal for delete
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->modelId=$id;
        $this->modalConfirmDelete=true;
    }
    
    /**
     * delete 
     *remove navigation from list
     * @return void
     */
    public function delete(){
        NavigationMenu::destroy($this->modelId);
        $this->modalConfirmDelete=false;
    }
    /**
     * modalData for mapping data in array
     *
     * @return void
     */
    public function modalData()
    {
        return [
            'label'=>$this->label,
            'slug'=>$this->slug,
            'sequence'=>$this->sequence,
            'type'=>$this->type
        ];
    }
    
    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.navigation-menus',[
            'data'=>$this->read(),
        ]);
    }
}
