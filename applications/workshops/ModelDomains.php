<?php
namespace applications\workshops;

use includes\components\CommonModel;

use includes\tools\Orm;
use includes\tools\Date;
use includes\Request;
use includes\Lang;

class ModelDomains extends CommonModel {
    
    public function __construct() 
    {
        $this->_setTables(['workshops/builders/BuilderDomains']);
    }

    
         
        
    /**
     * Select datas form the table "domaine_ateliers"
     * 
     * @param array $param  | (optional)
     *                        Selection conditions depending on the field's name and it's value
     *                        Example : [ 'IDDomaineAtelier'=>1 ]
     * @return object       | Results of the selection in the database.
     *//*
    public function domaine_ateliers( $params = [] ) {
    
        $orm = new Orm( 'domaine_ateliers', $this->_dbTables['domaine_ateliers'] );
        
        $result = $orm  ->select()
                        ->where( $params )
                        ->order([ 'NomDomaineAtelier' => 'ASC' ])
                        ->execute();
        
        return $result;
    }    
    */
    
    
    /**
     * Select datas form the table "domaine"
     * 
     * @param array $param  | (optional)
     *                        Selection conditions depending on the field's name and it's value
     *                        Example : [ 'IDDomaine'=>1 ]
     * @return object       | Results of the selection in the database.
     */
    public function domains( $params = [] ) {
    
        $orm = new Orm( 'domaine', $this->_dbTables['domaine'] );
        
        $result = $orm  ->select()
                        ->where( $params )
                        ->order([ 'IDDomaine' => 'ASC' ])
                        ->execute( true );
        
        return $result;
    }    
    
    public function domainesBuild($id = null )
    {
        $orm = new Orm( 'domaine', $this->_dbTables['domaine'] );
            
        $orm->prepareGlobalDatas( [ 'POST' => true ] );
        
        $params = ( isset( $id ) ) ? ['IDDomaine' => $id] : null;
            
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
    public function domaineUpdate( $action = 'insert', $id = null) 
    {
        $orm        = new Orm( 'domaine', $this->_dbTables['domaine'] );
        $errors     = false;
        
        $datas = $orm->prepareGlobalDatas( [ 'POST' => true ] );

        if( !$orm->issetErrors() )
        {
            if( $action === 'insert' )
            {
                $data = $orm->insert();
            }
            else if( $action === 'update' )
            {
                $data = $orm->update([ 'IDDomaine' => $id ]);
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
    public function domaineDelete( $id ) 
    {
        $orm = new Orm( 'domaine', $this->_dbTables['domaine'] );
            
        $orm->delete([ 'IDDomaine' => $id ]);
        
        return true;
    } 

    
    public function getDomains( $params = [] )
    {
        $domainList = [];

        $domains = $this->domains( $params );
                
        if( is_array( $domains ) )
        {
            foreach( $domains as $domain )
            {   
                $domainList[] = ['value' => $domain->IDDomaine, 'label'=> $domain->NomDomaine ];
            }
        }
        
        return $domainList;    
    }
    
}