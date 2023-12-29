<?php
namespace App\Models;

use CodeIgniter\Model;



/**
 * PromocodeModel
 */
class CommentsModel extends Model
{    
    /**
     * table
     *
     * @var string
     */
    protected $table      = 'tbl_contest_comments';    
    /**
     * primaryKey
     *
     * @var string
     */
    protected $primaryKey = 'COMMENT_ID';
    
    /**
     * useAutoIncrement
     *
     * @var bool
     */
    protected $useAutoIncrement = true;
    
    /**
     * returnType
     *
     * @var string
     */
    protected $returnType     = 'array';    
    /**
     * useSoftDeletes
     *
     * @var bool
     */
    protected $useSoftDeletes = true;
    
    /**
     * allowedFields
     *
     * @var array
     */
    protected $allowedFields = [
                                'COMMENT_ID',
                                'COMMENT_PARTICIPANT_ID',  
                                'COMMENT_AUTHOR_ID',
                                'COMMENT_DATE',
                                'COMMENT_CONTENT',
                                'PARENT_COMMENT_ID',
                                ];
    
    /**
     * useTimestamps
     *
     * @var bool
     */
    protected $useTimestamps = false;    
    /**
     * createdField
     *
     * @var string
     */
    protected $createdField  = 'CREATED_AT';    
    /**
     * updatedField
     *
     * @var string
     */
    protected $updatedField  = 'UPDATED_AT';
    
    /**
     * validationRules
     *
     * @var array
     */
    protected $validationRules = [];    
    /**
     * validationMessages
     *
     * @var array
     */
    protected $validationMessages = [];    
    /**
     * skipValidation
     *
     * @var bool
     */
    protected $skipValidation     = false;

        /**
     * get_api_rules
     *
     * @return void
     */
    public function get_api_rules(){
        $validation = array(
			"name"  => $this->validationRules['name'],
			"email"   => $this->validationRules["email"],
			"message"      => $this->validationRules["message"]
		);
        return $validation;
    }
        /**
     * get_api_message
     *
     * @return array
     */
    public function get_api_message(){
        $messages = [
           'name' => [
               'required' => 'Name is Required',
           ],
           'email'=> [
               'required' => 'Email Is Required',
           ],
           'message' =>[
               'required' => 'Message Key Is Required'
           ],
       ];
       return $messages;
   }   
   /**
    * get_participant_comments
    *
    * @return void
    */
   public function get_participant_comments($participant_id){
        $comments = $this->db->table($this->table)
                 ->select('COMMENT_ID, COMMENT_PARTICIPANT_ID, FIRST_NAME as AUTHOR_NAME, COMMENT_CONTENT, PROFILE_IMAGE, tbl_contest_comments.CREATED_AT as COMMENT_DATE, PARENT_COMMENT_ID')
                 ->join('tbl_user_master', 'tbl_user_master.ID = '.$this->table.'.COMMENT_AUTHOR_ID ', 'left')
                 ->where('COMMENT_PARTICIPANT_ID ', $participant_id);
        $comments = $comments->get()->getResultArray();
        foreach($comments as $key => $comment){
          
            if(!empty($comment['PARENT_COMMENT_ID'])){
                $child_comments = $this->db->table($this->table)
                 ->select('COMMENT_ID, COMMENT_PARTICIPANT_ID, FIRST_NAME as AUTHOR_NAME,COMMENT_CONTENT, PROFILE_IMAGE, tbl_contest_comments.CREATED_AT as COMMENT_DATE, PARENT_COMMENT_ID')
                 ->join('tbl_user_master', 'tbl_user_master.ID = '.$this->table.'.COMMENT_AUTHOR_ID ', 'left')
                 ->where('PARENT_COMMENT_ID ', $comment['PARENT_COMMENT_ID'])->get()->getResultArray();
                 
                 foreach($comments as $key => $parentcomment){
                     if($parentcomment['COMMENT_ID'] === $comment['PARENT_COMMENT_ID']){
                        $comments[$key]['CHILD_COMMENTS'] = $child_comments;
                     }
                 }
                 unset($comments[$key]);
                
            }
        }
        return $comments;
   }
   
   /**
    * post_comment
    *
    * @param  mixed $comments
    * @return void
    */
   public function post_comment($comments){
       return $this->db->table($this->table)->insert($comments);
   }
}  
