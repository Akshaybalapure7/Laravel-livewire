<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Page;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;
use Illuminate\Support\Str; 
class Pages extends Component
{
    use WithPagination;
    public $modalFormVisible = false;
    public $modalConfirmDelete=false;
    public $slug;
    public $title;
    public $content;
    public $modelId;
    public $isSetToDefaultHomePage;
    public $isSetToDefaultNotFoundPage;
    
   
   /**
    * validation for form
    *
    * @return void
    */
   public function rules()
   {
       return[
           'title'=>'required',
           'slug'=>['required',Rule::unique('pages','slug')->ignore($this->modelId)],
           'content'=>'required'
       ];
   }


   
   /**
    * updatedTitle updated is function in
    * laravel which change value realtime
    * @param  mixed $value
    * @return void
    */
   public function updatedTitle($value)
   {
      // $this->generateSlug($value);  
      $this->slug=Str::slug($value);
   }

    /**
     * Store data in page table
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        $this->unassignDefaultHomePage();
        $this->unassignDefaultNotFoundPage();
        Page::create($this->modelData());
        $this->modalFormVisible=false;
        $this->reset();
    }
        
    /**
     * Shows form modal
     * of create function
     * @return void
     */
    public function createShowModal()
    {
        $this->reset();
        $this->resetValidation();
        $this->modalFormVisible = true;
    }
    
    /**
     * get modelData
     *
     * @return void
     */
    public function modelData()
    {
        return [
            'title'=>$this->title,
            'slug'=>$this->slug,
            'content'=>$this->content,
            'is_dafault_home'=>$this->isSetToDefaultHomePage,
            'is_default_not_found'=> $this->isSetToDefaultNotFoundPage
        ];
    }
    
    
  
        
    /**
     * mount
     *
     * @return void
     */    
    
    public function mount(){
        //Reset pagination after reloading the page 
        $this->resetPage();    
    }
    
    /**
     * The read function
     *
     * @return void
     */
    public function read()
    {
        return Page::paginate(5);
    }

    
    /**
     * updateShowModal
     * Update Modal data
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->reset();
        $this->modelId=$id;
        $this->modalFormVisible=true;
        $this->loadModal($id);
    }
    
    /**
     * loadModal
     *use to get data for edit function
     * @param  mixed $id
     * @return void
     */
    public function loadModal($id)
    {
        $data=Page::find($id);
        $this->title=$data->title;
        $this->slug=$data->slug;
        $this->content=$data->content;
        $this->isSetToDefaultHomePage= !$data->is_dafault_home?null:true;
        $this->isSetToDefaultNotFoundPage=!$data->is_default_not_found?null:true;
    }
    
    /**
     * update modal data
     *
     * @return void
     */
    public function update()
    {
        $this->validate();
        $this->unassignDefaultHomePage();
        $this->unassignDefaultNotFoundPage();
        Page::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible=false;
        $this->reset();
    }


     
     /**
      * deleteShowModal 
      *
      * @return void
      */
     public function deleteShowModal($id)
     {
         $this->modelId=$id;
         $this->modalConfirmDelete=true;
     }

     public function delete()
     {
         $data=Page::find($this->modelId)->delete();
         $this->modalConfirmDelete=false;
         $this->resetPage();
     }
          
     /**
      * updatedIsSetToDefaultHomePage
      *update is_default_not_found to null
      *
      * @return void
      */
     public function updatedIsSetToDefaultHomePage()
     {
         $this->isSetToDefaultNotFoundPage=null;
     }
     
     /**
      * updatedIsSetToDefaultNotFoundPage
      * update is_default_home_page to null
      * @return void
      */
     public function updatedIsSetToDefaultNotFoundPage()
     {
         $this->isSetToDefaultHomePage=null;
     }

     
     /**
      * unassignDefaultHomePage
      *
      * @return void
      */
     private function unassignDefaultHomePage()
     {
         if($this->isSetToDefaultHomePage != null){
             Page::where('is_dafault_home',true)->update([
                 'is_dafault_home'=>false
             ]);
         }
     }
     
     /**
      * unassignDefaultNotFoundPage
      *
      * @return void
      */
     private function unassignDefaultNotFoundPage(){
         if($this->isSetToDefaultNotFoundPage)
         {
             Page::where('is_default_not_found',true)->update(([
                 'is_default_not_found'=>false
             ]));
         }
     }

    /**
     * livewire render function
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.pages',
        ['data'=>$this->read()]);
    }
}
