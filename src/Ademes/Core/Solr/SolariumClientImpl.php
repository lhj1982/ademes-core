<?php
namespace Ademes\Core\Solr;

use Ademes\Core\models\Solr\SearchResult as SearchResult;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class SolariumClientImpl implements \Ademes\Core\Solr\SolariumClient {
    
    private $base_url;
    /**
     * @var The SOLR client.
     */
    protected $client;

    /**
     * Constructor
     **/
    public function __construct()
    {
        $this->base_url = \Config::get('core::core.base_url');
        // create a client instance      
        $this->client = new \Solarium\Client(\Config::get('core::core.solr'));
    }
    
    public function addIndex($entry) {
        
    }

    public function reindex() {
        echo 'aaaa';exit;
    }

    public function search($keywords, $filter=null, $sortBy=null, $limit = 10) {
        try {
            return $this->_findInIndex($keywords, $filter);
        } catch (Solarium\Exception $e) {
            throw new \Ademes\Core\Exception\SolrException('500', $e->getMessage());
        }
    }

    public function ping() {
        $ping = $this->client->createPing();
        // execute the ping query
        try {
            $result = $this->client->ping($ping);
            //var_dump($result);
            return json_encode($result->getResponse()->getBody());
        } catch (Solarium\Exception $e) {
            throw new \Ademes\Core\Exception\SolrException('500', $e->getMessage());
        }
    }
    
    /**
     * Return mapped search result object.
     * 
     * @param  [type] $keywords [description]
     * @param  [type] $filter   [description]
     * @param  [type] $sortBy   [description]
     * @return [type] $limit    [description]
     */
    private function _findInIndex($keywords, $filter=null, $sortBy=null, $limit=10)
    {
        $ret = array();
        $query = $this->client->createSelect();
        // create a filterquery
        if (!empty($keywords))
        {
            // if isbn
            if (preg_match('/^\d{10,13}$/', $keywords)) {
                $query->addFilterQuery(array(
                    'key' => 'fq1',
                    // 'tag' => array('populationLimit'),
                    'query' => 'ISBN:'.$keywords,
                ));
            } else {
                $query->addFilterQuery(array(
                    'key' => 'fq1',
                    // 'tag' => array('populationLimit'),
                    'query' => '"'.$keywords.'"'.'~0.5',
                ));
            }
        }
        if (!empty($filter))
        {
            if (!empty($filter['categoryNames']))
            {
                $query->addFilterQuery(array(
                    'key' => 'fq4',
                    // 'tag' => array('populationLimit'),
                    'query' => 'categories:'.implode(' ',$filter['categoryNames']),
                    ));
            }
            
            if(!empty($filter['min']) && !empty($filter['max'])) {
                $query->addFilterQuery(array(
                    'key'=> 'fq2',
                    'query' => 'min_investment: ['.($filter['min']*10000).' TO *]'
                ));
                $query->addFilterQuery(array(
                    'key'=> 'fq3',
                    'query' => 'max_investment: [* TO '.($filter['max']*10000).']'
                ));
            } elseif(!empty($filter['min']) && empty($filter['max'])) {
                $query->addFilterQuery(array(
                    'key'=> 'fq2',
                    'query' => 'min_investment: ['.($filter['min']*10000).' TO *]'
                ));
            } elseif(empty($filter['min']) && !empty($filter['max'])) {
                $query->addFilterQuery(array(
                    'key'=> 'fq3',
                    'query' => 'max_investment: [* TO '.($filter['max']*10000).']'
                ));
            }
        }
        $query->setRows($limit);
        //:['' TO *]
        //
        // *:* is equivalent to telling solr to return all docs
        $resultSet = $this->client->select($query);
        $index = 0;
        foreach ($resultSet as $result) {
            $klass = new \StdClass;
            $klass->id = $result->id;
            $klass->name = $result->name;
            $klass->description = $result->description;
            $klass->min_investment = $result->min_investment;
            $klass->max_investment = $result->max_investment;
            $klass->address = $result->address;
            $klass->tags = $this->_getTagsOrCategories($result->tags);
            $klass->categories = $this->_getTagsOrCategories($result->categories);
            $klass->url = $result->url;
            $klass->contact_name = $result->contact_name;
            $klass->contact_email = $result->contact_email;
            $klass->contact_phone = $result->contact_phone;
            if (isset($result->big_image_url)) {
                $klass->big_image_url = $this->base_url.'/images/items/'.$result->big_image_url;
            }
            if (isset($result->medium_image_url)) {
                $klass->medium_image_url = $this->base_url.'/images/items/'.$result->medium_image_url;
            }
            if (isset($result->small_image_url)) {
                $klass->small_image_url = $this->base_url.'/images/items/'.$result->small_image_url;
            }
            $klass->company = $this->_getCompany($result->companyId, $result->companyName, $result->companyBigImageUrl, $result->companyMediumImageUrl, $result->companySmallImageUrl);
            $klass->territory = $this->_getTerritory($result->territoryId, $result->territoryName, $result->countryId, $result->countryName);
            $ret[$index++] = $klass;
        }

        return $this->_mapSearchResult($ret, $filter);
    }

    private function _mapSearchResult($items, $filter)
    {
        $page = 0;
        $limit = 0;
        if (!empty($filter['page']))
        {
            $page = $filter['page'];
        }
        if (!empty($filter['limit']))
        {
            $limit = $filter['limit'];
        }
        $finalRet = new SearchResult;
        $finalRet->setItemType("Item");
        $finalRet->setPage($page);
        $finalRet->setLimit($limit);
        $finalRet->setTotalItems($items);
        if ($page != 0 && $limit != 0)
        {
            if (is_array($items))
            {
                $finalRet->setItems(array_slice($items, ($page-1)*$limit, $limit, true));
            } else {
                $finalRet->setItems($items);
            }
        } else {
            $finalRet->setItems($items);
        }
        return $finalRet;
    }
    
    private function _getTagsOrCategories($tags) {
        if (!isset($tags) || !is_array($tags)) {
            return null;
        }
        $ret = [];
        foreach ($tags as $tag) {
            $obj = new \stdClass();
            $obj->name = $tag;
            array_push($ret, $obj);
        }
        return $ret;
    }
    
    private function _getCompany($companyId, $companyNmae, $companyBigImageUrl, $companyMediumImageUrl, $companySmallImageUrl) {
        $obj = new \stdClass();
        $obj->id = $companyId;
        $obj->name = $companyNmae;
        if (isset($companyBigImageUrl)) {
            $obj->big_image_url = $this->base_url.'/images/companies/'.$companyBigImageUrl;
        }
        if (isset($companyBigImageUrl)) {
            $obj->medium_image_url = $this->base_url.'/images/companies/'.$companyMediumImageUrl;
        }
        if (isset($companyBigImageUrl)) {
            $obj->small_image_url = $this->base_url.'/images/companies/'.$companySmallImageUrl;
        }
        return $obj;
    }
    
    private function _getTerritory($territoryId, $territoryName, $countryId, $countryName) {
        $country = new \stdClass();
        $country->id=$countryId;
        $country->name = $countryName;
        $obj = new \stdClass();
        $obj->id = $territoryId;
        $obj->name = $territoryName;
        $obj->country = $country;
        return $obj;
    }

}

