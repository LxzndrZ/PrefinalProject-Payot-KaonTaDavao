# Kaon Ta! Davao – Payot's Food Guide

Prefinal Milestone Project by **Alexzander Rojan Payot** (4-334 Full-Stack Development).

A Laravel 12 guide to Davao City carinderias and eateries: eateries by district, their permits, dishes, features, and reviews.

## Setup

```
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
npm install
npm run build
php artisan serve
```

## My personalized data

- Districts: Poblacion, Talomo, Agdao, Buhangin, Toril, Calinan
- Features: Suki ni Payot, Budget Meal, Halal, Open 24 Hours, Aircon, Free Wi-Fi
- Users (password `kaonta2026`):
  - Alexzander Rojan Payot – payot@kaonta.test
  - Tita Payot – tita.payot@kaonta.test
- My eatery: Carinderia ni Payot (`carinderia-ni-payot`), Poblacion, San Pedro St., Poblacion, Davao City, budget, Tinolang Manok
- My permit: DVO-2026-0520, expires May 20, 2027

## Relationships

| Relationship | Type | Why it fits |
|---|---|---|
| District and Eatery | hasMany / belongsTo | One district has many eateries, but each eatery is in only one district. |
| Eatery and Dish | hasMany / belongsTo | One eatery sells many dishes, and each dish belongs to one eatery. |
| Eatery and Review | hasMany / belongsTo | One eatery gets many reviews, and each review is about one eatery. |
| User and Review | hasMany / belongsTo | One user can write many reviews, and each review has one writer. |
| Eatery and Permit | hasOne / belongsTo | An eatery has exactly one business permit, so `eatery_id` is unique in permits. |
| Eatery and Feature | belongsToMany / belongsToMany | An eatery can have many features and a feature is shared by many eateries, so they meet in the `eatery_feature` pivot table. |
| District and Review | hasManyThrough | Reviews have no district id, but each review belongs to an eatery that belongs to a district, so I count them through Eatery. |

## Routes

```
  GET|HEAD        / .................................................................... home › HomeController
  GET|HEAD        districts ....................................... districts.index › DistrictController@index
  GET|HEAD        districts/{district} .............................. districts.show › DistrictController@show
  GET|HEAD        eateries ........................................... eateries.index › EateryController@index
  POST            eateries ........................................... eateries.store › EateryController@store
  GET|HEAD        eateries/create .................................. eateries.create › EateryController@create
  GET|HEAD        eateries/{eatery} .................................... eateries.show › EateryController@show
  PUT|PATCH       eateries/{eatery} ................................ eateries.update › EateryController@update
  DELETE          eateries/{eatery} .............................. eateries.destroy › EateryController@destroy
  GET|HEAD        eateries/{eatery}/edit ............................... eateries.edit › EateryController@edit
  POST            eateries/{eatery}/reviews .................. eateries.reviews.store › ReviewController@store
  GET|HEAD        reviewers/{user} .................................. reviewers.show › ReviewerController@show
  DELETE          reviews/{review} ................................ reviews.destroy › ReviewController@destroy

                                                                                           Showing [13] routes
```

## Screenshots

![Eatery list](screenshots/eatery-list.png)
![Eatery page with reviews](screenshots/eatery-page.png)
![Create form with validation errors](screenshots/create-errors.png)