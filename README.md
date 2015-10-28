# iHRIS FHIR Data Sync

This project was created to parse FHIR Terminology data, and insert it into the MySQL database of iHRIS. To use the ihris-fhir data sync, you must set the URL and authentication credentials for the MySQL database, as well as the FHIR server.

Once you are authenticated: for each iHRIS feature listed below, you can drop the corresponding MySQL table data, and re-populate it with FHIR value set data.

First, configure the MySQL database:
```
$sync->setMysqlConnection("server.ct.apelon.com", "user", "password", "ihris_manage");
```

Next, configure the FHIR server:
```
$sync->setFhirServer("http://dts-server.com:8081/dtsserverws/fhir/", "username", "password");
```

iHRIS data that can be synced, and the corresponding FHIR value-set:
 - Facility Types (valueset-c80-facilitycodes)
 - Position Types (HeathCareWorkerTypes)
 - Country
 - County
 - District
 - Region

** The value-sets for the last 4 still need to be created.

# Data
The first revision of ihris-fhir sync only supports two operations: clearing the tables (purging all table-data) and inserting every concept from the value-set.

To clear the iHRIS data from a table, use one of the following methods.

## Purge Data
```
dropCountry()
dropCounty()
dropDistrict()
dropRegion()
dropFacility()
dropPosition()
```

## Insert Data
To populate an iHRIS table with Terminology data, you must call one of the following methods and pass in the corresponding FHIR value-set that you want to use to populate the table.
```
syncCountry('value-set-identifier')
syncCounty('value-set-identifier')
syncDistrict('value-set-identifier')
syncRegion('value-set-identifier')
syncFacility('value-set-identifier')
syncPosition('value-set-identifier')