<?php
namespace applications\workshops;

use includes\components\CommonModel;

use stdClass;

use includes\tools\Orm;
use includes\Request;

class ModelQuestions extends CommonModel {
    
    
    public function __construct() 
    {
        $this->_setTables(['workshops/builders/BuilderQuestions']);
    }

    
    public function beneficiaireWorkshopEval( $params = [] )
    {
        $orm = new Orm( 'workshop_answers', $this->_dbTables['workshop_answers'], $this->_dbTables['relations'] );
        
        $results = $orm ->select()
                        ->joins([ 'workshop_answers'=>['workshop_questions'] ])
                        ->where( $params )
                        ->execute();

        return $results;
    }  
    
    
     
    /**
     * Select datas form the table "workshop_questions"
     * 
     * @param array $params | (optional)
     *                        Selection conditions depending on the field's name and it's value
     *                        Example : [ 'IDQuestion'=>1 ]
     * @return object       | Results of the selection in the database.
     */
    public function questions( $params = [], $isToDisplay = false ) {
    
        $orm = new Orm( 'workshop_questions', $this->_dbTables['workshop_questions'] );
        
        $results= $orm  ->select()
                        ->where( $params )
                        ->order([ 'IDQuestion' => 'ASC' ])
                        ->execute( true );
                
        if( $isToDisplay && isset( $results ) )
        {
            foreach( $results as $result )
            {
                $result->formFields = $this->_questionsFormFieldInfos( $result );
            }
        }
        
        return $results;
    } 
    
    private function _questionsFormFieldInfos( $question )
    {
        $fields = [
            ['type'=>'no-input', 'values'=>['field_'.$question->IDQuestion => $question->Question], 'name'=>'field_'.$question->IDQuestion],
            ['type'=>'input-text', 'values'=>['field_'.$question->IDQuestion => ''], 'name'=>'field_'.$question->IDQuestion],
            ['type'=>'textarea', 'values'=>['field_'.$question->IDQuestion => ''], 'name'=>'field_'.$question->IDQuestion],
            ['type'=>'evaluation', 'values'=>['field_'.$question->IDQuestion => ''], 'name'=>'field_'.$question->IDQuestion],
            ['type'=>'input-checkbox', 'values'=>['field_'.$question->IDQuestion => ''], 'name'=>'field_'.$question->IDQuestion],
        ];
        
        $type = ( empty( $question->TypeQuestion ) ? 0 : $question->TypeQuestion );
        
        return $fields[ $type ];
    }
    
         
    /**
     * Prepare datas for the formulas 
     * depending on the table "workshop_questions".
     * Manage sending. Returns settings datas and errors
     * 
     * @param int $id       | (optional) Id of the content. 
     * @return object       | Datas and errors.
     */   
    public function questionsBuild( $id = null )
    {
        $orm = new Orm( 'workshop_questions', $this->_dbTables['workshop_questions'] );
            
        $orm->prepareGlobalDatas( [ 'POST' => true ] );
        
        $params = ( isset( $id ) ) ? ['IDQuestion' => $id] : null;
            
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
    public function questionUpdate( $action = 'insert', $id = null) 
    {
        $orm  = new Orm( 'workshop_questions', $this->_dbTables['workshop_questions'] );
        
        $datas = $orm->prepareGlobalDatas( [ 'POST' => true ] );
        
        if( !$orm->issetErrors() )
        {
            if( $action === 'insert' )
            {
                $data = $orm->insert();
            }
            else if( $action === 'update' )
            {
                $data = $orm->update([ 'IDQuestion' => $id ]);
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
    public function questionDelete( $id ) 
    {
        $orm = new Orm( 'workshop_questions', $this->_dbTables['workshop_questions'] );
            
        $orm->delete([ 'IDQuestion' => $id ]);
        
        return true;
    } 
    
    
    public function workshop_questionsActiveUpdate( $id = null )
    {
        return $this->_updateActive( $id, 'questions', 'workshop_questions', 'workshop_questions', 'IDQuestion', 'Question', 'IsActiveQuestion');
       
    }
    
    
    
    
    public function answers($params)
    {
        $orm = new Orm( 'workshop_answers', $this->_dbTables['workshop_answers'] );
        
        $results = $orm ->select()
                        ->where( $params )
                        ->execute();
        
        return $results;
            
    }
    
    
    public function processAnswers( $IdUserWorkshop )
    {
        $req = Request::getInstance();
        
        $this->_setModels([ 'workshops/ModelWorkshops' ]);
            
        $modelWorkshops = $this->_models[ 'ModelWorkshops' ];
        
        $workshopUser = $modelWorkshops->workshopUserInfo([ 'IdUserWorkshop' => $IdUserWorkshop ]);
        
        $questsG = $this->questions( [ 'IdWorkshop' => 0 ], true );
        
        $questsS = $this->questions( [ 'IdWorkshop' => $workshopUser->IdWorkshop ], true );
           
        if( isset( $questsG ) )
        {
            foreach( $questsG as $question )
            {
                if( !empty( $question->TypeQuestion ) )
                {
                    $orm = new Orm( 'workshop_answers', $this->_dbTables['workshop_answers'] );

                    $orm->prepareDatas([ 'ValueAnswer' => $req->getVar( $question->formFields['name'] ), 'IdQuestion' => $question->IDQuestion, 'IdWorkshopUser' => $IdUserWorkshop ]);

                    $orm->insert();
                }
            }
        }
        
        if( isset( $questsS ) )
        {
            foreach( $questsS as $question )
            {
                if( !empty( $question->TypeQuestion ) )
                {
                    $orm = new Orm( 'workshop_answers', $this->_dbTables['workshop_answers'] );

                    $orm->prepareDatas([ 'ValueAnswer' => $req->getVar( $question->formFields['name'] ), 'IdQuestion' => $question->IDQuestion, 'IdWorkshopUser' => $IdUserWorkshop ]);

                    $orm->insert();
                }
            } 
        }
        
        return true;
        
    }
    
    
    public function getAnswers( $IdUserWorkshop )
    {
        
        $this->_setModels([ 'workshops/ModelWorkshops' ]);
            
        $modelWorkshops = $this->_models[ 'ModelWorkshops' ];
        
        $workshopUser = $modelWorkshops->workshopUserInfo([ 'IdUserWorkshop' => $IdUserWorkshop ]);
        
        $questsG = $this->questions( [ 'IdWorkshop' => 0 ], true );
        
        $questsS = $this->questions( [ 'IdWorkshop' => $workshopUser->IdWorkshop ], true );
        
        $answers = new stdClass;
        
        $answers->generals  = $this->answersTreat( $questsG, $IdUserWorkshop  );
        
        $answers->specifics = $this->answersTreat( $questsS, $IdUserWorkshop  );
        
        return $answers;   
    }
    
    
    public function answersTreat( $questions, $IdUserWorkshop )
    {
        $questionsAnswers = [];
        
        if( isset( $questions ) )
        {
            foreach( $questions as $question )
            {
                $datas = new stdClass;
                
                $datas->question = $question;
                
                if( !empty( $question->TypeQuestion ) )
                {
                    $answersDatas = $this->answers(['IdQuestion' => $question->IDQuestion, 'IdWorkshopUser' => $IdUserWorkshop ]);
                    
                    if( isset( $answersDatas ) )
                    {
                        $datas->answer = $this->answersProcess($question->TypeQuestion, $answersDatas[0]->ValueAnswer);
                    }
                    else
                    {
                        $datas->answer = 'empty';
                    }
                }  
                $questionsAnswers[] = $datas;
            }
        }
        
        return ( count( $questionsAnswers ) > 0 ) ? $questionsAnswers : null;
    }
    
    
    
    public function answersProcess( $type, $answer )
    {
        
        switch ( $type )
        {
            case '3' : // Evaluation 1 à 5
                
                return ( $answer + 1 ) . '/5';
                
            break;
        
            case '4' : // Oui | Non
                
                return $answer;
                
            break;
        
        
            default :
                
                return $answer;
                
            break;
        }
        
    }
    
}