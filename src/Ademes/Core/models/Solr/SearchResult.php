<?php
namespace Ademes\Core\models\Solr;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SearchResult {
    private $page;
    private $limit;
    private $totalItems; 
    private $items;
    private $itemType;
    
    function getPage() {
        return $this->page;
    }

    function getLimit() {
        return $this->limit;
    }

    function getTotalItems() {
        return $this->totalItems;
    }

    function getItems() {
        return $this->items;
    }

    function getItemType() {
        return $this->itemType;
    }

    function setPage($page) {
        $this->page = $page;
    }

    function setLimit($limit) {
        $this->limit = $limit;
    }

    function setTotalItems($totalItems) {
        $this->totalItems = $totalItems;
    }

    function setItems($items) {
        $this->items = $items;
    }

    function setItemType($itemType) {
        $this->itemType = $itemType;
    }


}