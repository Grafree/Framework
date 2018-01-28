<?php
namespace applications\workshops;

use includes\components\CommonModel;

use includes\tools\Orm;
use includes\tools\Mail;
use includes\Login;


use stdClass;

class ModelWorkshops extends CommonModel {
    
    private     $_statuts;


    public function __construct() 
    {
        $this->_setTables(['workshops/builders/BuilderWorkshops']);
                
        $this->_statuts = [
            'inscrit'   =>[ 'nb' => 0, 'name' => 'Inscrit', 'state' => 'info' ],
        ];
    }
    

    
    private function _getStatut( $sKey )
    {
        return ( isset( $this->_statuts[ $sKey ] ) ) ? $this->_statuts[ $sKey ] : null; 
    }

    
    public function getWorkshopLength( $nbPeriod, $format = 'text' )
    {
        if( ( $l = $nbPeriod / 6 ) !== 0 )
        {
            $length = $l;
            if( $format === 'text' )
            {
                $length .= ' jour' . ( ( $l > 1 ) ? 's' : '' );
            }
        }
        else
        {
            $length = '';
        }
        
        return $length;
    }
    
    
    
    public function domainsWorkshops()
    {   
        $this->_setModels(['workshops/ModelDomains']);
                
        $modelDomains = $this->_models['ModelDomains'];
                
        $domains = new stdClass;
                
        $domains->all = $modelDomains->domains();
                
        $nb = 0;
        
        if( isset( $domains->all ) )
        {
            foreach( $domains->all as $domain )
            {
                //$this->_params['workshops']['orm']['workshops.IdSector'] = $domain->IDDomaine;

                $domain->workshops = $this->workshops([ 'IdSector'=>$domain->IDDomaine ]);

                $nbAtelier = count( $domain->workshops );

                $nb += $nbAtelier;
                
                $domain->nbAteliers = $nbAtelier;
            }
        }
                
        $domains->nbAteliers = $nb;
        
        return $domains;    
    }
      

    /**
     * Selects Workshops Datas with all connected 
     * infos : Coachs and dates planned (previous and to come)
     * 
     * All parameters are set in the $this->_params attribute. Wich are : 
     * $this->_params['workshops']['orm']       For SQL request conditions
     * $this->_params['workshops']['period']    For the period of workshop to select ('archive' or 'actual')
     * 
     * @return array            | All Datas
     */
    public function workshops( $params ) 
    {   
        $this->_setModels([ 'workshops/ModelQuestions' ]);
        
        $modelQuestions = $this->_models[ 'ModelQuestions' ];

        $orm = new Orm( 'workshops', $this->_dbTables['workshops'] );
        
        $workshops = $this  ->_baseWorkshopsQuery( $orm, $params )
                            ->_exeWorkshopsQuery( $orm );

        
        if( isset( $workshops ) )
        {
            foreach( $workshops as $workshop )
            {                
                $workshop->users = $this->workshopUsersInfo([ 'workshop_user.IdWorkshop' => $workshop->IdWorkshop ]);
                
                if( isset( $workshop->users ) )
                {
                    foreach( $workshop->users as $user )
                    {
                        $user->loginUrl = Login::tokenizerLoginUrl( 'workshops', $user->EmailUser, $user->IdUserWorkshop );
                        /*
                        $user->infos = new stdClass;
                        
                        $user->infos->questionsGen = $modelQuestions->questions( [ 'IdWorkshop' => 0 ], true );
                    
                        $this->infos->questionsSpec = $modelQuestions->questions( [ 'IdWorkshop' => $user->IdWorkshop ], true );
                        */
                    }
                }
                
            } 
        }
        
        return $workshops;
    }   
    private function _baseWorkshopsQuery( $orm, $params )
    {
        $orm    ->select()
                ->join([ 'workshops'=>'IdCoach', 'coachs'=>'IdCoach' ])
                ->where( $params );
        
        return $this;
    }
    
    private function _exeWorkshopsQuery( $orm )
    {
        $res = $orm ->order([ 'TitleWorkshop' => 'ASC' ])
                    ->execute( true );
        
        return $res;
    }


    
    
    
    public function getWorkshops( $params = [] )
    {
        $dataList = [];

        $datas = $this->workshops( $params );
                
        if( is_array( $datas ) )
        {
            foreach( $datas as $data )
            {   
                $dataList[] = ['value' => $data->IdWorkshop, 'label'=> $data->TitleWorkshop ];
            }
        }
        
        return $dataList;    
    }
    
    
    /**
     * Prepare datas for the formulas 
     * depending on the table "coaching".
     * Manage sending. Returns settings datas and errors
     * 
     * @param int $id       | (optional) Id of the content. 
     * @return object       | Datas and errors.
     */   
    public function workshopBuild( $id = null )
    {
        $orm = new Orm( 'workshops', $this->_dbTables['workshops'] );
            
        $orm->prepareGlobalDatas( [ 'POST' => true ] );
        
        $params = ( isset( $id ) ) ? ['IdWorkshop' => $id] : null;
                
        return $orm->build( $params );
    }
    
    
    public function workshopUpdate( $action = 'insert', $id = null) 
    {
        $orm        = new Orm( 'workshops', $this->_dbTables['workshops'] );
        
        $orm->prepareGlobalDatas( [ 'POST' => true ] );
        
        if( !$orm->issetErrors() )
        {
            if( $action === 'insert' )
            {
                $data = $orm->insert();
            }
            else if( $action === 'update' )
            {
                $data = $orm->update([ 'IdWorkshop' => $id ]);
            }
            
            return $data;
        }
        else
        {
            return false;
        }
    }
    
  
    
    
    public function workshopUser( $params )
    {
        $orm = new Orm( 'workshop_user', $this->_dbTables['workshop_user'] );
        
        $results = $orm ->select()
                        ->where( $params )
                        ->execute();
        
        return $results;        
    }
    
    
    public function workshopUserIds()
    {
        $orm = new Orm( 'workshop_user' );
        
        $results = $orm ->select()
                        ->execute();
        
        $ids = [];
        
        if( isset( $results ) )
        {
            foreach ( $results as $result )
            {
                $ids[] = $result->IdUserWorkshop;
            }
        }
        
        return $ids;
    }
    
    public function workshopUsersInfo( $params )
    {
        $orm = new Orm( 'workshop_user', $this->_dbTables['workshop_user'], $this->_dbTables['relations'] );
        
        $results = $orm ->select()
                        ->joins(['workshop_user'=>['workshops', 'users']])
                        ->where( $params )
                        ->execute();
              
        return $results;        
    }
    
    public function workshopUserInfo( $params )
    {
        $orm = new Orm( 'workshop_user', $this->_dbTables['workshop_user'], $this->_dbTables['relations'] );
        
        $results = $orm ->select()
                        ->joins(['workshop_user'=>['workshops', 'users']])
                        ->where( $params )
                        ->first();
              
        return $results;        
    }
    
    /**
     * Prepare datas for the formulas 
     * depending on the table "workshop_user".
     * Manage sending. Returns settings datas and errors
     * 
     * @param int $id       | (optional) Id of the content. 
     * @return object       | Datas and errors.
     */   
    public function workshopSubscribeBuild( $datas = [ 'IdWorkshop' => null ])
    {
        $orm = new Orm( 'workshop_user', $this->_dbTables['workshop_user'] );
            
        $orm->prepareGlobalDatas( [ 'POST' => true ] );
        
        $params = ( isset( $datas['IdWorkshop'] ) ) ? ['IdWorkshop' => $datas['IdWorkshop']] : null;
                
        //return $this->_workshopSubscribeInfosBuild( $orm->builds( $params ) );
        return $orm->builds( $params );
    }
    
    
    public function workshopUserUpdate( $params )
    {
        $orm = new Orm( 'workshop_user', $this->_dbTables['workshop_user'] );
        
        $datas= $orm->prepareGlobalDatas( [ 'POST' => true ] );
        
        $this->workshopUserDelete([ 'IdWorkshop' => $params[ 'IdWorkshop' ] ]);
        
        if( isset( $datas[ 'IdUser' ] ) && count( $datas[ 'IdUser' ] ) > 0 )
        {
            $orm->prepareDatas([ 'IdWorkshop' => $params[ 'IdWorkshop' ] ]);
            
            $orm->insert();
        }
        
        return true;        
    }
    
    
    public function workshopUserEvalDone( $IdUserWorkshop )
    {
        $orm = new Orm( 'workshop_user', $this->_dbTables['workshop_user'] );
        
        $workshopuser = $this->workshopUser([ 'IdUserWorkshop' => $IdUserWorkshop ]);
        
        //$orm->prepareDatas([ 'IdWorkshop' => $workshopuser->IdWorkshop, 'IdUser' => $workshopuser->IdUser, 'DateUserWorkshop' => $workshopuser->DateUserWorkshop, 'IsEvalUserWorkshop' => 1 ]);
        $orm->prepareDatas([ 'IsEvalUserWorkshop' => 1 ]);
            
        $orm->update([ 'IdUserWorkshop' => $IdUserWorkshop ]);
        
    }
    
    
    
    public function workshopUserDelete( $params )
    {
        $orm = new Orm( 'workshop_user', $this->_dbTables['workshop_user'] );
        
        $orm->delete([ 'IdWorkshop' => $params['IdWorkshop']]);
        
        return true;
    }
    
    
    public function workshopSendInvite( $params )
    {
        $user = $this->workshopUserInfo( $params );
        
        if( isset( $user ) )
        {
            $data = $this->getMessageEval( $user );
            
            $mail = new Mail();
            
            $mail->setHtmlMail( $data->MessageHtml );
            
            $mail->setTextMail( $data->MessageTxt );
            
            return $mail->sendSiteMail( $user->EmailUser, 'Evaluation de la formation ' . $user->TitleWorkshop, '', 'PROCOM', 'info@procom.ch' );
        }
        
        return false;
    }
    
    
    
    public function getMessageEval( $user )
    {
        if( isset( $user ) && isset( $user ) )
        {
            $salutation = 'Bonjour ' . $user->FirstnameUser . ',';
            
            $message    = 'Vous avez suivi la formation ' . $user->TitleWorkshop . '. Nous aimerions avoir votre avis sur cette formation. Toute information nous seront utiles pour améliorer la qualité de cette formation. Nous vous sommes très reconnaissant de prendre quelques minutes pour répondre à ces questions.';
            
            $duree      = 'Répondre au questionnaire vous prendra que quelques minutes.';
            
            $lien       = 'Evaluez la formation.';
            
            $lienUrl    = SITE_URL . '/login/eval/' . Login::tokenizerLoginUrl( 'workshops', $user->EmailUser, $user->IdUserWorkshop );
            
            $merci      = 'Nous vous remercions du temps que vous nous consacrez.';
            
            $salutations= 'Meilleures salutations.';
            
            $data = new stdClass;
            
            $data->MessageTxt = $salutation . "\r\n\r\n" . $message . "\r\n\r\n" . $duree . "\r\n\r\n" . $lienUrl . ' : ' . $lien . "\r\n\r\n" . $merci . "\r\n\r\n" . $salutations;
            
            $data->MessageHtml = $salutation . '<br><br><p>' . $message . '</p><p>' . $duree . '</p><p><a href="' . $lienUrl . '">' . $lien . '</a></p><p>' . $merci . '</p><p>' . $salutations . '</p>';
            
            return $data;
        }
        
        return false;
    }
 
}