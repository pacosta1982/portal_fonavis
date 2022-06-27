<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'modality' => [
        'title' => 'Modalities',

        'actions' => [
            'index' => 'Modalities',
            'create' => 'New Modality',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            
        ],
    ],

    'land' => [
        'title' => 'Lands',

        'actions' => [
            'index' => 'Lands',
            'create' => 'New Land',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'short_name' => 'Short name',
            
        ],
    ],

    'document' => [
        'title' => 'Documents',

        'actions' => [
            'index' => 'Documents',
            'create' => 'New Document',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            
        ],
    ],

    'category' => [
        'title' => 'Categories',

        'actions' => [
            'index' => 'Categories',
            'create' => 'New Category',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            
        ],
    ],

    'project-type' => [
        'title' => 'Project Type',

        'actions' => [
            'index' => 'Project Type',
            'create' => 'New Project Type',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'short_name' => 'Short name',
            
        ],
    ],

    'stage' => [
        'title' => 'Stages',

        'actions' => [
            'index' => 'Stages',
            'create' => 'New Stage',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            
        ],
    ],

    'typology' => [
        'title' => 'Typologies',

        'actions' => [
            'index' => 'Typologies',
            'create' => 'New Typology',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            
        ],
    ],

    'parentesco' => [
        'title' => 'Parentesco',

        'actions' => [
            'index' => 'Parentesco',
            'create' => 'New Parentesco',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            
        ],
    ],

    'discapacidad' => [
        'title' => 'Discapacidad',

        'actions' => [
            'index' => 'Discapacidad',
            'create' => 'New Discapacidad',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            
        ],
    ],

    'modality-has-land' => [
        'title' => 'Modality Has Lands',

        'actions' => [
            'index' => 'Modality Has Lands',
            'create' => 'New Modality Has Land',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'modality_id' => 'Modality',
            'land_id' => 'Land',
            
        ],
    ],

    'land-has-project-type' => [
        'title' => 'Land Has Project Type',

        'actions' => [
            'index' => 'Land Has Project Type',
            'create' => 'New Land Has Project Type',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'land_id' => 'Land',
            'project_type_id' => 'Project type',
            
        ],
    ],

    'assignment' => [
        'title' => 'Assignments',

        'actions' => [
            'index' => 'Assignments',
            'create' => 'New Assignment',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'document_id' => 'Document',
            'category_id' => 'Category',
            'project_type_id' => 'Project type',
            'stage_id' => 'Stage',
            
        ],
    ],

    'project-type-has-typology' => [
        'title' => 'Project Type Has Typologies',

        'actions' => [
            'index' => 'Project Type Has Typologies',
            'create' => 'New Project Type Has Typology',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'project_type_id' => 'Project type',
            'typology_id' => 'Typology',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];