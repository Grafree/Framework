<?php
namespace applications\workshops;

use includes\components\Module;


class InterfaceModule extends Module
{
    private     $_tabsConfig;
    protected   $_tabs;
    protected   $_list;
    private     $_types_question;
    private     $_tablehead_questions;   
    
    public function __construct()
    {
        $this->_tabsConfig = [
            [ 'title' => 'Ateliers', 'action' => 'coaching', 'url' => '/workshops/workshops', 'class' => 'active' ], 
            [ 'title' => 'Questions', 'action' => 'coaching_evaluation_questions', 'url' => '/workshops/questions', 'class' => '' ], 
            [ 'title' => 'Formateurs', 'action' => 'formateur', 'url' => '/workshops/coachs', 'class' => '' ], 
        ];
        
        $this->_tabs = [
            'workshops'     => [ 'title' => 'Formations',   'action' => 'workshops',       'url' => '/workshops/workshops',     'class' => 'active' ], 
            'coachs'        => [ 'title' => 'Formateurs',   'action' => 'coachs',          'url' => '/workshops/coachs',        'class' => '' ], 
            'questions'     => [ 'title' => 'Evaluations',  'action' => 'questions',       'url' => '/workshops/questions',     'class' => '' ], 
            'domains'       => [ 'title' => 'Domaines',     'action' => 'domains',         'url' => '/workshops/domains',       'class' => '' ], 
        ];
        
        $this->_list = [
            'workshops' => [ 'title' => 'Ateliers', 'displayinfos' => [ 'ondemand' => true, 'registered' => true, 'followed' => true ]],
            'all'       => [ 'title' => 'Tous',    'action' => 'all',      'url' => '/workshops/workshops/all',     'class' => '',       'displayinfos' => [ 'ondemand' => false, 'registered' => false, 'followed' => false ] ], 
            'actual'    => [ 'title' => 'Actuels', 'action' => 'actual',   'url' => '/workshops/workshops/actual',  'class' => 'active', 'displayinfos' => [ 'ondemand' => true, 'registered' => true, 'followed' => true ] ], 
            'archive'   => [ 'title' => 'Archive', 'action' => 'archive',  'url' => '/workshops/workshops/archive', 'class' => '',       'displayinfos' => [ 'ondemand' => false, 'registered' => false, 'followed' => false ] ], 
        ];
        
        $this->_listcoach = [
            'coachs' => [ 'title' => 'Formateurs' ],
            'all'    => [ 'title' => 'Tous',    'action' => 'all',      'url' => '', 'filter'=>'all',       'class' => 'active' ], 
            'actual' => [ 'title' => 'Actuels', 'action' => 'actual',   'url' => '', 'filter'=>'actif',     'class' => '' ], 
            'archive'=> [ 'title' => 'Archive', 'action' => 'archive',  'url' => '', 'filter'=>'archive',   'class' => '' ], 
        ];
        
        $this->_types_question = [
            ['value' => 1, 'label'=> 'Champ' ],
            ['value' => 2, 'label'=> 'Zone de texte' ],
            ['value' => 3, 'label'=> 'Evaluation 1 à 5' ],
            ['value' => 4, 'label'=> 'Oui ou Non' ]
        ];
         
        $this->_tablehead_questions = [ 'cells' => [
                [ 'title' => '#', 'colspan' => '1', 'class' => 'cell-mini' ],
                [ 'title' => 'Question', 'colspan' => '1', 'class' => 'cell-mini'],
                [ 'title' => 'StatutQuestion', 'colspan' => '1', 'class' => 'cell-mini'],
                [ 'title' => 'Modifier', 'colspan' => '1', 'class' => 'cell-small', 'right' => 'update', 'rightmenu' => 'workshops', 'rightaction' => '' ],
                [ 'title' => 'Supprimer','colspan' => '1', 'class' => 'cell-small', 'right' => 'delete', 'rightaction' => '' ]
        ] ];
        
    }   
    
    
    public function getDisplayinfos( $action = 'actual' )
    {
        return $this->_list[ $action ]['displayinfos'];
    }
    
    public function getQuestionsTableHead()
    {
        return $this->_tablehead_questions;
    }
    
    public function getTypeQuestions()
    {
        return $this->_types_question;
    }
    
    
    public function checkPeriod( $action )
    {
        $actionChecked = 'actual';
        
        foreach( $this->_list as $t => $item )
        {
            if( $t === $action )
            {
                $actionChecked = $action;
            }
        }
        return $actionChecked;
    }
    
    
    public function checkCoachPeriod( $action )
    {
        $actionChecked = 'actual';
        
        foreach( $this->_listcoach as $t => $item )
        {
            if( $t === $action )
            {
                $actionChecked = $action;
            }
        }
        return $actionChecked;
    }
    
       
    
    
    public function getWorkshops( $period )
    {
        $this->_setModels(['workshops/ModelWorkshops']);
        
        $modelWorkshops = $this->_models[ 'ModelWorkshops' ];
        
        $modelWorkshops->setParams([
                                'datasLimitSet' => 'workshops', 
                                'domains'       => [ 'orm' => [ 'domaine_atelier_office.IDOffice' => $_SESSION['adminOffice'] ] ],
                                'workshops'     => [ 'orm' => [ 'coaching.IDCorporate' => $_SESSION['adminOffice'] ], 'period' => $period, 'extendedInfos' => false]
                                ]);
                
        $workshopDomains = $modelWorkshops->domainsWorkshops();
                
        $workshopsList = [];
        
        if( isset( $workshopDomains->all ) )
        {
            foreach( $workshopDomains->all as $domain )
            {                   
                if( isset( $domain->subdomains->all ) )
                {
                    foreach( $domain->subdomains->all as $subdomain )
                    {                  
                        if( isset( $subdomain->workshops ) )
                        {
                            $options = [];
                            foreach( $subdomain->workshops as $workshop )
                            { 
                                $options[] = ['value' => $workshop->IDCoaching, 'label'=>$workshop->NomCoaching ];
                            }
                            $workshopsList[] = [ 'name' => $subdomain->NomDomaine, 'options' => $options ];
                        }
                    }
                }
            }
        }
        
        return $workshopsList;    
    }
    
    
    /**
     * Inform for each user their subscibtion state
     * 
     * @param array $workshopsUsersBuild    | Infos set from the current workshop and user that is 
     *                                        in interaction (demand, subscribe, followed or absent) with it
     * @param type $return                  | Define what is returned  :
     *                                          'subscribe' : Array with all states OR 
     *                                          'checkbox'  : Array formated for the form component view as a checkbox-list
     * @return type
     */
    public function getUsersSubscribe( $datas = [ 'IdWorkshop' => null ] )
    {        
        $this->_setModels( [ 'workshops/ModelWorkshops' ] );

        $modelWorkshops   = $this->_models[ 'ModelWorkshops' ];

        $params = ( isset( $datas[ 'IdWorkshop' ] ) ) ? [ 'IdWorkshop' => $datas[ 'IdWorkshop' ]] : null;
        
        $WorkshopUserBuilds = $modelWorkshops->workshopSubscribeBuild( $params ); 
        
        $users = $this->_getUsers();
        
        $datasList  = [];
        
        if( is_array( $users ) )
        {
            foreach( $users as $user )
            {       
                $checked = false;
                
                if( isset( $WorkshopUserBuilds ) )
                {
                    foreach( $WorkshopUserBuilds as $build )
                    {
                        if( isset( $build->IdUser ) && $build->IdUser === $user->IdUser )
                        {
                            $checked = true;
                        }
                    }
                }
                
                $datasList[] = ['value' => $user->IdUser, 'label'=>$user->LastnameUser.' '.$user->FirstnameUser.' ('.$user->EmailUser.')', 'checked' => $checked ];
            }
        }
        
        return $datasList;
        //return [ 'actual'=> $usersListActual, 'future' => ( count( $usersListFuture ) > 0 ) ? $usersListFuture : null, 'other' => ( count( $usersListOther ) > 0 ) ? $usersListOther : null ];    
    }
    
    private function _getUsers()
    {
        $this->_setModels( 'users/ModelUsers' );
        
        $modelUsers     = $this->_models[ 'ModelUsers' ];
        
        return $modelUsers->users();
    }
    
    
    
    /**
     * Defines what info is sent back to the uset after an  
     * interaction (insert, update or delete) has been mad with the database.
     * 
     * @param str $urlDatas     | Last part of the Url (Router).
     * @return array            | Return's infos to display :
     *                            'updated'       | boolean   If an interaction has been made
     *                            'updatemessage' | str       Message content
     *                            'updatedid'     | int       Id of the content inserted, updated or deleted
     */
    public function getDomaineUpdatedDatas( $urlDatas )
    {
        $updatemessage  = '';

        $alert          = 'success'; // 'success', 'info', 'warning', 'danger' 
        
        $msgDatas = $this->_updatedMsgDatas( $urlDatas, 'workshops/ModelDomains/domains', 'IDDomaine', 'NomDomaine' );

        if( $msgDatas[ 'updated' ] )
        {
            $updatemessage .= ( $msgDatas[ 'action' ] === 'successinsert' ) ? 'Le domaine <strong><a href="#'.$msgDatas[ 'updatedid' ].'">'.$msgDatas[ 'updatedname' ] . '</a></strong> vient d\'être ajouté.' : '';

            $updatemessage .= ( $msgDatas[ 'action' ] === 'successupdate' ) ? 'Le domaine <strong><a href="#'.$msgDatas[ 'updatedid' ].'">'.$msgDatas[ 'updatedname' ] . '</a></strong> vient d\'être mise à jour.' : '';

            $updatemessage .= ( $msgDatas[ 'action' ] === 'successdelete' ) ? 'Un domaine vient d\'être supprimé.' : '';
            
        }
        
        return [ 'updated' => $msgDatas[ 'updated' ], 'updatemessage' => $updatemessage, 'updateid' => $msgDatas[ 'updatedid' ], 'alert' => $alert ];
    }
    
    
    /**
     * Defines what info is sent back to the uset after an  
     * interaction (insert, update or delete) has been mad with the database.
     * 
     * @param str $build     | Build datas for froms.
     * @return array            | Return's infos to display :
     *                            'updated'       | boolean   If an interaction has been made
     *                            'updatemessage' | str       Message content
     *                            'updatedid'     | int       Id of the content inserted, updated or deleted
     */
    public function getDomaineFormUpdatedDatas( $build )
    {
        $updatemessage  = '';

        $alert          = 'success'; // 'success', 'info', 'warning', 'danger' 
        
        $updated        = false;
        
        if( isset( $build->errors ) )
        {
            $updatemessage = 'Certains champs ont été mal remplis.';
            $updated        = true;    
            $alert          = 'danger';
        }
        
        return [ 'updated' => $updated, 'updatemessage' => $updatemessage, 'updateid' => null, 'alert' => $alert ];
    }

 
    /**
     * Defines what info is sent back to the uset after an  
     * interaction (insert, update or delete) has been mad with the database.
     * 
     * @param str $urlDatas     | Last part of the Url (Router).
     * @return array            | Return's infos to display :
     *                            'updated'       | boolean   If an interaction has been made
     *                            'updatemessage' | str       Message content
     *                            'updatedid'     | int       Id of the content inserted, updated or deleted
     */
    public function getQuestionUpdatedDatas( $urlDatas )
    {
        $updatemessage  = '';

        $alert          = 'success'; // 'success', 'info', 'warning', 'danger' 
        
        $msgDatas = $this->_updatedMsgDatas( $urlDatas, 'workshops/ModelQuestions/questions', 'IDQuestion', 'Question' );

        if( $msgDatas[ 'updated' ] )
        {
            $updatemessage .= ( $msgDatas[ 'action' ] === 'successinsert' ) ? 'La question <strong><a href="#'.$msgDatas[ 'updatedid' ].'">'.$msgDatas[ 'updatedname' ] . '</a></strong> vient d\'être ajoutée.' : '';

            $updatemessage .= ( $msgDatas[ 'action' ] === 'successupdate' ) ? 'La question <strong><a href="#'.$msgDatas[ 'updatedid' ].'">'.$msgDatas[ 'updatedname' ] . '</a></strong> vient d\'être mise à jour.' : '';

            $updatemessage .= ( $msgDatas[ 'action' ] === 'successdelete' ) ? 'La question vient d\'être supprimée.' : '';
            
        }
        
        return [ 'updated' => $msgDatas[ 'updated' ], 'updatemessage' => $updatemessage, 'updateid' => $msgDatas[ 'updatedid' ], 'alert' => $alert ];
    }
    
    
    /**
     * Defines what info is sent back to the uset after an  
     * interaction (insert, update or delete) has been mad with the database.
     * 
     * @param str $build     | Build datas for froms.
     * @return array            | Return's infos to display :
     *                            'updated'       | boolean   If an interaction has been made
     *                            'updatemessage' | str       Message content
     *                            'updatedid'     | int       Id of the content inserted, updated or deleted
     */
    public function getQuestionFormUpdatedDatas( $build )
    {
        $updatemessage  = '';

        $alert          = 'success'; // 'success', 'info', 'warning', 'danger' 
        
        $updated        = false;
        
        if( isset( $build->errors ) )
        {
            $updatemessage = 'Certains champs ont été mal remplis.';
            $updated        = true;    
            $alert          = 'danger';
        }
        
        return [ 'updated' => $updated, 'updatemessage' => $updatemessage, 'updateid' => null, 'alert' => $alert ];
    }


    
    /**
     * Defines what info is sent back to the uset after an  
     * interaction (insert, update or delete) has been mad with the database.
     * 
     * @param str $urlDatas     | Last part of the Url (Router).
     * @return array            | Return's infos to display :
     *                            'updated'       | boolean   If an interaction has been made
     *                            'updatemessage' | str       Message content
     *                            'updatedid'     | int       Id of the content inserted, updated or deleted
     */
    public function getWorkshopUpdatedDatas( $urlDatas )
    {
        $updatemessage  = '';

        $alert          = 'success'; // 'success', 'info', 'warning', 'danger' 
        
        $msgDatas = $this->_updatedMsgDatas( $urlDatas, 'workshops/ModelWorkshops/workshops', 'IdWorkshop', 'IdCoach' );

        if( $msgDatas[ 'updated' ] )
        {
            $updatemessage .= ( $msgDatas[ 'action' ] === 'successinsert' ) ? 'La formation <strong><a href="#'.$msgDatas[ 'updatedid' ].'">'.$msgDatas[ 'updatedname' ] . '</a></strong> vient d\'être ajoutés.' : '';

            $updatemessage .= ( $msgDatas[ 'action' ] === 'successupdate' ) ? 'La formation <strong><a href="#'.$msgDatas[ 'updatedid' ].'">'.$msgDatas[ 'updatedname' ] . '</a></strong> vient d\'être mise à jour.' : '';

            $updatemessage .= ( $msgDatas[ 'action' ] === 'successdelete' ) ? 'Une formation vient d\'être supprimés.' : '';
            
        }
        
        return [ 'updated' => $msgDatas[ 'updated' ], 'updatemessage' => $updatemessage, 'updateid' => $msgDatas[ 'updatedid' ], 'alert' => $alert ];
    }
    
    
    public function getInviteMsgDatas( $urlDatas )
    {
        $datasUrl       = explode( '/', $urlDatas );
        
        $updated = false;
        
        $message = '';
        
        $id = 0;
        
        $alert          = 'success';
        
        if( ( count( $datasUrl ) >= 2 ) && ( $datasUrl[0] === 'success' || $datasUrl[0] === 'fail' ) && is_numeric( $datasUrl[1] ) )
        {
            $this->_setModels([ 'workshops/ModelWorkshops' ]);
            
            $ModelWorkshops = $this->_models[ 'ModelWorkshops' ];
            
            $users = $ModelWorkshops->workshopUsersInfo(['IdUserWorkshop' => $datasUrl[1]]);
            
            if( isset( $users ) )
            {
                $updated = true;

                $alert   = ( $datasUrl[0] === 'success' ) ? 'success' : 'danger';

                $id      =   $datasUrl[1];

                $message = ( $datasUrl[0] === 'success' ) ? 'Message envoyé à ' . $users[0]->FirstnameUser . ' ' . $users[0]->LastnameUser : 'Le message n\'a pas pu etre envoyé à ' . $users[0]->FirstnameUser . ' ' . $users[0]->LastnameUser;
            }
        }
        
        return [ 'updated' => $updated, 'updatemessage' => $message, 'updateid' => $id, 'alert' => $alert ];
    }
    /**
     * Defines what info is sent back to the uset after an  
     * interaction (insert, update or delete) has been mad with the database.
     * 
     * @param str $build     | Build datas for froms.
     * @return array            | Return's infos to display :
     *                            'updated'       | boolean   If an interaction has been made
     *                            'updatemessage' | str       Message content
     *                            'updatedid'     | int       Id of the content inserted, updated or deleted
     */
    public function getSubscribeFormUpdatedDatas( $build )
    {
        $updatemessage  = '';

        $alert          = 'success'; // 'success', 'info', 'warning', 'danger' 
        
        $updated        = false;
        
        if( isset( $build->errors ) )
        {
            $updatemessage  = 'Certains champs ont été mal remplis.';
            $updated        = true;    
            $alert          = 'danger';
        }
        
        return [ 'updated' => $updated, 'updatemessage' => $updatemessage, 'updateid' => null, 'alert' => $alert ];
    }

    /**
     * Defines what info is sent back to the uset after an  
     * interaction (insert, update or delete) has been mad with the database.
     * 
     * @param str $build     | Build datas for froms.
     * @return array            | Return's infos to display :
     *                            'updated'       | boolean   If an interaction has been made
     *                            'updatemessage' | str       Message content
     *                            'updatedid'     | int       Id of the content inserted, updated or deleted
     */
    public function getWorkshopFormUpdatedDatas( $build )
    {
        $updatemessage  = '';

        $alert          = 'success'; // 'success', 'info', 'warning', 'danger' 
        
        $updated        = false;
        
        if( isset( $build->errors ) )
        {
            $updatemessage  = 'Certains champs ont été mal remplis.';
            $updated        = true;    
            $alert          = 'danger';
        }
        
        return [ 'updated' => $updated, 'updatemessage' => $updatemessage, 'updateid' => null, 'alert' => $alert ];
    }

    
    
    /**
     * Defines what info is sent back to the uset after an  
     * interaction (insert, update or delete) has been mad with the database.
     * 
     * @param str $urlDatas     | Last part of the Url (Router).
     * @return array            | Return's infos to display :
     *                            'updated'       | boolean   If an interaction has been made
     *                            'updatemessage' | str       Message content
     *                            'updatedid'     | int       Id of the content inserted, updated or deleted
     */
    public function getCoachUpdatedDatas( $urlDatas )
    {
        $updatemessage  = '';

        $alert          = 'success'; // 'success', 'info', 'warning', 'danger' 
        
        $msgDatas = $this->_updatedMsgDatas( $urlDatas, 'workshops/ModelCoachs/coachs', 'IdCoach', 'FirstnameCoach', 'LastnameCoach' );

        if( $msgDatas[ 'updated' ] )
        {
            $updatemessage .= ( $msgDatas[ 'action' ] === 'successinsert' ) ? 'Le formateur <strong><a href="#'.$msgDatas[ 'updatedid' ].'">'.$msgDatas[ 'updatedname' ] . '</a></strong> vient d\'être ajouté.' : '';

            $updatemessage .= ( $msgDatas[ 'action' ] === 'successupdate' ) ? 'Le formateur <strong><a href="#'.$msgDatas[ 'updatedid' ].'">'.$msgDatas[ 'updatedname' ] . '</a></strong> vient d\'être mis à jour.' : '';

            $updatemessage .= ( $msgDatas[ 'action' ] === 'successdelete' ) ? 'Un formateur vient d\'être supprimé.' : '';
            
        }
        
        return [ 'updated' => $msgDatas[ 'updated' ], 'updatemessage' => $updatemessage, 'updateid' => $msgDatas[ 'updatedid' ], 'alert' => $alert ];
    }
    

    /**
     * Defines what info is sent back to the uset after an  
     * interaction (insert, update or delete) has been mad with the database.
     * 
     * @param str $build     | Build datas for froms.
     * @return array            | Return's infos to display :
     *                            'updated'       | boolean   If an interaction has been made
     *                            'updatemessage' | str       Message content
     *                            'updatedid'     | int       Id of the content inserted, updated or deleted
     */
    public function getCoachFormUpdatedDatas( $build )
    {
        $updatemessage  = '';

        $alert          = 'success'; // 'success', 'info', 'warning', 'danger' 
        
        $updated        = false;
        
        if( isset( $build->errors ) )
        {
            $updatemessage = 'Certains champs ont été mal remplis.';
            $updated        = true;    
            $alert          = 'danger';
        }
        
        return [ 'updated' => $updated, 'updatemessage' => $updatemessage, 'updateid' => null, 'alert' => $alert ];
    }


}