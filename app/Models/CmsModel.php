<?php

namespace App\Models;

use CodeIgniter\Model;

class CmsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_cms_pages';
    protected $primaryKey       = 'ID';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ID',
        'TYPE',
        'TITLE',
        'CONTENT'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $createdField  = 'CREATED_AT';
    protected $updatedField  = 'UPDATED_AT';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    
    
    /**
     * insert_page
     *
     * @param  mixed $page
     * @return void
     */
    public function insert_page($page){
        $result = $this->db->table($this->table)->insert($page);
        return  $this->db->insertID();        
    }
    
    /**
     * get_all_pages
     *
     * @return void
     */
    public function get_all_pages(){
        $builder = $this->db->table($this->table);
        $setting = [
            "setTable" => $builder,
            "setDefaultOrder" => [
                ["SLUG","DESC"]
            ],
            "setSearch" => ["ID","SLUG","TITLE",'UPDATED_AT'],
            "setOrder"  => [null,null,"date"],
            "setOutput" => [
                "ID",
                "TITLE",
                "SLUG",
                "UPDATED_AT",
                function($row){
                    $edit_url = base_url('/admin/cms/edit-page/?page-id='.$row["ID"]);
                    return <<<EOF
                        <a class="btn btn-primary btnpagedetails" href='{$edit_url}'>Details</a>
                        <button class="btn btn-danger btnpagedelete" data-id='{$row["ID"]}' style="font-size: 20px;"><i class="ion-trash-a" data-pack="default"></i></button>
                    EOF;
                }

            ]
        ];
        return $setting;

    }
    
    /**
     * delete_page
     *
     * @return void
     */
    public function delete_page($id){
         return $this->db->table($this->table)
                       ->where('ID', $id)
                       ->delete();
    }
    
    /**
     * getPageById
     *
     * @param  mixed $id
     * @return void
     */
    public function getPageById($id){
        return $this->db->table($this->table)
                        ->where('ID', $id)
                        ->get()->getRowArray();
    }
    
    /**
     * update_page
     *
     * @param  mixed $id
     * @return void
     */
    public function update_page($details, $id){
        return $this->db->table($this->table)
                       ->set($details)
                       ->where('ID', $id)
                       ->update();
    }

    /**
     * get all pages for API
     *
     * @return void
     */
    public function get_all_pages_api(){
        return  $this->db->table($this->table)->select('slug,type,title,content')->get()->getResultArray();
    }  
    
}
