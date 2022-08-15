# Esenceweb_cart_task

## Instructions
- Database Script is located in /DBDef directory
- /Home - Shows the current user
- /Products - Shows product list
- /Login - Shows Login page
- /Cart - If user is logged in, shows cart of that user
- /API/Products - a RESTFul Product API resource
    - The /ProductAPITestCollection/ dir has a set of Postman Collection for test
- /API/Auth/login (POST) - login
	- Any non-empty sUserName/sPassHash is accepted
- /API/Auth/logout (GET) - logout
- /API/Cart/myCart (GET) - Cart of currently logged in user
- /API/Cart/addProductToCart - Add product to card
	- if already existing, only updates quantity
- /API/Cart/removeProductFromCart -
	- if new quantity is (or less than) zero, removes the item
