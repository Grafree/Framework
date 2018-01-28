<?php
namespace applications\workshops;

use includes\components\CommonController;
use includes\Request;
use includes\Login;

use stdClass;

class Controller extends CommonController{

    
    private function _setSubscribeForm()
    {
        $this->_setModels( 'workshops/ModelWorkshops' );
        
        $modelWorkshops = $this->_models[ 'ModelWorkshops' ];
        
        $datas = ( !empty( $this->_router ) ) ? explode( '/', $this->_router ) : [ null ];
        
        $this->_datas               = new stdClass;
        
        $workshops                  = $modelWorkshops->workshops( ['IdWorkshop' => $datas[0] ]);
        
        $IdWorkshop = ( isset( $workshops[0] ) ) ? $workshops[0]->IdWorkshop : null;
        
        $this->_datas->tabs         = $this->_interface->getTabs( 'workshops' ); 
        
        $this->_datas->workshop     = $workshops[0];
       
        $this->_datas->form         = $modelWorkshops->workshopSubscribeBuild([ 'IdWorkshop' => $IdWorkshop ]);
                
        $this->_datas->users        = $this->_interface->getUsersSubscribe([ 'IdWorkshop' => $IdWorkshop ]);
        
        $this->_view = 'workshops/workshop-subscribe';
        
    }
    
    private function _setcoachForm()
    {   
        $id = ( !empty( $this->_router ) ) ? $this->_router : null;
        
        $this->_setModels( 'workshops/ModelWorkshops' );
        $this->_setModels( 'workshops/ModelCoachs' );
        
        $modelWorkshops = $this->_models[ 'ModelWorkshops' ];
        $modelCoachs    = $this->_models[ 'ModelCoachs' ];

        $this->_datas = new stdClass;
        $this->_datas->tabs     = $this->_interface->getTabs( 'coachs' );
        $this->_datas->form     = $modelCoachs->coachBuild( $id );
        $this->_datas->response = $this->_interface->getCoachFormUpdatedDatas( $this->_datas->form );

        $this->_view = 'workshops/coach-form';
    }
    
    private function _setquestionForm()
    {   
        $id = ( !empty( $this->_router ) ) ? $this->_router : null;
        
        $this->_setModels( ['workshops/ModelQuestions', 'workshops/ModelWorkshops'] );
        
        $modelQuestions    = $this->_models[ 'ModelQuestions' ];
        $modelWorkshops    = $this->_models[ 'ModelWorkshops' ];

        $this->_datas = new stdClass;
        $this->_datas->tabs     = $this->_interface->getTabs( 'questions' );
        $this->_datas->form     = $modelQuestions->questionsBuild( $id );
        $this->_datas->typeQuestions = $this->_interface->getTypeQuestions();
        $this->_datas->workshops= $modelWorkshops->getWorkshops();
        $this->_datas->response = $this->_interface->getQuestionFormUpdatedDatas( $this->_datas->form );

        $this->_view = 'workshops/question-form';
    }
    
    private function _setdomaineForm()
    {   
        $id = ( !empty( $this->_router ) ) ? $this->_router : null;
        
        $this->_setModels( 'workshops/ModelDomains' );
        
        $modelDomaines    = $this->_models[ 'ModelDomains' ];

        $this->_datas = new stdClass;
        $this->_datas->tabs     = $this->_interface->getTabs( 'domains' );
        $this->_datas->form     = $modelDomaines->domainesBuild( $id );
        $this->_datas->response = $this->_interface->getDomaineFormUpdatedDatas( $this->_datas->form );

        $this->_view = 'workshops/domain-form';
    }
    
    private function _setworkshopForm()
    {
        $this->_setModels( ['workshops/ModelWorkshops', 'workshops/ModelDomains', 'workshops/ModelCoachs'] );
        
        $modelWorkshops = $this->_models[ 'ModelWorkshops' ];
        $modelCoachs    = $this->_models[ 'ModelCoachs' ];
        $modelDomaines    = $this->_models[ 'ModelDomains' ];
        
        $id = ( !empty( $this->_router ) ) ? $this->_router : null;

        $this->_datas = new stdClass;
        $this->_datas->tabs     = $this->_interface->getTabs( 'workshops' );
        $this->_datas->form     = $modelWorkshops->workshopBuild( $id );
        $this->_datas->coachs   = $modelCoachs->getCoachs();
        $this->_datas->domains  = $modelDomaines->getDomains();
        $this->_datas->response = $this->_interface->getWorkshopFormUpdatedDatas( $this->_datas->form );

        $this->_view = 'workshops/workshop-form';
    }
    
    
    protected function _setDatasView()
    {      
        $this->_setModels([ 'workshops/ModelWorkshops', 'workshops/ModelCoachs', 'workshops/ModelQuestions', 'workshops/ModelDomains', 'workshops/ModelStatistics', 'users/ModelUsers' ]);
        
        $modelWorkshops = $this->_models[ 'ModelWorkshops' ];
        $modelCoachs    = $this->_models[ 'ModelCoachs' ];
        $modelQuestions = $this->_models[ 'ModelQuestions' ];
        $modelDomains   = $this->_models[ 'ModelDomains' ];
        $modelUser      = $this->_models[ 'ModelUsers' ];
        $modelStatistics = $this->_models[ 'ModelStatistics' ];
        
        
        switch( $this->_action )
        {
            case 'workshopform':
                
                $this->_setworkshopForm();
               
            break;           
        
            case 'workshopupdate':
                
                $id     = ( !empty( $this->_router ) ) ? $this->_router : null;
                $action = ( !empty( $this->_router ) ) ? 'update' : 'insert';
                
                if( $data = $modelWorkshops->workshopUpdate( $action, $id ) )
                {
                    header( 'location:' . SITE_URL . '/workshops/workshops/success' . $action . '/' . $data->IDCoaching );
                    
                    exit;
                }
                else 
                {
                    $this->_setworkshopForm();
                }
            break;
            /*
            case 'print':
                
                $this->_datas = new stdClass;
            
                $urlInfos = explode( '/', $this->_router );

                $this->_datas->urlBack     = SITE_URL . '/workshops/' . $urlInfos[0] . '/' . $urlInfos[1] . '/' . $urlInfos[2];
                
                $this->_datas->workshop    = $modelWorkshops->workshopSubscribeBuild([ 'date'=>$urlInfos[1], 'id'=>$urlInfos[2] ]); 
                
                $this->_datas->users       = $this->_interface->getUsersSubscribe( $this->_datas->workshop );
                                
                $this->_view  = 'workshops/workshop-print-sheet';
                
            break;
            
            */    
                        
            case 'coachs' :
                
                $period = $this->_interface->checkCoachPeriod( $this->_router ); // By Default choose current (actual)

                $this->_datas = new stdClass;
                
                $this->_datas->tabs         = $this->_interface->getTabs( 'coachs' );
                                
                $this->_datas->dropdownlist = $this->_interface->getDropdownList( $period, '_listcoach' );
                
                $this->_datas->datas        = $modelCoachs->coachsDatas();
                
                $this->_datas->response     = $this->_interface->getCoachUpdatedDatas( $this->_router );
                
                $this->_view = 'workshops/coachs-list';
                
            break;     
        
            case 'coachform':
                
                $this->_setcoachForm();
                
            break;
        
            case 'coachupdate':
                
                $id     = ( !empty( $this->_router ) ) ? $this->_router : null;
                $action = ( !empty( $this->_router ) ) ? 'update' : 'insert';
                
                if( $data = $modelCoachs->coachUpdate( $action, $id ) )
                {
                    header( 'location:' . SITE_URL . '/workshops/coachs/success' . $action . '/' . $data->IdCoach );
                    
                    exit;
                }
                else 
                {
                    $this->_setcoachForm();
                }
            break;
                        
            case 'coachdeleteAjax':
                
                $datas = new stdClass;

                if( $this->_datas = $modelCoachs->coachDelete( $this->_request->getVar( 'id' ) ) )
                {
                    echo json_encode([ 'token' => $_SESSION[ 'token' ], 'status' => 'OK', 'data' => $datas, 'msg' => 'Un formateur vient d\'être supprimé.' ]); 
                }
                else
                {
                    echo json_encode([ 'token' => $_SESSION[ 'token' ], 'status' => 'FAIL', 'data' => $datas, 'msg' => '' ]);   
                }
                
                exit;
                
            break;            
        
            
            case 'private' :
                
                if( isset( $this->_router ) )
                {
                    if( $this->_router === 'sent' )
                    {
                        $req = Request::getInstance();
                        
                        if( ( $IdUserWorkshop = $req->getVar( 'IdUserWorkshop' ) ) !== null )
                        {
                            if( $modelQuestions->processAnswers( $IdUserWorkshop ) )
                            {
                                $modelWorkshops->workshopUserEvalDone( $IdUserWorkshop );
                                
                                header( 'location:' . SITE_URL . '/workshops/private/' .$IdUserWorkshop );
                                
                                exit;
                            }
                        }
                    }
                    
                    $datas = $modelWorkshops->workshopUserIds(); // get all IdUserWorkshop
                    
                    if( $IdUserWorkshop = ( $IdUserWorkshop = Login::foundModuleDatas( $this->_router, $datas ) ) ? $IdUserWorkshop : $this->_router ) 
                    {
                        $this->_datas = new stdClass;

                        $this->_datas->datas        = $modelWorkshops->workshopUserInfo([ 'IdUserWorkshop' => $IdUserWorkshop ]);

                        $this->_datas->questionsGen  = $modelQuestions->questions( [ 'IdWorkshop' => 0 ], true );
                        
                        $this->_datas->questionsSpec = $modelQuestions->questions( [ 'IdWorkshop' => $this->_datas->datas->IdWorkshop ], true );

                        $this->_view = 'workshops/user-evaluation';
                    }
                    else
                    {       
                        header( 'location:' . SITE_URL );

                        exit;
                    }
                }
                
            break;
            
            
            case 'evalsendinvite' :
                
                if( isset( $this->_router ) )
                {
                    if( $modelWorkshops->workshopSendInvite([ 'IdUserWorkshop' => $this->_router ]) )
                    {                    
                        header( 'location:' . SITE_URL . '/workshops/invite/success/' . $this->_router );

                        exit;
                    }
                    else
                    {       
                        header( 'location:' . SITE_URL . '/workshops/invite/fail/' . $this->_router );

                        exit;
                    }
                }
                
            break;
            
            
            case 'evalresults' :
                
                if( isset( $this->_router ) )
                {
                    $this->_datas = new stdClass;
                       
                    $this->_datas->datas        = $modelWorkshops->workshopUserInfo([ 'IdUserWorkshop' => $this->_router ]);

                    $this->_datas->answers       = $modelQuestions->getAnswers( $this->_router );
                    
                    $this->_view = 'workshops/user-evaluation-results';
                }
                
            break;
                    
        
            case 'questions' :
                
                $this->_datas = new stdClass;
                
                $this->_datas->tabs         = $this->_interface->getTabs( 'questions' );
                
                $this->_datas->datas        = $modelQuestions->questions();
                
                $this->_datas->response     = $this->_interface->getQuestionUpdatedDatas( $this->_router );
                
                $this->_view = 'workshops/questions-list';
                
            break;    
        
            case 'questionform':
                
                $this->_setquestionForm();
                
            break;    
            
            case 'questionupdate':
                
                $id     = ( !empty( $this->_router ) ) ? $this->_router : null;
                $action = ( !empty( $this->_router ) ) ? 'update' : 'insert';
                
                if( $data = $modelQuestions->questionUpdate( $action, $id ) )
                {
                    header( 'location:' . SITE_URL . '/workshops/questions/success' . $action . '/' . $data->IDQuestion );
                    
                    exit;
                }
                else 
                {
                    $this->_setquestionForm();
                }
            break;
            
                  
            case 'domains' :
                
                $this->_datas = new stdClass;
                
                $this->_datas->tabs         = $this->_interface->getTabs( 'domains' );
                
                $this->_datas->datas        = $modelDomains->domains();
                
                $this->_datas->response     = $this->_interface->getDomaineUpdatedDatas( $this->_router );
                
                $this->_view = 'workshops/domains-list';
                
            break;     
        
            case 'domaineform':
                
                $this->_setdomaineForm();
                
            break;  
        
            case 'domaineupdate':
                
                $id     = ( !empty( $this->_router ) ) ? $this->_router : null;
                $action = ( !empty( $this->_router ) ) ? 'update' : 'insert';
                
                if( $data = $modelDomains->domaineUpdate( $action, $id ) )
                {
                    header( 'location:' . SITE_URL . '/workshops/domains/success' . $action . '/' . $data->IDDomaine );
                    
                    exit;
                }
                else 
                {
                    $this->_setdomaineForm();
                }
            break;
                        
            case 'domainedeleteAjax':
                
                $datas = new stdClass;

                if( $this->_datas = $modelCoachs->domaineDelete( $this->_request->getVar( 'id' ) ) )
                {
                    echo json_encode([ 'token' => $_SESSION[ 'token' ], 'status' => 'OK', 'data' => $datas, 'msg' => 'Un domaine vient d\'être supprimé.' ]); 
                }
                else
                {
                    echo json_encode([ 'token' => $_SESSION[ 'token' ], 'status' => 'FAIL', 'data' => $datas, 'msg' => '' ]);   
                }
                
                exit;
                
            break;            
                    
        
        
            case 'subscribe':
                
                $this->_setSubscribeForm();
                                
            break;     
        
        
            case 'subscribeupdate':
                
                $id     = ( !empty( $this->_router ) ) ? $this->_router : null;
                
                if( $modelWorkshops->workshopUserUpdate([ 'IdWorkshop' => $id ]) )
                {
                    header( 'location:' . SITE_URL . '/workshops/successupdate/subscribe/' . $id );
                    
                    exit;
                }
                else 
                {
                    $this->_setdomaineForm();
                }
                
            break;
        
        
            
            default :
                
                $period = $this->_interface->checkPeriod( $this->_router ); // By Default choose current (actual)
                
                $this->_datas = new stdClass;
                
                $this->_datas->tabs         = $this->_interface->getTabs( 'workshops' );
                
                $this->_datas->dropdownlist = $this->_interface->getDropdownList( $period );
                
                //$this->_datas->displayinfos = $this->_interface->getDisplayinfos( $period );
                
                $this->_datas->datas        = $modelWorkshops->domainsWorkshops( $period );

                $this->_datas->response     = ( $this->_action === 'invite' ) ? $this->_interface->getInviteMsgDatas( $this->_router ) : $this->_interface->getWorkshopUpdatedDatas( $this->_router );
                
                $this->_view = 'workshops/workshops-list';
                
            break;
            
        } 
    }
}