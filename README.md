## About Filament

 https://filamentphp.com

- laravel new projecct-name
- composer require filament/filament:"^3.2" -W
- php artisan filament:install --panels
- php artisan make:filament-user
- npm i && composer i
- php artisan make:filament-resource ResourceName

- php artisan migrate
- php artisan serve

For Relationship Manager
- php artisan make:filament-relation-manager CategoryResource blogs title
# Docs
- https://filamentphp.com/docs/3.x/panels/resources/relation-managers

For Chart

- php artisan make:filament-widget BlogPostsChart --chart

For fetch data
- composer require flowframe/laravel-trend
