---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](https://localhost/docs/collection.json)

<!-- END_INFO -->

#Auth

APIs for managing authentication (login, register)
<!-- START_8c0e48cd8efa861b308fc45872ff0837 -->
## Login

> Example request:

```bash
curl -X POST \
    "http://localhost/api/v1/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"email":"nisreen.baik@gmail.sa","password":"123456","remember_me":1}'

```

```javascript
const url = new URL(
    "http://localhost/api/v1/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "email": "nisreen.baik@gmail.sa",
    "password": "123456",
    "remember_me": 1
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "status": true,
    "status_code": 200,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiODAyZjBmY2UxMzZkODI2ZWU2Y2U0OTY4Njg1NzI2Njc4ZWYyZWFhYTNhNmI4YjI2OTRkYzI3ZDdlMGQwNjg3MWJiNzUzZDRiOWU0N2JiNTAiLCJpYXQiOjE2NDk4NzQ1MDQuODk3Mjc0LCJuYmYiOjE2NDk4NzQ1MDQuODk3Mjc3LCJleHAiOjE2ODE0MTA1MDQuODg1MzEzLCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.S-wKvJIgJdWplkZZgz5BOPGIah6mmrfrX9XHMpQfvrgqvLsNDQ7iv7QvSwFGs1OCuuEfmvGxiBa6c3s0kns02LobkKv87z9O2dNRNZD_5cSwu1S_PItPYkBNmGWXtOyOcUGgacvBk0lNu6soWCjoVTMS5ooZ8rmul_4nkEpB6y_fP6SIglIoLVO5rvdPjhLQUr-STY4R6Q_9OlM8qjS-1Nk3tBIdMlKFAsQarNto_-S-O2rkMeiOFDCzffh6QtncgEwDYQnBxxLDWlZgRL42FyoPM0Go03MBzN1QnxMmcA3t2RMDYDEkMMHEOoMpGwMjUhIbhQYRTRd2e5O2MpKmXjZRfIvpT5QC1q4ilRmCYg0bHI2dQS-D8MnidL9xMHzg7ImKZUC8CaCDhicoPj88aoFDQqHLL2ZjZWAAUueDq73nUIp7mu7WmGmlT13PNC6_XsHJAS1ci0RyDio9UlFLFLs9EIVUiirKmlHxcXQG1wQfcSKB5NyiLyIr4dpr-pOAZvqqgDn_8xU1qFIoFoNAvSKF06WI6nynqaomgsLje0ZCLDA-mL4kq4Jh2pcMpyD5f2DW47Y7LMfvPJU_pJmQEPTivUlLKpTZfhJZCLObIQJFVvNLERYrWPc43BBBUOZeo5K5HWtao1h3GxsJL7XH2pynGcKEJgHtXrworx3_b7Y",
    "user": {
        "id": 2,
        "name": "Consumer",
        "email": "consumer@gmail.com",
        "email_verified_at": null,
        "created_at": "2022-04-13T10:14:36.000000Z",
        "updated_at": "2022-04-13T10:14:36.000000Z"
    }
}
```
> Example response (401):

```json
{
    "status": false,
    "status_code": 401,
    "message": "Incorrect credential, unauthorised user!"
}
```
> Example response (422):

```json
{
    "status": false,
    "status_code": 422,
    "message": "The given data was invalid.",
    "errors": {
        "password": [
            "The password field is required."
        ]
    }
}
```

### HTTP Request
`POST api/v1/login`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | string |  required  | The user email.
        `password` | string |  required  | The user password.
        `remember_me` | integer |  optional  | If remember_me = 0, then the token will expires after one week.
    
<!-- END_8c0e48cd8efa861b308fc45872ff0837 -->

<!-- START_8ae5d428da27b2b014dc767c2f19a813 -->
## Register

> Example request:

```bash
curl -X POST \
    "http://localhost/api/v1/register" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"name":"Nisreen Albaik","email":"nisreen@gmail.com","password":"123456","password_confirmation":"123456","role":"consumer"}'

```

```javascript
const url = new URL(
    "http://localhost/api/v1/register"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "name": "Nisreen Albaik",
    "email": "nisreen@gmail.com",
    "password": "123456",
    "password_confirmation": "123456",
    "role": "consumer"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (201):

```json
{
    "status": true,
    "status_code": 201,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiN2JjNWU5YTU5MjA5NWEyOWQxZjliMGZmMjlhNWY3MTVmNzcyOGQ0NTlmOTc4NDU3ZTJmYjI4ZjdmMzk1YmYzNjRhOGZhNDM1ZDI3ZmE3NDUiLCJpYXQiOjE2NDk4NzQ4NTIuNjg4MzI4LCJuYmYiOjE2NDk4NzQ4NTIuNjg4MzMyLCJleHAiOjE2ODE0MTA4NTIuNjgyNzYsInN1YiI6IjQiLCJzY29wZXMiOltdfQ.p0GWtso5qn1VTSq3-cTfpkzWe3toURRbfZeiQCQUGWayjonZI9bNCqqMgI8gQ8_Q1eGAQLOtCIemnHRxSHULPhZ5CPiazRpnb_c8r_NlUaEETDVkutZGXptVRYomKBqbNl-eIeoECCocZZyI35OjRqOWCGYkmk51zFHIndl8PqcDum6DBAEh-k2teVl0DXN5PS55qh_vQ4GKPk_ptNYq88CSSjM4AYdi-GFQfhh-DkY3idQlE5AXXRxMF61HK5xoQ_hWDVgbxwHtovE_Ht-cDTl_tUBhHOWC0V3r74RiTwTg_pf64l2b0xMOXL504Ro-R1q1OHws1n8Ew3EYd7XX8s_rH_vsGthxG22ey976IqziunDUv8lhGPFIezSIFWz2GD2-XXRvzTVrPsS7WwO5ejo0nQuCcFNfziZhQN6UbSCyGCuN8Blrhv-w_9T4vz_ycnI3D3hPwEg_NwEGTbfA5odl-E9DsNZOSNxt6Sxfavwm17kjnw5WAJdhENxG6dJTffz8tipja4yPCSPH2OxIPR51Tb5Yz2MHvFCIt_52eP2LxnSk65v3B1MfUYE8G4J5LsPiT9eCRoJ-ow8RV2eQKvAkvVLbCzDkg7APCIj0TdIT-azeyjCg9-O4t6wB--aW-Nh9fXxD_NMGMLP-NUPkdoJYOaB-E3oQ4clzXP0Fzlg",
    "user": {
        "name": "Test name 03",
        "email": "merchant-03@gmail.com",
        "updated_at": "2022-04-13T18:34:12.000000Z",
        "created_at": "2022-04-13T18:34:12.000000Z",
        "id": 4,
        "roles": [
            {
                "id": 1,
                "name": "merchant",
                "guard_name": "web",
                "created_at": "2022-04-13T10:14:36.000000Z",
                "updated_at": "2022-04-13T10:14:36.000000Z",
                "pivot": {
                    "model_id": 4,
                    "role_id": 1,
                    "model_type": "App\\Models\\User"
                }
            }
        ]
    }
}
```
> Example response (400):

```json
{
    "status": false,
    "status_code": 400,
    "message": "Failed to create a new user!"
}
```
> Example response (422):

```json
{
    "status": false,
    "status_code": 422,
    "message": "The given data was invalid.",
    "errors": {
        "email": "The question field is required."
    }
}
```

### HTTP Request
`POST api/v1/register`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  required  | The user name.
        `email` | string |  required  | The email of the user.
        `password` | string |  required  | The user password.
        `password_confirmation` | string |  required  | The confirmation password.
        `role` | string |  required  | The role name (merchant, or consumer).
    
<!-- END_8ae5d428da27b2b014dc767c2f19a813 -->

#Carts

APIs for managing shopping carts
<!-- START_a1674e9fbbb599f58cb019b72e08ee94 -->
## Calculate Shopping Cart

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
Calculating the total shopping cart of the auth user,
by considering the VAT of each product price (if the VAT included in the store setting witch the product is related),
with quantity for each product and shipping cost for each store.
then returning the total_products_price, total_shipping_cost, cart_total_price, and cart_products.

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/calculate-cart" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/calculate-cart"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "status": true,
    "status_code": 200,
    "total_products_price": 1776,
    "total_shipping_cost": 10,
    "cart_total_price": 1786,
    "cart_products": [
        {
            "id": 1,
            "price": 222,
            "store_id": 1,
            "created_at": "2022-04-13T10:17:25.000000Z",
            "updated_at": "2022-04-13T10:17:25.000000Z",
            "VAT_percentage": 11,
            "name": "Test en product name",
            "description": "Test en product description",
            "pivot": {
                "cart_id": 1,
                "product_id": 1,
                "quantity": 5
            },
            "store": {
                "id": 1,
                "name": "Test store name",
                "merchant_id": 1,
                "is_VAT_included": "1",
                "VAT_percentage": 11,
                "shipping_cost": 5,
                "created_at": "2022-04-13T10:16:59.000000Z",
                "updated_at": "2022-04-13T15:58:40.000000Z"
            },
            "translations": [
                {
                    "id": 2,
                    "product_id": 1,
                    "locale": "ar",
                    "name": "Test ar product name",
                    "description": "Test ar product description"
                },
                {
                    "id": 1,
                    "product_id": 1,
                    "locale": "en",
                    "name": "Test en product name",
                    "description": "Test en product description"
                }
            ]
        },
        {
            "id": 2,
            "price": 222,
            "store_id": 1,
            "created_at": "2022-04-13T10:17:42.000000Z",
            "updated_at": "2022-04-13T10:17:42.000000Z",
            "VAT_percentage": 11,
            "name": "Test en product name 2",
            "description": "Test en product description 2",
            "pivot": {
                "cart_id": 1,
                "product_id": 2,
                "quantity": 1
            },
            "translations": [
                {
                    "id": 4,
                    "product_id": 2,
                    "locale": "ar",
                    "name": "Test ar product name 2",
                    "description": "Test ar product description 2"
                },
                {
                    "id": 3,
                    "product_id": 2,
                    "locale": "en",
                    "name": "Test en product name 2",
                    "description": "Test en product description 2"
                }
            ]
        },
        {
            "id": 3,
            "price": 222,
            "store_id": 1,
            "created_at": "2022-04-13T10:18:02.000000Z",
            "updated_at": "2022-04-13T10:18:02.000000Z",
            "VAT_percentage": 11,
            "name": "Test en product name 3",
            "description": "Test en product description 3",
            "pivot": {
                "cart_id": 1,
                "product_id": 3,
                "quantity": 1
            },
            "translations": [
                {
                    "id": 6,
                    "product_id": 3,
                    "locale": "ar",
                    "name": "Test ar product name 3",
                    "description": "Test ar product description 3"
                },
                {
                    "id": 5,
                    "product_id": 3,
                    "locale": "en",
                    "name": "Test en product name 3",
                    "description": "Test en product description 3"
                }
            ]
        },
        {
            "id": 5,
            "price": 222,
            "store_id": 4,
            "created_at": "2022-04-13T16:17:06.000000Z",
            "updated_at": "2022-04-13T16:17:06.000000Z",
            "VAT_percentage": 11,
            "name": "Test en product name 49",
            "description": "Test en product description 48",
            "pivot": {
                "cart_id": 1,
                "product_id": 5,
                "quantity": 1
            },
            "store": {
                "id": 4,
                "name": "Test store name 03",
                "merchant_id": 3,
                "is_VAT_included": "1",
                "VAT_percentage": 11,
                "shipping_cost": 5,
                "created_at": "2022-04-13T16:16:46.000000Z",
                "updated_at": "2022-04-13T17:38:32.000000Z"
            },
            "translations": [
                {
                    "id": 10,
                    "product_id": 5,
                    "locale": "ar",
                    "name": "Test ar product name 45",
                    "description": "Test ar product description 47"
                },
                {
                    "id": 9,
                    "product_id": 5,
                    "locale": "en",
                    "name": "Test en product name 49",
                    "description": "Test en product description 48"
                }
            ]
        }
    ]
}
```
> Example response (401):

```json
{
    "status": false,
    "status_code": 401,
    "message": "Unauthenticated."
}
```
> Example response (403):

```json
{
    "status": false,
    "status_code": 403,
    "message": "User does not have the right roles."
}
```

### HTTP Request
`GET api/v1/calculate-cart`


<!-- END_a1674e9fbbb599f58cb019b72e08ee94 -->

#Products

APIs for managing products
<!-- START_28af8ed803e5660fd81e4ec67ba32667 -->
## Add Product

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/api/v1/add-product/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"price":200,"ar_name":"Arabic product name","ar_description":"Arabic product description","en_name":"English product name","en_description":"English product description"}'

```

```javascript
const url = new URL(
    "http://localhost/api/v1/add-product/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "price": 200,
    "ar_name": "Arabic product name",
    "ar_description": "Arabic product description",
    "en_name": "English product name",
    "en_description": "English product description"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (201):

```json
{
    "status": true,
    "status_code": 201,
    "product": {
        "price": 222,
        "store_id": "4",
        "updated_at": "2022-04-13T19:11:20.000000Z",
        "created_at": "2022-04-13T19:11:20.000000Z",
        "id": 6,
        "VAT_percentage": 11,
        "name": "Test en product name 49",
        "description": "Test en product description 48",
        "translations": [
            {
                "locale": "en",
                "name": "Test en product name 49",
                "description": "Test en product description 48",
                "product_id": 6,
                "id": 11
            },
            {
                "locale": "ar",
                "name": "Test ar product name 45",
                "description": "Test ar product description 47",
                "product_id": 6,
                "id": 12
            }
        ]
    }
}
```
> Example response (400):

```json
{
    "status": false,
    "status_code": 400,
    "message": "Failed to add the product in your store!"
}
```
> Example response (401):

```json
{
    "status": false,
    "status_code": 401,
    "message": "Unauthenticated."
}
```
> Example response (403):

```json
{
    "status": false,
    "status_code": 403,
    "message": "User does not have the right roles."
}
```
> Example response (422):

```json
{
    "status": false,
    "status_code": 422,
    "message": "The given data was invalid.",
    "errors": {
        "price": [
            "The price field is required."
        ]
    }
}
```

### HTTP Request
`POST api/v1/add-product/{store}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `store_id` |  optional  | int required
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `price` | integer |  required  | The product price.
        `ar_name` | string |  required  | The Arabic name of the product.
        `ar_description` | string |  required  | The Arabic description of the product.
        `en_name` | string |  required  | The English name of the product.
        `en_description` | string |  required  | The English description of the product.
    
<!-- END_28af8ed803e5660fd81e4ec67ba32667 -->

<!-- START_f3ae8d13b190686585af16060ceb5ac6 -->
## Add Product To Cart

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
If the user does not have a cart yet we will create one, then add the product to their cart.
and if the user adds the same product we will update the existing records by updating the quantity column

> Example request:

```bash
curl -X POST \
    "http://localhost/api/v1/add-product-to-cart/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"quantity":2}'

```

```javascript
const url = new URL(
    "http://localhost/api/v1/add-product-to-cart/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "quantity": 2
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (201):

```json
{
    "status": true,
    "status_code": 201,
    "cart_products": [
        {
            "id": 1,
            "price": 222,
            "store_id": 1,
            "created_at": "2022-04-13T10:17:25.000000Z",
            "updated_at": "2022-04-13T10:17:25.000000Z",
            "VAT_percentage": 11,
            "name": "Test en product name",
            "description": "Test en product description",
            "pivot": {
                "cart_id": 1,
                "product_id": 1,
                "quantity": 5
            },
            "translations": [
                {
                    "id": 2,
                    "product_id": 1,
                    "locale": "ar",
                    "name": "Test ar product name",
                    "description": "Test ar product description"
                },
                {
                    "id": 1,
                    "product_id": 1,
                    "locale": "en",
                    "name": "Test en product name",
                    "description": "Test en product description"
                }
            ]
        },
        {
            "id": 2,
            "price": 222,
            "store_id": 1,
            "created_at": "2022-04-13T10:17:42.000000Z",
            "updated_at": "2022-04-13T10:17:42.000000Z",
            "VAT_percentage": 11,
            "name": "Test en product name 2",
            "description": "Test en product description 2",
            "pivot": {
                "cart_id": 1,
                "product_id": 2,
                "quantity": 1
            },
            "translations": [
                {
                    "id": 4,
                    "product_id": 2,
                    "locale": "ar",
                    "name": "Test ar product name 2",
                    "description": "Test ar product description 2"
                },
                {
                    "id": 3,
                    "product_id": 2,
                    "locale": "en",
                    "name": "Test en product name 2",
                    "description": "Test en product description 2"
                }
            ]
        },
        {
            "id": 3,
            "price": 222,
            "store_id": 1,
            "created_at": "2022-04-13T10:18:02.000000Z",
            "updated_at": "2022-04-13T10:18:02.000000Z",
            "VAT_percentage": 11,
            "name": "Test en product name 3",
            "description": "Test en product description 3",
            "pivot": {
                "cart_id": 1,
                "product_id": 3,
                "quantity": 1
            },
            "translations": [
                {
                    "id": 6,
                    "product_id": 3,
                    "locale": "ar",
                    "name": "Test ar product name 3",
                    "description": "Test ar product description 3"
                },
                {
                    "id": 5,
                    "product_id": 3,
                    "locale": "en",
                    "name": "Test en product name 3",
                    "description": "Test en product description 3"
                }
            ]
        },
        {
            "id": 5,
            "price": 222,
            "store_id": 4,
            "created_at": "2022-04-13T16:17:06.000000Z",
            "updated_at": "2022-04-13T16:17:06.000000Z",
            "VAT_percentage": 11,
            "name": "Test en product name 49",
            "description": "Test en product description 48",
            "pivot": {
                "cart_id": 1,
                "product_id": 5,
                "quantity": 1
            },
            "translations": [
                {
                    "id": 10,
                    "product_id": 5,
                    "locale": "ar",
                    "name": "Test ar product name 45",
                    "description": "Test ar product description 47"
                },
                {
                    "id": 9,
                    "product_id": 5,
                    "locale": "en",
                    "name": "Test en product name 49",
                    "description": "Test en product description 48"
                }
            ]
        }
    ]
}
```
> Example response (400):

```json
{
    "status": false,
    "status_code": 400,
    "message": "Failed to add the product in your store!"
}
```
> Example response (401):

```json
{
    "status": false,
    "status_code": 401,
    "message": "Unauthenticated."
}
```
> Example response (403):

```json
{
    "status": false,
    "status_code": 403,
    "message": "User does not have the right roles."
}
```
> Example response (422):

```json
{
    "status": false,
    "status_code": 422,
    "message": "The given data was invalid.",
    "errors": {
        "quantity": [
            "The quantity field is required."
        ]
    }
}
```

### HTTP Request
`POST api/v1/add-product-to-cart/{product}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `product_id` |  optional  | int required
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `quantity` | integer |  required  | The product quantity.
    
<!-- END_f3ae8d13b190686585af16060ceb5ac6 -->

#Stores

APIs for managing stores
<!-- START_5b917685119a835514714ac79e207786 -->
## Set Store Setting

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
This API is for setting the store setting or updating the merchant's store setting if existing.

> Example request:

```bash
curl -X POST \
    "http://localhost/api/v1/set-or-update-store-setting" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"name":"Store name","is_VAT_included":"1","VAT_percentage":5,"shipping_cost":8}'

```

```javascript
const url = new URL(
    "http://localhost/api/v1/set-or-update-store-setting"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "name": "Store name",
    "is_VAT_included": "1",
    "VAT_percentage": 5,
    "shipping_cost": 8
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (201):

```json
{
    "status": true,
    "status_code": 201,
    "store": {
        "name": "Test store name",
        "is_VAT_included": "1",
        "VAT_percentage": "5",
        "merchant_id": 1,
        "updated_at": "2022-04-13T15:42:28.000000Z",
        "created_at": "2022-04-13T15:42:28.000000Z",
        "id": 3
    }
}
```
> Example response (400):

```json
{
    "status": false,
    "status_code": 400,
    "message": "Failed to add the product in your store!"
}
```
> Example response (401):

```json
{
    "status": false,
    "status_code": 401,
    "message": "Unauthenticated."
}
```
> Example response (403):

```json
{
    "status": false,
    "status_code": 403,
    "message": "User does not have the right roles."
}
```
> Example response (422):

```json
{
    "status": false,
    "status_code": 422,
    "message": "The given data was invalid.",
    "errors": {
        "name": [
            "The name field is required."
        ]
    }
}
```

### HTTP Request
`POST api/v1/set-or-update-store-setting`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  required  | The store name.
        `is_VAT_included` | string |  required  | If the VAT included in product price set is_VAT_included to "1" .
        `VAT_percentage` | integer |  optional  | If the is_VAT_included = 1 then the VAT_percentage will be required.
        `shipping_cost` | integer |  required  | The shipping cost of the the product price in the store.
    
<!-- END_5b917685119a835514714ac79e207786 -->


