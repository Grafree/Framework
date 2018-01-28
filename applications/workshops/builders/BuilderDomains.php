<?php
return [
    'domaine' => [
        'IDDomaine'         =>[ 'type' => 'INT', 'autoincrement' => true, 'primary' => true, 'dependencies' => ['workshops'=>'IdSector'] ],
        'NomDomaine'        =>[ 'type' => 'STR' ],
    ],
    /**
     * Jointer between tables by the foreign keys. Used by the Orm
     */
    'relations' => [
    ]
];