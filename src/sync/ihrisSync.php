<?php

namespace IHRISSYNC\ihrisSync;


/**
 * Description of ihrisSync
 *
 * @author vasili
 */
class ihrisSync {
    
    private $conn, $dtsServer, $dtsUser, $dtsPassword;
    
    public function test() {
        
        $sync = new $this();
        $sync->setMysqlConnection("hardevhim.ct.apelon.com", "ihris_manage", "apelon1", "ihris_manage");
        $sync->setFhirServer("http://40.143.220.156:8081/dtsserverws/fhir/", "dtsadminuser", "dtsadmin");
        $sync->dropCountry();
        $sync->syncCountry("valueset-c80-facilitycodes");
        
    }
    
    /**
     * Set the iHRIS MySql backend URL, Username, Password and the databsae 
     * iHRIS is currently using
     * 
     * @param type $url MySQL Server URL
     * @param type $user MySQL Username
     * @param type $password MySQL Password
     * @param type $db MySQL Database Name
     */
    public function setMysqlConnection($url, $user, $password, $db) {
        $this->conn = mysqli_connect($url, $user, $password, $db);
    }
    
    /**
     * Set DTS FHIRE Server Info
     * 
     * @param type $url URL of the DTS FHIR Server
     * @param type $username DTS Server Username
     * @param type $password DTS Server Password
     */
    public function setFhirServer($url, $username, $password) {
        $this->dtsServer = $url;
        $this->dtsUser = $username;
        $this->dtsPassword = $password;
    }
    
    /**
     * Returns an array of parsed FHIR Data from the value-set passed-in
     * @param type $valueSet DTS FHIR Value-Set name to retreive
     */
    public function getFhirData($valueSet) {
        $url = $this->dtsServer . "ValueSet/' . $valueSet . '/$expand";
        $context = stream_context_create(array(
        'http' => array(
            'header' => "Accept: application/xml" .
                        "Authorization: Basic " . base64_encode($this->dtsUser . ":" . $this->dtsPassword)
                )
            )
        );

        $xml = file_get_contents($url, false, $context);
        $xml = simplexml_load_string($xml);
        print_r($xml); //TODO: Remove after testing
        $fhir = new SimpleXMLElement($xml);
        return $xml->expansion;
    }
    
    public function dropCountry() {
        $sql = "TRUNCATE table hippo_country";
        mysqli_query($this->conn, $sql);
    }
    
    private function insertCountry($name, $code) {
        $explode = explode(" ", $name);
        $firstWord = $explode[0];  $secondWord = $explode[1];
        $countryCode = $firstWord[0] . $secondWord[1];
        
        $sql = "INSERT INTO "
                . "hippo_country "
                    . "(parent, "
                    . "last_modified, "
                    . "i2ce_hidden,"
                    . "name, "
                    . "alpha_two, "
                    . "code, "
                    . "primary, "
                    . "location) "
                . " VALUES ("
                    . "NULL, "
                    . "NOW(), "
                    . "0, "
                    . $name . ", "
                    . $countryCode . ", "
                    . $code . " "
                    . "1, "
                    . "1); ";
            return mysqli_query($this->conn, $sql);
    }
    
    public function syncCountry($valueSet) {
        $fhirData = $this->getFhirData($valueSet);
        
        foreach($fhirData as $f) {
            if($f->contains != null) { //Verify this works
                $this->insertRegion($f->display['value'], $f->display['value']);
            }
        }
    }
    
    public function dropRegion() {
        $sql = "TRUNCATE table hippo_country";
        mysqli_query($this->conn, $sql);
    }
    
    public function syncRegion($valueSet) {
        $fhirData = $this->getFhirData($valueSet);
        
        foreach($fhirData as $f) {
            if($f->contains != null) { //Verify this works
            ////TODO: Sync Region
                //$this->insertRegion($f->display['value'], $f->display['value']);
            }
        }
    }
    
    public function dropDistrict($valueSet) {
        $sql = "TRUNCATE table hippo_country";
        mysqli_query($this->conn, $sql);
    }
    
    public function syncDistrict() {
        $fhirData = $this->getFhirData($valueSet);
        
        foreach($fhirData as $f) {
            if($f->contains != null) { //Verify this works
                //$this->insertDistrict($f->display['value'], $f->display['value']);
                //TODO: Sync District
            }
        }
       
    }
    
    public function dropCounty() {
        $sql = "TRUNCATE table hippo_country";
        mysqli_query($this->conn, $sql);
    }
    
    public function syncCounty($valueSet) {
        $fhirData = $this->getFhirData($valueSet);
        
        foreach($fhirData as $f) {
            if($f->contains != null) { //Verify this works
                //TODO: Sync County
                //$this->insertCounty($f->display['value'], $f->display['value']);
            }
        }
        
    }
    
    public function dropFacility() {
        $sql = "TRUNCATE table hippo_country";
        mysqli_query($this->conn, $sql);
    }
    
    public function syncFacility($valueSet) {
        $fhirData = $this->getFhirData($valueSet);
        
        foreach($fhirData as $f) {
            if($f->contains != null) { //Verify this works
                //TODO: Sync County
                //$this->insertCounty($f->display['value'], $f->display['value']);
            }
        }
        
    }
    
    public function dropPosition() {
        $sql = "TRUNCATE table hippo_country";
        mysqli_query($this->conn, $sql);
    }
    
    public function syncPosition($valueSet) {
        $fhirData = $this->getFhirData($valueSet);
        
        foreach($fhirData as $f) {
            if($f->contains != null) { //Verify this works
                //TODO: Sync County
                //$this->insertCounty($f->display['value'], $f->display['value']);
            }
        }
        
    }
    
   
}
