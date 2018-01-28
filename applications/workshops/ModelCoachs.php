<?php
namespace applications\workshops;

use includes\components\CommonModel;

use includes\tools\Orm;
use includes\tools\Date;
use includes\Request;
use includes\Lang;

class ModelCoachs extends CommonModel {
        
    public function __construct() 
    {     
        $this->_setTables(['workshops/builders/BuilderCoachs']);
    }
    
    
        
    /**
     * Select datas form the table "formateur"
     * 
     * @param array $param  | (optional)
     *                        Selection conditions depending on the field's name and it's value
     *                        Example : [ 'IdCoach'=>1 ]
     * @return object       | Results of the selection in the database.
     */
    public function coachs( $params = [] )
    {
        $orm = new Orm( 'coachs', $this->_dbTables['coachs'] );
        
        $result = $orm  ->select()
                        ->where( $params )
                        ->order([ 'LastnameCoach' => 'ASC' ])
                        ->execute( true );
        
        return $result;
    }    
    
    public function coachsDatas( $params = [] )
    {
        $coachs = $this->coachs( $params );
        
        $this->_setModels( 'workshops/ModelWorkshops' );
        
        $modelWorkshops = $this->_models[ 'ModelWorkshops' ];
        
        if( isset( $coachs ) )
        {
            foreach( $coachs as $coach )
            {
                $coach->workshopsActual     = $modelWorkshops->workshops([ 'workshops.IdCoach' => $coach->IdCoach, 'StatutWorkshop'=>'actif' ]);
                
                $coach->workshopsArchive     = $modelWorkshops->workshops([ 'workshops.IdCoach' => $coach->IdCoach, 'StatutWorkshop'=>'archive' ]);
            
                $coach->workshopsNbActual   = ( isset( $coach->workshopsActual ) ) ? count( $coach->workshopsActual ) : '0';
                
                $coach->workshopsNbArchive  = ( isset( $coach->workshopsArchive ) ) ? count( $coach->workshopsArchive ) : '0';
                
                $coach->StatutFormateur = ( empty( $coach->IsActiveCoach ) ) ? 'archive' : 'actif' ;
                
                $coach->isDeletable         = ( $coach->workshopsNbActual  == 0 && $coach->workshopsNbArchive  == 0 ) ? true : false;
            }
        }
        
        return $coachs;
    }
        
    /**
     * Prepare datas for the formulas 
     * depending on the table "formateur".
     * Manage sending. Returns settings datas and errors
     * 
     * @param int $id       | (optional) Id of the content. 
     * @return object       | Datas and errors.
     */   
    public function coachBuild( $id = null )
    {
        $orm = new Orm( 'coachs', $this->_dbTables['coachs'] );
            
        $orm->prepareGlobalDatas( [ 'POST' => true ] );
        
        $params = ( isset( $id ) ) ? ['IdCoach' => $id] : null;
            
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
    public function coachUpdate( $action = 'insert', $id = null) 
    {
        $orm        = new Orm( 'coachs', $this->_dbTables['coachs'] );
        
        $orm->prepareGlobalDatas( [ 'POST' => true ] );
        
        if( !$orm->issetErrors())
        {
            if( $action === 'insert' )
            {
                $data = $orm->insert();
            }
            else if( $action === 'update' )
            {
                $orm->prepareDatas([ 'IsActiveCoach' => 1 ]);
                
                $data = $orm->update([ 'IdCoach' => $id ]);
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
    public function coachDelete( $id ) 
    {
        $orm = new Orm( 'coachs', $this->_dbTables['coachs'] );
            
        $orm->delete([ 'IdCoach' => $id ]);
        
        return true;
    } 

    
    public function getCoachs( $params = [] )
    {
        $coachList = [];

        $coachs = $this->coachs( $params );
                
        if( is_array( $coachs ) )
        {
            foreach( $coachs as $coach )
            {   
                $coachList[] = ['value' => $coach->IdCoach, 'label'=> $coach->FirstnameCoach.' '.$coach->LastnameCoach ];
            }
        }
        
        return $coachList;    
    }
    

}