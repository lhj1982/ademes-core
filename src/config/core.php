<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return array(
    'base_url' => 'http://vdragon-api.dev',
    'solr' => array(
        'endpoint' => array(
            'localhost' => array(
                'host' => 'api.vdragon.local',
                'port' => 8080,
                'path' => '/solr/',
            )
        )
    ),
    'defaults' => [
        'image_base_url' => [
            'company' => '/images/companies/',
            'item' => '/images/items/',
            'user' => '/images/users/'
        ],
        'image' => [
            'company' => 'default.png',
            'item' => 'default.png',
            'user' => 'default.png'
        ]
    ]
);