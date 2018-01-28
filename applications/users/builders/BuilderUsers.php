<?php
$dependencies = [
    'workshop_user' =>'IdUser'
];

return [
    
    /**
     * Fields format used by the Orm
     */
    'users' => [
        'IdUser'       =>[ 'type' => 'INT', 'autoincrement' => true, 'primary' => true, 'dependencies' => $dependencies ],
        'PseudoUser'   =>[ 'type' => 'STR' ],
        'PassUser'     =>[ 'type' => 'STR' ],
        'IdGroup'      =>[ 'type' => 'INT' ],
        'LastnameUser' =>[ 'type' => 'STR', 'mandatory' => true ],
        'FirstnameUser'=>[ 'type' => 'STR', 'mandatory' => true ],
        'EmailUser'    =>[ 'type' => 'STR', 'mandatory' => true ],
        'PhoneUser'   =>[ 'type' => 'STR' ],
        'AddressUser' =>[ 'type' => 'STR' ],
        'ZipCodeUser' =>[ 'type' => 'INT' ],
        'CityUser'    =>[ 'type' => 'STR' ]
    ],
       
    /**
     * Jointure between tables by the foreign keys. Used by the Orm
     */
    'relations' => [
        'users' => [
            'groups'                =>['users'=>'IdGroup', 'groups'=>'IdGroup']
        ]
    ]
    
];

