<?php

namespace App\Models;

use CodeIgniter\Model;

class BannerModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_banner';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'B_ID',
        'IMAGE_NAME',
        'SLIDER_ORDER',
        'ACTIVE_STATUS'
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
     * insert_banner
     *
     * @param  mixed $banners
     * @return void
     */
    public function insert_banner($banners){
        $result = $this->db->table($this->table)->insert($banners);
        return  $this->db->insertID();        
    }
    
    /**
     * next_id
     *
     * @return void
     */
    public function next_id(){
        $query = $this->db->table($this->table);
        return $query->countAllResults() + 1;
    }
        
    /**
     * get_banner_sorted
     *
     * @return void
     */
    public function get_banner_sorted(){
        return $this->db->table($this->table)
            ->select('IMAGE_NAME, SLIDER_ORDER')
                          ->where("ACTIVE_STATUS", '1')
                          ->orderBy('SLIDER_ORDER','ASE')
                          ->get()->getResultArray();
    }
    /**
     * get_banner_details
     *
     * @return void
     */
    public function get_banner_details(){
        $builder = $this->db->table($this->table);
        $setting = [
            "setTable" => $builder,
            "setDefaultOrder" => [
                ["SLIDER_ORDER","ASC"]
            ],
            "setSearch" => ["B_ID","IMAGE_NAME","ACTIVE_STATUS","SLIDER_ORDER"],
            "setOrder"  => [null,null,"date"],
            "setOutput" => [
                "B_ID",
                function($row){
                    $URL=base_url().BANNERFOLDERPATH.'/'.$row['IMAGE_NAME'];
                    return <<<EOF
                            <img src={$URL} width="200" />
                    EOF;
                },
                function($row){
                       
                    if($row['ACTIVE_STATUS'] == "0"){
                        
                        return <<<EOF
                                    <label class="custom-switch">
                                        <input type="checkbox" name="active_status" value="0" data-id={$row['B_ID']} class="custom-switch-input active-switch">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">In Active</span>
                                    </label>
                         EOF;
                    }else{
                         return <<<EOF
                                    <label class="custom-switch">
                                        <input type="checkbox" name="active_status" value="1" data-id={$row['B_ID']} class="custom-switch-input active-switch" checked="">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Active</span>
                                    </label>
                         EOF;
                    }
                },
                function($row){
                    return <<<EOF
                        <button class="btn btn-info btnchangeorder" data-placement="top" data-toggle="tooltip" data-original-title="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-id='{$row["B_ID"]}' style="font-size: 20px;">{$row['SLIDER_ORDER']}</button>
                    EOF;
                },
                function($row){
                    return <<<EOF
                        <button class="btn btn-danger btnbannerdelete" data-id='{$row["B_ID"]}' style="font-size: 20px;"><i class="ion-trash-a" data-pack="default"></i></button>
                    EOF;
                }

            ]
        ];
        return $setting;

    }
    
    /**
     * update_banner
     *
     * @return void
     */
    public function update_banner($banner_details= array(), $where= array()){
         return $this->db->table($this->table)
                       ->set($banner_details)
                       ->where($where)
                       ->update();
    }
    
    /**
     * delete_banner
     *
     * @param  mixed $banner_id
     * @return void
     */
    public function delete_banner($banner_id){
        $query = $this->db->table($this->table)
                          ->select('IMAGE_NAME')
                          ->where("B_ID", $banner_id)
                          ->get()->getRowArray();
        $file = ROOTPATH . BANNERFOLDERPATH.'/'.$query['IMAGE_NAME'];
        unlink($file);  
        return $this->db->table($this->table)
                       ->where('B_ID', $banner_id)
                       ->delete();
    }
    /**
     * last_query
     *
     * @return void
     */
    public function last_query(){
        $query =  $this->db->getLastQuery();
        return $query->getQuery();
    }
}
