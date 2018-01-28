<?php  
namespace applications\users;

use includes\components\CommonModel;

use includes\tools\Orm;
use includes\Request;
  
/**
 * class Model
 * 
 * Filters apps datas
 *
 * @param array $_beneficiaire  | Table and fields structure "users".
 *                  
 */
class ModelUsers extends CommonModel {     
    
    
    function __construct() 
    {
        $this->_setTables(['users/builders/BuilderUsers']);
        
        $this->_setModels([ 'users/ModelGroups' ]);
        
    }

    /**
     * Select datas form the table "users"
     * 
     * @param array $params | (optional) Conditions [ 'Field'=>value ]
     * @param str   $period | (optional) Period or state depending on value choosed
     *                        ('all', 'archive', 'actual', 'future', 'cancel', search, or integer(year-YYYY))
     *                        'all' by default
     * @param array $groups | (optional) Group(s) Type ('participants' or 'manager') or 'all' (for all groups)
     * @return array        | Results of the selection in the database.
     */
    public function users( $params = [] )
    {
        $orm = new Orm( 'users', $this->_dbTables['users'], $this->_dbTables['relations'] );

        $result = $orm    ->select()
                ->joins( ['users'=>['groups']] )
                ->where( $params )
                ->execute( true );
        
        return $result;
    }
    
    
    /**
     * Prepare datas for the formulas 
     * depending on the table "beneficiaire".
     * Manage sending. Returns settings datas and errors
     * 
     * @param int $id       | (optional) Id of the content. 
     * @return object       | Datas and errors.
     */   
    public function userBuild( $id = null )
    {
        $orm = new Orm( 'users', $this->_dbTables['users'] );
            
        $orm->prepareGlobalDatas( [ 'POST' => true ] );
        
        $params = ( isset( $id ) ) ? ['IdUser' => $id] : null;
            
        return $orm->build( $params );
    }
    
    /**
     * Updates datas in the database.
     * Do insert and update.
     * Figure errors and send back false in that case
     * 
     * @param string $action  | (optionnal) Action to do.
     *                          Default : does insert.
     *                          Defined by "insert" or "update". 
     * @param int $id         | (optional) Id of the content to update.
     *                          It is mandatory for updates.
     * @return boolean|object | false when errors are found 
     *                          (ex. empty fields, bad file format imported,...). 
     *                          Object with content datas when process went good. 
     */ 
    public function userUpdate( $action = 'insert', $id = null) 
    {
        $orm        = new Orm( 'users', $this->_dbTables['users'] );
        
        $datas = $orm->prepareGlobalDatas( [ 'POST' => true ] );

        if( !$orm->issetErrors() )
        {
            if( $action === 'insert' )
            {
                $request        = Request::getInstance();
                $newpassword    = $request->genToken( 3 );
                        
                $orm->prepareDatas([ 'PassUser' => $newpassword, 'PseudoUser' => $datas['EmailUser'] ]);
             
                $data = $orm->insert();                
                
                $id = $data->IdUser;
            }
            else if( $action === 'update' )
            {
                $data = $orm->update([ 'IdUser' => $id ]);
            }    
            
            return $data;
        }
        else
        {
            return false;
        }
    }

    
    /**
     * Delete an entry in the database.
     * 
     * @param int $id   | Id of the content to delete.
     * @return boolean  | Return's true in all cases.    
     */
    public function userDelete( $id ) 
    {
        $orm = new Orm( 'users', $this->_dbTables['users'] );
            
        $orm->delete([ 'IdUser' => $id ]);
        
        return true;
    } 

}