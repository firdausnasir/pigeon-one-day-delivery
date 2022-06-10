# Uber Pigeon

## About

This repo is a minimum-viable API created for an on-demand same-day traffic-independent document delivery service.

---

## Installation

* run composer install
    ```bash
    composer install
    ```
* migrate and seed data
    ```bash
    php artisan migrate --seed
    ```

---

## Authentication

### Request

`POST` => `/api/login`

### Header

| Header        | Value                    |
|---------------|--------------------------|
| Accept        | application/vnd.api+json |

### Parameter

| Parameter | Required |
|-----------|----------|
| email     | yes      |
| password  | yes      |

### Sample user

| Parameter | Value            |
|-----------|------------------|
| email     | test@example.com |
| password  | test1234         |

### Response

```yaml
{
    "message": "Authenticated",
    "data": {
        "user_id": 1,
        "name": "Test User",
        "access_token": "4|ljmNRzJUNor4muTP74umqtwTbzl7oLKc7ZjhDw6B"
    }
}
```

---

## Submit an order

### Request

`POST` => `/api/order/submit`

### Header

| Header        | Value                    |
|---------------|--------------------------|
| Authorization | Bearer {access_token}    |
| Accept        | application/vnd.api+json |

### Parameter

| Parameter | Required | Note              |
|-----------|----------|-------------------|
| distance  | yes      | in km             |
| deadline  | yes      | format: Y-m-d H:i |

### Response

```yaml
{
    "message": "Order created",
    "data": {
        "order_id": 9,
        "pigeon_name": "Neal Johnson II",
        "distance": "200 km",
        "price": "MYR 400.00",
        "status": "delivering",
        "should_deliver_at": "2022-06-10 14:30:00"
    }
}
```

---

## Get order detail

### Request

`POST` => `/api/order/details/{order_id}`
<br />
*order_id is unique identifier to get order details

### Header

| Header        | Value                    |
|---------------|--------------------------|
| Authorization | Bearer {access_token}    |
| Accept        | application/vnd.api+json |

### Response

```yaml
{
    "message": "Order found",
    "data": {
        "order_id": 1,
        "pigeon_name": "Bulah Balistreri",
        "distance": "200 km",
        "price": "MYR 400.00",
        "status": "delivering",
        "should_deliver_at": "2022-06-10 14:30:00"
    }
} 
```

---

## Mark specific order as delivered

### Request

`POST` => `/api/order/{order_id}/delivered`
<br />
*order_id is unique identifier to mark the order as delivered

### Header

| Header        | Value                    |
|---------------|--------------------------|
| Authorization | Bearer {access_token}    |
| Accept        | application/vnd.api+json |

### Response

* HTTP Code 204 will be returned
