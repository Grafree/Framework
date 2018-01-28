<?php
return [
    
    /**
     * Fields format used by the Orm
     */
    'workshops' => [
        'IdWorkshop'            =>[ 'type' => 'INT', 'autoincrement' => true, 'primary' => true, 'dependencies' => ['workshop_user'=>'IdWorkshop'] ],
        'IdSector'             =>[ 'type' => 'INT' ],
        'IdCoach'             =>[ 'type' => 'STR' ],
        'TitleWorkshop'         =>[ 'type' => 'STR' ],
        'PlaceWorkshop'         =>[ 'type' => 'STR' ],
        'NbPeriodsWorkshop'     =>[ 'type' => 'INT', 'default' => '0' ],
        'DateStartWorkshop'     =>[ 'type' => 'DATE', 'dateformat' => 'DD.MM.YYYY', 'default' => 'NOW' ],
        'DateEndWorkshop'       =>[ 'type' => 'DATE', 'dateformat' => 'DD.MM.YYYY', 'default' => 'NOW' ],
        'DescriptionWorkshop'   =>[ 'type' => 'STR' ],
        'PrerequisWorkshop'     =>[ 'type' => 'STR' ],
        'RemarquesWorkshop'     =>[ 'type' => 'STR' ],
        'StatutWorkshop'        =>[ 'type' => 'STR', 'default' => 'actif' ]
    ],
    'workshop_user' => [
        'IdUserWorkshop'        =>[ 'type' => 'INT', 'autoincrement' => true, 'primary' => true ],
        'IdWorkshop'            =>[ 'type' => 'INT', 'mandatory' => true ],
        'IdUser'                =>[ 'type' => 'INT', 'mandatory' => true ],
        'DateUserWorkshop'      =>[ 'type' => 'DATE', 'default' => 'NOW' ],
        'StatutUserWorkshop'    =>[ 'type' => 'STR', 'default' => 'inscrit' ],
        'IsEvalUserWorkshop'    =>[ 'type' => 'STR', 'default' => 0 ]
    ],
    
    /**
     * Jointer between tables by the foreign keys. Used by the Orm
     */
    'relations' => [
        'workshops' => [
            'coachs'  =>['workshops'=>'IdCoach', 'coachs'=>'IdCoach']
        ],
        'workshop_user' => [
            'workshops' => ['workshop_user'=>'IdWorkshop', 'workshops'=>'IdWorkshop'],
            'users'     => ['workshop_user'=>'IdUser', 'users'=>'IdUser']
        ]
    ]
];