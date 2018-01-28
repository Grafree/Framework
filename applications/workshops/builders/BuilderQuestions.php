<?php
return [
    
    /**
     * Fields format used by the Orm
     */
    'workshop_questions' => [
        'IDQuestion'            =>[ 'type' => 'INT', 'autoincrement' => true, 'primary' => true, 'dependencies' => ['workshop_answers'=>'IdQuestion'] ],
        'Question'              =>[ 'type' => 'STR', 'mandatory' => true ],
        'TypeQuestion'          =>[ 'type' => 'INT' ],
        'IdWorkshop'            =>[ 'type' => 'INT' ],
        'IsActiveQuestion'      =>[ 'type' => 'INT', 'default' => 1 ]
    ],
    'workshop_answers' => [
        'IdAnswer'      =>[ 'type' => 'INT', 'autoincrement' => true, 'primary' => true ],
        'IdQuestion'    =>[ 'type' => 'INT', 'mandatory' => true],
        'ValueAnswer'   =>[ 'type' => 'INT' ],
        'IdWorkshopUser'=>[ 'type' => 'INT', 'mandatory' => true ],
    ],
    
    /**
     * Jointer between tables by the foreign keys. Used by the Orm
     */
    'relations' => [
        'workshop_questions' => [
            'workshops'  =>['workshop_questions'=>'IdWorkshop', 'workshops'=>'IdWorkshop']
        ],
        'workshop_answers' => [
            'workshop_questions'  =>['workshop_answers'=>'IdQuestion', 'workshop_questions'=>'IDQuestion']
        ],
    ]
];