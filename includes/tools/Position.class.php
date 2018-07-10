<?php
namespace includes\tools;

use includes\Db;

/*
 * The position class  :
 *  - execute elements positionning in a table
 *
 * 
 * Example of use :

        $position = new Position( 'dbTable', 'dbFieldPosition' );

        // Operations
        $position->moveUp([ 'id' => INT, 'dbFieldId' => STRING, 'order' => INT[, 'idCategorie' => INT][, 'dbFieldCat' => STRING] ][, 'idLangue' => INT][, 'dbFieldLang' => STRING] ]);
        $position->moveDown([ 'id' => INT, 'dbFieldId' => STRING, 'order' => INT[, 'idCategorie' => INT][, 'dbFieldCat' => STRING] ][, 'idLangue' => INT][, 'dbFieldLang' => STRING] ]);
 
        $position->getNextPosition([ ['idCategorie' => INT][, 'dbField' => STRING] ][, 'idLangue' => INT][, 'dbFieldLang' => STRING] ]);
        $position->updatePositions([ 'dbFieldId' => STRING[, 'idCategorie' => INT][, 'dbField' => STRING] ][, 'idLangue' => INT][, 'dbFieldLang' => STRING] ]);
 *
 * 
 * @author Olivier Dommange (add you name if you make implementations)
 * @copyright GPL
 * @version 0.1
 */
class Position{

    private $dbTable;
    private $mapTable;
    
    private $dbFieldId    = null;
    private $dbFieldPosition;
    private $dbFieldCat   = null;
    private $dbFieldLang  = null;
    
    private $id           = null;
    private $order        = null;
    private $idCategorie  = null;
    private $idLangue     = null;
    
    private $errors       = [];
    private $params       = null;
    
    /**
     * Tranforms elements positions in a table
     * 
     * Parameters sent must indicate the reference sets by attributes in this class
     * 
     * 'dbFieldId' => STRING
     * 'dbFieldCat' => STRING | ARRAY (Accessory)
     * 'dbFieldLang' => STRING (Accessory)
     * 
     * 'id' => INT
     * 'idCategorie' => INT
     * 'order' => INT
     * 'idLangue' => INT (Accessory)
     * 
     * @example $position = new Position( 'dbTable', 'dbFieldPosition' );
     * @example $position->moveUp([ 'id' => INT, 'dbFieldId' => STRING, 'order' => INT[, 'idCategorie' => INT][, 'dbFieldCat' => STRING || ARRAY] ][, 'idLangue' => INT][, 'dbFieldLang' => STRING] ]);
     * @example $position->moveDown([ 'id' => INT, 'dbFieldId' => STRING, 'order' => INT[, 'idCategorie' => INT][, 'dbFieldCat' => STRING || ARRAY] ][, 'idLangue' => INT][, 'dbFieldLang' => STRING] ]);
     * @example $position->getNextPosition([ ['idCategorie' => INT][, 'dbField' => STRING] ][, 'idLangue' => INT][, 'dbFieldLang' => STRING] ]);
     * @example $position->updatePositions([ 'dbFieldId' => STRING[, 'idCategorie' => INT][, 'dbField' => STRING] ][, 'idLangue' => INT][, 'dbFieldLang' => STRING] ]);
     * 
     * @param string $dbTable           | Table name
     * @param string $dbFieldPosition   | Field name wich ordering elements
     * @param string $mapTable          | Map of the table used for the ORM
     * 
     */
    function __construct( $dbTable, $dbFieldPosition, $mapTable )
    {
        $this->dbTable          = $dbTable;
        
        $this->dbFieldPosition  = $dbFieldPosition;

        $this->mapTable         = $mapTable;
    }

    /**
     * 
     * @param integet $order Element to select from his position
     * @return object Db Row of the element selected
     */
    private function _findFromPosition( $order )
    {	
        $orm = new Orm( $this->dbTable, $this->mapTable );
        
        $params = [ $this->dbFieldPosition => $order ];
        
        
        if( isset( $this->dbFieldCat ) && isset( $this->idCategorie ) )   //// Get ID of cat
        {
           $params[ $this->dbFieldCat ] = $this->idCategorie;
        }
        if( isset( $this->dbFieldLang ) && isset( $this->idLangue ) )
        {
            $params[ $this->dbFieldLang ] = $this->idLangue; 
        }
        
        $result = $orm->select()->where($params)->first();

        if( !isset( $result ) )
        {
            $this->errors[ '_findFromPosition' ] = $orm->getQuery();
        }
        
        return $result;            
    }
    
    /**
     * Update in de database the position of an element defined by it's id
     * 
     * @param integer $id Element to update
     * @param integer $position New position
     */
    private function _requestUpdatePosition( $id, $position )
    {
        $orm = new Orm( $this->dbTable, $this->mapTable );
        
        $orm->prepareDatas([ $this->dbFieldPosition => $position ]);
        
        $result = $orm->update([ $this->dbFieldId => $id ]);
        
        if( !isset( $result ) )
        {
            $this->errors[ '_requestUpdatePosition' ] = $orm->getQuery();
        }
    }
    

    /**
     * Coordinate the changing of position by calling the methods
     * 
     * @return boolean | Always true
     */
    private function _changePosition( $dir = 'up' )
    {  
        $newOrder = ( $dir == 'up' ) ? $this->order - 1 : $this->order + 1;
        
        $slideUsed = $this->_findFromPosition( $newOrder );
        
        if( isset( $slideUsed ) )
        {
            $dbFieldId = $this->dbFieldId;
            
            $id  = $slideUsed->$dbFieldId;
            
            //echo $id . ',' . $this->order . '|' . $this->id . ',' . $newOrder;
            
            $this->_requestUpdatePosition( $id, $this->order );
            
            $this->_requestUpdatePosition( $this->id, $newOrder );
        
            return true;
        }
        else
        {
            $orm = new Orm( $this->dbTable, $this->mapTable );
            
            $results = $orm->select()->where( $this->_setQueryConditions() )->order( [ $this->dbFieldPosition => 'ASC' ] )->execute();
                
            $this->_updateGroupPositions( $results );
            
            return false;
        }
    }

    /**
     * Sends true if proccess went well. Send an array of errors otherwise
     * 
     * @return boolean | array 
     */
    private function _result()
    {
        if( isset( $this->errors ) && is_array( $this->errors ) && count( $this->errors ) > 0 )
        {
            $this->errors[ 'infos' ] = [ 
                'dbTable'           => $this->dbTable,
                'mapTable'          => $this->mapTable,
                'dbFieldId'         => $this->dbFieldId,
                'dbFieldPosition'   => $this->dbFieldPosition,
                'dbFieldCat'        => $this->dbFieldCat,
                'dbFieldLang'       => $this->dbFieldLang,
                'id'                => $this->id,
                'order'             => $this->order,
                'idCategorie'       => $this->idCategorie,
                'idLangue'          => $this->idLangue,
                ];

            return $this->errors;
        }
        
        return true;
    }
    
    /**
     * Initiate and execute the process of changing element position below from it's actual position
     * Parameters transfered are used to fill current class attributes of informations (fields and datas from the table)
     * 
     * 'dbFieldId' => STRING
     * 'dbFieldCat' => STRING | ARRAY (Accessory)
     * 'dbFieldLang' => STRING (Accessory)
     * 
     * 'id' => INT
     * 'idCategorie' => INT
     * 'order' => INT
     * 'idLangue' => INT (Accessory)
     * 
     * @example $position->moveDown([ 'id' => INT, 'dbFieldId' => STRING, 'order' => INT[, 'idCategorie' => INT][, 'dbFieldCat' => STRING || ARRAY] ][, 'idLangue' => INT][, 'dbFieldLang' => STRING] ]);
     * @param array $params Informations and datas to set
     * @return boolean | array Sends true if proccess went well. Send an array of errors otherwise
     */
    public function moveDown( $params )
    {	
        $this->_setParams( $params );

        $this->_changePosition( 'down' );
        
        return $this->_result();
    }

    /**
     * Initiate and execute the process of changing element position upward from it's actual position
     * Parameters transfered are used to fill current class attributes of informations (fields and datas from the table)
     * 
     * 'dbFieldId' => STRING
     * 'dbFieldCat' => STRING | ARRAY (Accessory)
     * 'dbFieldLang' => STRING (Accessory)
     * 
     * 'id' => INT
     * 'idCategorie' => INT (Accessory)
     * 'order' => INT
     * 'idLangue' => INT (Accessory)
     * 
     * @example $position->moveUp([ 'id' => INT, 'dbFieldId' => STRING, 'order' => INT[, 'idCategorie' => INT][, 'dbFieldCat' => STRING || ARRAY] ][, 'idLangue' => INT][, 'dbFieldLang' => STRING] ]);
     * @param array $params Informations and datas to set
     * @return boolean | array Sends true if proccess went well. Send an array of errors otherwise
     */
    public function moveUp( $params )
    {	
        $this->_setParams( $params );
        
        $this->_changePosition( 'up' );
        
        return $this->_result();
    }
    
    /**
     * Parameters transfered are used to fill current class attributes of informations (fields and datas from the table)
     * 
     * 'dbFieldId' => STRING
     * 'dbFieldCat' => STRING | ARRAY (Accessory)
     * 'dbFieldLang' => STRING (Accessory)
     * 
     * 'id' => INT
     * 'idCategorie' => INT (Accessory)
     * 'order' => INT
     * 'idLangue' => INT (Accessory)
     * 
     * @example $position->moveUp([ 'id' => INT, 'dbFieldId' => STRING, 'order' => INT[, 'idCategorie' => INT][, 'dbFieldCat' => STRING || ARRAY] ][, 'idLangue' => INT][, 'dbFieldLang' => STRING] ]);
     * @param array $params Informations and datas to set
     * @return void
     */
    private function _setParams( $params )
    {
        if( count( $params ) > 0 )
        {
            $this->params = $params;

            foreach( $params as $k => $param )
            {
               $this->$k   = ( isset( $params[ $k ] ) )  ? $params[ $k ]    : null;
            }
        }
        if( isset( $this->dbFieldCat ) && isset( $this->id ) && isset( $this->dbFieldId ) && !isset( $this->idCategorie ) )
        {
            $this->idCategorie = $this->_setField( $this->dbFieldCat );
        }
        if( isset( $this->dbFieldLang ) && isset( $this->id ) && isset( $this->dbFieldId ) && !isset( $this->idLangue ) )
        {
            $this->idLangue = $this->_setField( $this->dbFieldLang ); 
        }
    }

    /**
     * Gets the values of a field in a table for an element. 
     * This element is identified by it's id (attribute dbFieldId).
     * This method is mostly used for getting values for a category or language field
     *  
     * @param string | array $fieldName Field to get it's current value
     * @return string | array Value of the field or fields to check
     */
    private function _setField( $fieldName )
    {
        $orm = new Orm( $this->dbTable, $this->mapTable ); 
        
        $row = $orm->select()->where([ $this->dbFieldId => $this->id ])->first();

        if( !isset( $row ) )
        {
            $this->errors[ '_setField' ] = $orm->getQuery();
        }
        
        if( is_array( $fieldName ) )
        {
            $cat = [];
            foreach( $fieldName as $field )
            {
                $cat[] = $row->$field;
            }
        }
        else
        {
            $cat = $row->$fieldName;
        }
        
        return $cat;
        
    }
    
      /**
     * Set in an array values set in attributes.
     * Pattern : array[ attributeField => attributeValue ]
     * 
     * @param array $array Array that will be returned with datas in it
     * @param string $attributeField
     * @param string $attributeValue
     * @return array
     */
    private function _setInArrayDatas( $array, $attributeField, $attributeValue)
    {
        
        if( isset( $this->$attributeValue ) && isset( $this->$attributeField ) )
        { 
            if( is_array( $this->$attributeValue ) && is_array( $this->$attributeField ) )
            {
                foreach( $this->$attributeField as $n => $field )
                {
                    $value = ( isset( $this->$attributeValue[ $n ] ) )  ? $this->$attributeValue[ $n ] : 0;
                    if( isset( $this->$attributeValue[ $n ] ) )
                    {
                        $array[ $this->dbTable . '.' . $field ] = $value;
                    }
                }
            }
            else
            {
                $value = ( isset( $this->$attributeValue ) )  ? $this->$attributeValue : 0;
                if( isset( $this->$attributeValue ) )
                {
                    $array[ $this->$attributeField ] = $value;
                }                
            } 
        }
        
        return $array;
    }
    
    /**
     * Defines condition to be set in the ORM request from the attribute values
     * 
     * @return array
     */
    private function _setQueryConditions()
    {   
        $params = [];
        
        $params = $this->_setInArrayDatas( $params, 'dbFieldCat', 'idCategorie' );
        
        $params = $this->_setInArrayDatas( $params, 'dbFieldLang', 'idLangue' );
       
        return $params;
    }
    
    

    /**
     * Update positions of a group of elements one by one set in an array
     * 
     * @param array $results
     */
    private function _updateGroupPositions( $results )
    {   
        if( is_array( $results ) )
        {
            foreach( $results as $n => $result )
            {
                $fieldId = $this->dbFieldId;

                $this->_requestUpdatePosition( $result->$fieldId, ( $n + 1 ) );
            }
        }
    }
    
    
    /**
     * Update data in database depending on params sent
     * 
     * 'dbFieldId' => STRING
     * 'dbFieldCat' => STRING | ARRAY (Accessory)
     * 'dbFieldLang' => STRING (Accessory)
     * 
     * 'idCategorie' => INT (Accessory)
     * 'idLangue' => INT (Accessory)
     * 
     * @example $position->updatePositions([ 'dbFieldId' => STRING[, 'dbFieldCat' => INT||ARRAY][[, 'idCategorie' => INT][, 'dbField' => STRING] ][, 'idLangue' => INT][, 'dbFieldLang' => STRING] ]);
     * @param array $params
     */
    public function updatePositions( $params = [] )
    {	
        $this->_setParams( $params );
        
        $orm = new Orm( $this->dbTable, $this->mapTable );
        
        if( isset( $this->dbFieldCat ) )
        {
            $group = [];
            
            if( is_array( $this->dbFieldCat ) )
            {
                foreach( $this->dbFieldCat as $field )
                {
                    $group[ $this->dbTable ] = $field;
                }
            }
            else
            {
                $group[ $this->dbTable ] = $this->dbFieldCat;
            }
            
            $results = $orm->select()->group( $group )->execute();

            if( !isset( $results ) )
            {
                $this->errors[ 'updatePositions' ] = $orm->getQuery();
            }
            
            foreach( $results as $resultTab )
            {
                $where = [];
                
                if( is_array( $this->dbFieldCat ) )
                {
                    foreach( $this->dbFieldCat as $field )
                    {
                        $where[ $this->dbTable . '.' . $field ] = $resultTab->$field; // $rowTab->$field;
                    }
                }
                else
                {
                    $dbFieldCat = $this->dbFieldCat;
                    
                    $where[ $this->dbTable . '.' . $this->dbFieldCat ] = $resultTab->$dbFieldCat; // $rowTab->$this->dbFieldCat;
                }
                
                $resultsCat = $orm->select()->where( $where )->order( [ $this->dbFieldPosition => 'ASC' ] )->execute();

                if( !isset( $resultsCat ) )
                {
                    $this->errors[ 'updatePositions' ] = $orm->getQuery();
                }
                
                $this->_updateGroupPositions( $resultsCat );
            }
        }
        else
        {
            $resultsCat = $orm->select()->where( $this->_setQueryConditions() )->order( [ $this->dbFieldPosition => 'ASC' ] )->execute();

            if( !isset( $resultsCat ) )
            {
                $this->errors[ 'updatePositions' ] = $orm->getQuery();
            }
        
            $this->_updateGroupPositions( $resultsCat );
        }
    }
    
    
    /**
     * Send back the next position available depending on a category and/or language if necessary
     * 
     * 'dbFieldCat' => STRING | ARRAY (Accessory)
     * 'dbFieldLang' => STRING (Accessory)
     * 
     * 'idCategorie' => INT (Accessory)
     * 'idLangue' => INT (Accessory)
     * 
     * @example $position->getNextPosition([ ['idCategorie' => INT][, 'dbFieldCat' => STRING] ][, 'idLangue' => INT][, 'dbFieldLang' => STRING] ]);
     * @param type $params
     * @return object
     */
    public function getNextPosition( $params = [] )
    {	
        $this->_setParams( $params );
        
        $orm = new Orm( $this->dbTable, $this->mapTable );
        
        $numRows = $orm->select()->where( $this->_setQueryConditions() )->count();

        if( !isset( $numRows ) )
        {
            $this->errors[ 'getNextPosition' ] = $orm->getQuery();
        }
        
        return $numRows;
    }
    
}