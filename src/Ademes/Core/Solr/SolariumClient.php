<?php
namespace Ademes\Core\Solr;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

interface SolariumClient {
    
    /**
     * 
     * @param type $keywords
     * @param type $filter
     * @param type $sortBy
     * @param type $limit
     */
    public function search($keywords, $filter, $sortBy, $limit=10);
    
    public function addIndex($entry);
    
    public function reindex();
    
}