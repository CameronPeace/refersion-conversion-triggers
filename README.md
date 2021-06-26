# How to get started #
1. copy the content of .env.example into a .env file
2. provide data for the shopify and refersion variables including the webhook sign and domain
3. Provide AWS programmatic keys and provide a queue name for the SQS_CONVERSION_TRIGGER_QUEUE variable 
3. run `composer install`
4. run `php artisan serve`
5. create a public url using ngrok.io or your service of choice
6. update shopify notification settings to include a ProductsCreate webhook to the following path: https://{public_url}/api/shopify/webhook/products/create 
7. run `php artisan queue:listen conversion-triggers --tries=1`
8. You should be able to start testing by creating products in shopify