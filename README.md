# wic.api
WIC is a acronym for What I'll cook and this api serves to provide food recipe. Each request request a token as part of the header.
There are currently 2 endpoints

#### Endpoints
- GET `/api/get/recipe/{uuid}` to retrieve recipe based on a known unique id
  - ######Example cURL request
            curl -X GET "http://127.0.0.1:8000/api/get/recipe/fb09d733-be43-4ce3-a1df-e55796746738" -H "accept: application/json" -H "X-AUTH-TOKEN: VALID_TOKEN"
        
  - ###### Example json response
            {
              "name": "Rice and Beans with grilled chicken",
              "prep": 10,
              "cook": 240,
              "ingredient": [
                {
                  "description": "long grain parboiled rice",
                  "quantity": 500,
                  "unit": "g"
                },
                {
                  "description": "brown/black-eyed beans ",
                  "quantity": 250,
                  "unit": "g"
                },
                {
                  "description": "tomato stew",
                  "quantity": 500,
                  "unit": "ml"
                },
                {
                  "description": "pepper and salt",
                  "quantity": null,
                  "unit": null
                },
                {
                  "description": "medium onions",
                  "quantity": 2,
                  "unit": null
                },
                {
                  "description": "chicken",
                  "quantity": null,
                  "unit": null
                }
              ],
              "direction": [
                {
                  "description": "Cook the beans till it is tender and set aside."
                },
                {
                  "description": "Parboil the rice."
                },
                {
                  "description": "Prepare the tomato stew"
                },
                {
                  "description": "Cook the chicken till tender with the chopped onions, thyme and stock cubes."
                },
                {
                  "description": "Pour the chicken/fish stock into a pot big enough to accommodate the rice and beans, bearing in mind that the rice will rise some more."
                },
                {
                  "description": "Add the tomato stew, the parboiled rice and the cooked beans. Check that the water level is just less than the level of the rice and beans."
                },
                {
                  "description": "Add pepper and salt to taste."
                },
                {
                  "description": "Stir, cover the pot and cook at low to medium heat till the water is dry."
                },
                {
                  "description": "Put the chicken in a preheated oven at 200 degrees and allow to grill for 30 minutes"
                }
              ],
              "author": "eazy",
              "type": "FOOD",
              "imageUrl": "https://bit.ly/2Uj9zy4",
              "imageSource": null,
              "keto": false
            }
        

- POST `/api/get/recipe`
to retrieve recipe based on recipe name or ingredient which is enter as the body

    - ###### Example cURL request
    
            curl -X POST "http://127.0.0.1:8000/api/get/recipe" -H 
            "accept: application/json" -H 
            "X-AUTH-TOKEN: VALID_TOKEN" -H 
            "Content-Type: application/json" -d 
            "{ \"mealContent\": \"beans and rice and chicken\"}"

    - ###### Example json response
    
            {
                "name": "Rice and Beans with grilled chicken",
                "prep": 10,
                "cook": 240,
                "uuid": "fb09d733-be43-4ce3-a1df-e55796746738",
                "type": "FOOD",
                "imageUrl": "https://bit.ly/2Uj9zy4",
                "keto": false
              },

To get started, you need to follow a few steps:

## 1. Install Dependencies
As usual, we need to pull some dependencies through Composer.
Run composer install to install these dependencies

## 2. Run Migrations
To get the mysql database setup, run the migrations (using Doctrine for instance) found in the migrations folder.

## 3. Populate Datase with Test Data
To get you started, there are fixtures in the tests folder which you can run on the newly created table.

## 4. Generate token
There exist a command that generate a valid token. From your terminal run the command 
```
bin/console api:create:key
```
The generated key will be output in your terminal

Now you can make requests against the endpoints. If you are familiar with Swagger, `/api/doc` takes you to the UI

## Administrative duties
For Administrative duties you will have to create a user and assign an admin role to the user.
This can be done per terminal with the following command
-  To create a new user

        fos:user:create
- To assign the admin rights run the below command and when prompted to enter role enter ROLE_API_ADMIN

        fos:user:promote

Visiting `/admin` takes you to the login page