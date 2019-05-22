INSERT INTO recipe (id, uuid , name, prep, cook, created_at)
VALUES (1, 'fb09d733-be43-4ce3-a1df-e55796746738', 'Rice and Beans with grilled chicken', 10, 240, '2019-03-14'),
(2,'fb09d733-be43-4ce3-a1df-e55796746738', 'Rice and Beans with fried fish', 10, 240, '2019-03-14');


INSERT INTO  direction (id, recipe_id, description)
VALUES (1, 1, 'Cook the beans till it is tender and set aside.'),
(2, 1, 'Parboil the rice.'),
(3, 1, 'Prepare the tomato stew'),
(4, 1, 'Cook the chicken till tender with the chopped onions, thyme and stock cubes.'),
(5, 1, 'Pour the chicken/fish stock into a pot big enough to accommodate the rice and beans, bearing in mind that the rice will rise some more.'),
(6, 1, 'Add the tomato stew, the parboiled rice and the cooked beans. Check that the water level is just less than the level of the rice and beans.'),
(7, 1, 'Add pepper and salt to taste.'),
(8, 1, 'Stir, cover the pot and cook at low to medium heat till the water is dry.'),
(8, 1, 'Put the chicken in a preheated oven at 200 degrees and allow to grill for 30 minutes'),
(9, 2, 'Cook the beans till it is tender and set aside.'),
(10, 2, 'Parboil the rice.'),
(11, 2, 'Prepare the tomato stew'),
(12, 2, 'Cook the chicken till tender with the chopped onions, thyme and stock cubes.'),
(13, 2, 'Pour the chicken/fish stock into a pot big enough to accommodate the rice and beans, bearing in mind that the rice will rise some more.'),
(14, 2, 'Add the tomato stew, the parboiled rice and the cooked beans. Check that the water level is just less than the level of the rice and beans.'),
(15, 2, 'Add pepper and salt to taste.'),
(16, 2, 'Stir, cover the pot and cook at low to medium heat till the water is dry.'),
(17, 2, 'Put oil in a frying pan and heat for 1 minute. In the case a deep fryer is more suitable, then preheat at 150 degrees.'),
(18, 2, 'Put the fish in the preheated frying pan or deep fryer and fry for 3 minutes');

INSERT INTO ingredient (id, recipe_id, description, quantity, unit)
VALUES (1, 1,'long grain parboiled rice', 500, 'g'),
(2, 1, 'brown/black-eyed beans ', 250, 'g'),
(3, 1,'tomato stew', 500, 'ml'),
(4, 1,'pepper and salt', null, null),
(5, 1,'medium onions', 2, null),
(6, 1,'chicken', null, null),
(7, 1,'stock cubes', 2, null),
(8, 1,'thyme', 1, 'teaspoon'),
(9, 2,'long grain parboiled rice', 500, 'g'),
(10, 2, 'brown/black-eyed beans ', 250, 'g'),
(11, 2,'tomato stew', 500, 'ml'),
(12, 2,'pepper and salt', null, null),
(13, 2,'medium onions', 2, 'bulb'),
(14, 2,'fish', null, null),
(15, 2,'stock cubes', 2, null),
(16, 2,'thyme', 1, 'teaspoon');

