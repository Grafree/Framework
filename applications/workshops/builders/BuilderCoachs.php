<?php
return [
    
    /**
     * Fields format used by the Orm
     */
    'coachs' => [
        'IdCoach'       =>[ 'type' => 'INT', 'autoincrement' => true, 'primary' => true, 'dependencies' => ['workshops'=>'IdWorkshop'] ],
        'LastnameCoach' =>[ 'type' => 'STR', 'mandatory' => true  ],
        'FirstnameCoach'=>[ 'type' => 'STR' ],
        'PhoneCoach'    =>[ 'type' => 'STR' ],
        'EmailCoach'    =>[ 'type' => 'STR' ],
        'AddressCoach'  =>[ 'type' => 'STR' ],
        'NpaCoach'      =>[ 'type' => 'STR' ],
        'CityCoach'     =>[ 'type' => 'STR' ],
        'ExpertiseCoach'=>[ 'type' => 'STR' ],
        'IsActiveCoach' =>[ 'type' => 'INT', 'default' => 1 ],
    ],
    
    /**
     * Jointer between tables by the foreign keys. Used by the Orm
     */
    'relations' => []
];