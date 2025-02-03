## Introduction

``` text
This module is an extension to provide REST endpoints for the Shopfinder module. It allows you to : 
 - Get all shops.
 - Update a shop by identifier.
 - Disable deleting a shop by id.
```

## Installation

### Enable module Saddemlabidi_ShopfinderRest

```  bash
php bin/magento module:enable Saddemlabidi_ShopfinderRest
```

### Run setup upgrade

```  bash
php bin/magento setup:upgrade
```

### Run setup:di:compile

```  bash
php bin/magento setup:di:compile
```

## REST Example queries

### Get all shops request
```text
GET - https://mystore.test/rest/V1/shopfinder/shops/search?searchCriteria=[]
```
### Response example
```  json
{
    "items": [
        {
            "id": 7,
            "identifier": "store-07290",
            "name": "Dubai mall",
            "country": "AE",
            "image": "",
            "longitude_latitude": "15.54454, 13.545454",
            "created_at": "2025-02-03 04:47:21",
            "updated_at": "2025-02-03 04:47:21"
        },
        {
            "id": 9,
            "identifier": "shop-0013333",
            "name": "Updated Shop Name",
            "country": "US",
            "image": "shop-001.jpg",
            "longitude_latitude": "40.7128,-74.0060",
            "created_at": "2025-02-03 06:47:12",
            "updated_at": "2025-02-03 06:51:41"
        }...
    ],
    "search_criteria": {
        "filter_groups": []
    },
    "total_count": 4
}
```

### Try deleting shop by id Request

```text
DELETE - https://mystore.test/rest/V1/shopfinder/shops/search?searchCriteria=[]
```
### Response example
```  json
{
    "message": "Deleting shops via REST API is not allowed.",
    "trace": null
}
```


### Update shop by id Request

```text
PUT - https://mystore.test/rest/V1/shopfinder/shop
```
```json 
{
    "id": 9,
    "identifier": "shop-0013333",
    "name": "Updated Shop Name",
    "country": "USA",
    "image": "shop-001.jpg",
    "longitude_latitude": "40.9999,-20.0000"
}
```
### Response example
```  json
{
    "id": 9,
    "identifier": "shop-0013333",
    "name": "Updated Shop Name",
    "country": "USA",
    "image": "shop-001.jpg",
    "longitude_latitude": "40.9999,-20.0000",
}
```
### Get shop by identifier Request

```text
GET - https://mystore.test/rest//V1/shopfinder/shop/shop-001555
```

### Response example
```  json
{
    "id": 9,
    "identifier": "shop-001555",
    "name": "Updated Shop Naaaaaaaaaaaameaaaa",
    "country": "TN",
    "image": "shop-001.jpg",
    "longitude_latitude": "40.7128,-74.0060",
    "created_at": "2025-02-03 06:47:12",
    "updated_at": "2025-02-03 08:58:39"
}
```
