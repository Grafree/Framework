<?php
namespace applications\users;

use includes\components\CommonController;
use includes\Request;
use stdClass;

class Controller extends CommonController{
    
    private $_formDisplay = [];

    
    private function _setuserForm()
    {   
        $this->_setModels( [ 'users/ModelUsers', 'system/ModelSystem' ] );

        $modelUsers             = $this->_models[ 'ModelUsers' ];
        $modelSystem            = $this->_models[ 'ModelSystem' ];    
        
        $this->_datas = new stdClass;
     
        $id = ( !empty( $this->_router ) ) ? $this->_router : null;
        
        $this->_formDisplay['user']   = true;
        
        $this->_formDisplay['detail'] = ( isset( $id ) ) ? false : true;
        
        $this->_formDisplay['formaction'] = SITE_URL.'/users/userupdate/'.( ( isset( $id ) ) ? $id : '' );

        $this->_datas->form          = $modelUsers->userBuild( $id );

        $this->_datas->formDisplay  = $this->_formDisplay;
        
        $this->_datas->countries    = $modelSystem->getCountries();
        
        $this->_datas->groups       = $this->_interface->getGroups();
        
        $this->_datas->response     = $this->_interface->getUserFormUpdatedDatas( $this->_datas->form );

        $this->_view = 'users/user-form';
    }
    
    
    private function _setgroupForm()
    {      
        $this->_setModels( ['users/ModelGroups' ] );
        
        $modelGroups    = $this->_models[ 'ModelGroups' ];
        
        $id = ( !empty( $this->_router ) ) ? $this->_router : null;

        $this->_datas = new stdClass;

        $this->_datas->form = $modelGroups->groupBuild( $id );
        
        $this->_datas->menus = $this->_interface->getMenus();
        
        $this->_view = 'users/group-form';
    }
       

    
    protected function _setDatasView()
    {
        $this->_setModels( [ 'users/ModelUsers', 'users/ModelGroups' ] );

        $modelUsers     = $this->_models[ 'ModelUsers' ];
        $modelGroups    = $this->_models[ 'ModelGroups' ];
        
        
        switch( $this->_action )
        {      
            // GROUPS
            
            case 'groups':
                
                $this->_datas = new stdClass;
                
                $this->_datas->response     = $this->_interface->getUpdatedGroupDatas( $this->_router );
                
                $this->_datas->tableDatas   = $modelGroups->groupsAndRights();
                
                $this->_datas->tableHead    = $this->_interface->getGroupHead();
                
                $this->_view = 'users/groups-list';
                
            break;
            
        
            case 'groupform':
                
                $this->_setgroupForm();
                
            break;
        
        
            
            case 'groupupdate':
                
                $id     = ( !empty( $this->_router ) ) ? $this->_router : null;
                $action = ( !empty( $this->_router ) ) ? 'update' : 'insert';
                
                if( $data = $modelGroups->groupUpdate( $action, $id ) )
                {
                    header( 'location:' . SITE_URL . '/users/groups/success' . $action . '/' . $data->IdGroup );
                    
                    exit;
                }
                else 
                {
                    $this->_setgroupForm();
                }
            break;
            
            
            case 'groupdeleteAjax':
                
                $datas = new stdClass;

                if( $this->_datas = $modelGroups->groupDelete( $this->_request->getVar( 'id' ) ) )
                {
                    echo json_encode([ 'token' => $_SESSION[ 'token' ], 'status' => 'OK', 'data' => $datas, 'msg' => 'un groupe vient d\'être supprimé.' ]); 
                }
                else
                {
                    echo json_encode([ 'token' => $_SESSION[ 'token' ], 'status' => 'FAIL', 'data' => $datas, 'msg' => '' ]);   
                }
                
                exit;
                
            break;
            
            
        
            case 'groupactiverightAjax':
                
                $datas = new stdClass;
                
                if( $return = $modelGroups->groupActiveUpdate( $this->_request->getVar( 'id' ) ) )
                {
                    $msg = '';
                    
                    $active = ( $return[ 'active' ] ) ? ' a dorénavant ' : ' n\'a dorénavant plus ';
                    if( $return[ 'action' ] === 'r' )
                    {
                        $msg = 'Le groupe '.$return['group']->NameGroup . '<strong>' . $active . 'le droit de lecture</strong> pour la rubrique &laquo;' . $return['menu']->NameMenu .'&raquo;.';
                    }
                    else if( $return[ 'action' ] === 'w' )
                    {
                        $msg = 'Le groupe '.$return['group']->NameGroup . '<strong>' . $active . 'le droit d\'écriture</strong> pour la rubrique &laquo;' . $return['menu']->NameMenu .'&raquo;.';
                    }
                    else if( $return[ 'action' ] === 'm' )
                    {
                        $msg = 'Le groupe '.$return['group']->NameGroup . '<strong>' . $active . 'le droit de modification</strong> pour la rubrique &laquo;' . $return['menu']->NameMenu .'&raquo;.';
                    }
                    else if( $return[ 'action' ] === 'd' )
                    {
                        $msg = 'Le groupe '.$return['group']->NameGroup . '<strong>' . $active . 'le droit de suppression</strong> pour la rubrique &laquo;' . $return['menu']->NameMenu .'&raquo;.';
                    }
                    else if( $return[ 'action' ] === 'v' )
                    {
                        $msg = 'Le groupe '.$return['group']->NameGroup . '<strong>' . $active . 'le droit de validation</strong> pour la rubrique &laquo;' . $return['menu']->NameMenu .'&raquo;.';
                    }
                    echo json_encode([ 'token' => $_SESSION[ 'token' ], 'status' => 'OK', 'data' => $datas, 'msg' => $msg ]);
                }
                else
                {
                    echo json_encode([ 'token' => $_SESSION[ 'token' ], 'status' => 'FAIL', 'data' => $datas, 'msg' => '' ]); 
                }
                exit;
                
            break;
            
        
            
            
            
            
            
            // USERS
            
            case 'userform':
                
                $this->_setuserForm();
                
            break;
        
        
            case 'userupdate':
                
                $id     = ( !empty( $this->_router ) ) ? $this->_router : null;
                $action = ( !empty( $this->_router ) ) ? 'update' : 'insert';
                
                if( $data = $modelUsers->UserUpdate( $action, $id ) )
                {
                    header( 'location:' . SITE_URL . '/users/users/success' . $action . '/' . $data->IdUser );
                    
                    exit;
                }
                else 
                {
                    $this->_setuserForm();
                }
            break;
            
            
            case 'userdeleteAjax':
                
                $datas = new stdClass;

                if( $this->_datas = $modelUsers->userDelete( $this->_request->getVar( 'id' ) ) )
                {
                    echo json_encode([ 'token' => $_SESSION[ 'token' ], 'status' => 'OK', 'data' => $datas, 'msg' => 'Un utilisateur vient d\'être supprimé.' ]); 
                }
                else
                {
                    echo json_encode([ 'token' => $_SESSION[ 'token' ], 'status' => 'FAIL', 'data' => $datas, 'msg' => '' ]);   
                }
                
                exit;
                
            break;  
            
        
            case 'search' :
                
                $this->_datas = new stdClass;
                
                $req = Request::getInstance();
                
                $this->_datas->searchfield  = ( $req->getVar( 'search' ) !== null ) ? $req->getVar( 'search' ) : '';
                
                $this->_datas->datas        = $modelUsers->users();
                
                $this->_datas->response     = $this->_interface->getUserUpdatedDatas( $this->_router );
                
                $this->_view = 'users/users-list';
                
            break;
             
            
            default :
                
                $this->_datas = new stdClass;
                
                $this->_datas->searchfield  = '';
                
                $this->_datas->datas        = $modelUsers->users();
                
                $this->_datas->response     = $this->_interface->getUserUpdatedDatas( $this->_action.'/'.$this->_router );
                
                $this->_view = 'users/users-list';
                
            break;
            
        } 
    }
}