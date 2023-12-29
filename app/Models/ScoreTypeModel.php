<?php

namespace App\Models;

use CodeIgniter\Model;

class ScoreTypeModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_score_type';
    protected $primaryKey       = 'ST_ID';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ST_ID',
        'NAME',
        'LOWEST_SLUG',
        'HIGHEST_SLUG'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
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
     * getScoreType
     *
     * @return void
     */
    public function getScoreType(){
        return $this->db->table($this->table)
                        ->get()->getResultArray();
    }
    
    /**
     * getScoreTypeById
     *
     * @return void
     */
    public function getScoreTypeById($id){
        return $this->db->table($this->table)
                        ->where('ST_ID', $id)
                        ->get()->getRowArray();
    }
}
