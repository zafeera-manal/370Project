
INSERT INTO workout_plan_1(`plan_id`, `video_name`, `wp_videos`) VALUES
(1, '10 min abs workout', 'https://shorturl.at/dglNS'),
(1, '11 line abs workout', 'https://shorturl.at/zJO03'),
(2, '20 min cardio', 'https://tinyurl.com/wm35fmph'),
(2, '30 min cardio\r\n', 'https://tinyurl.com/mrxsu2dj'),
(2, '30 min HIIT\r\n', 'https://tinyurl.com/yzk27fym'),
(1, 'Lower abs workout ', 'https://shorturl.at/cmp89'),
(1, 'standing abs workout', 'https://shorturl.at/esRUX');



INSERT INTO inventory(`equipment_name`, `quantity`) VALUES
('Battle rope', 1),
('Bicycle', 1),
('Fitness ball', 2),
('Treadmill', 1);


INSERT INTO daily_challenges (dc_id, challenge_name, dc_links) VALUES
(1, 'Belly Burn Workout   ', 'https://shorturl.at/vxTU4'),
(2, 'Core Burn Workout    ', 'https://shorturl.at/abvN3'),
(3, 'Abs Workout          ', 'https://shorturl.at/pzPX7'),
(4, 'Sugar Burn Workout   ', 'https://shorturl.at/mwJX2'),
(5, 'Jogging              ', 'https://shorturl.at/hCPY9'),
(6, 'Improve Growth       ', 'https://rb.gy/401lnw'),
(7, 'Indoor Walking Exercise  ', 'https://rb.gy/bmnme3'),
(8, 'Stretching           ', 'https://rb.gy/sju6ev'),
(9, 'Boost Immune System  ', 'https://rb.gy/7vi5h2'),
(10, 'Improve Back         ', 'https://shorturl.at/bdnxD'),
(11, 'Improve Shoulder     ', 'https://shorturl.at/aiG89'),
(12, 'Full Body Workout    ', 'https://shorturl.at/gP478');

INSERT INTO `workout_plan_2` (`SN`, `article_links`, `meal_plan`, `plan_id`) VALUES
(1, NULL, 'Diet Chart for weight loss\r\n\r\n\r\nDay 1: Fruit Diet \r\nAdequate amount of low sugar and nutrient rich foods and natural fruit juice\r\n\r\n\r\n', 1),
(2, 'https://www.healthline.com/nutrition/most-weight-loss-friendly-foods\r\n', 'Day 2:Vegetable Diet \r\nFiber rich vegetables and green leafy vegetables,as broccoli, carrots, beans. Boiled vegetables can be taken \r\n\r\n', 1),
(3, NULL, 'Day 3:Fruit and Vegetable Diet \r\nA balanced diet of fruits and vegetables. Fruit juice and vegetable soup are good sources for fluids. \r\n\r\n\r\n', 1),
(4, 'https://www.mayoclinic.org/healthy-lifestyle/weight-loss/in-depth/hlv-20049483', 'Day 4: Bananas and Milk Diet \r\nBananas and milk are very nutrient rich. Milk is an ideal food, which can fulfill need of all nutritional elements.\r\n\r\n\r\n\r\n', 1),
(5, NULL, 'Day 5: Meat Diet \r\nMeats are essential for protien. It can also be substituted by fish. Red meat and fried or spicy meats should be avoided. \r\n\r\n', 1),
(6, NULL, 'Day 6: Meat and Vegetable Diet \r\nMeat and vegetable should be taken in adequate amount to fulfill the needs of protein and vitamin,mineral-nutrients.\r\n', 1),
(7, NULL, 'Day 7: Fruit and vegetable Diet\r\nDiet of fruits and vegetables. Fruit juice, vegetable soup,boiled vegetables should be included in the diet for change of taste.\r\n\r\n', 1),
(8, 'https://www.news-medical.net/news/20230511/Healthier-diets-may-lead-to-greater-physical-fitness.aspx\r\n', 'Diet Chart For Weight Gain\r\n\r\nDay 1:\r\nBreakfast: 2 egg brown bread sandwich,1 cup milk, nuts\r\nMid meal: 1 cup banana shake\r\nLunch: 1 cup pulse,1 cup potato curry,3 chapatti,1/2 cup rice,1/2 cup low fat curd,salad\r\nEvening: 1 cup strawberry smoothie, 1 cup vegetable\r\nDinner: 1.5 cup chicken curry,3 chapatti,salad\r\n\r\n', 2),
(9, 'https://www.news-medical.net/health/Mediterranean-Diet.aspx\r\n', 'Day 2:\r\nBreakfast: 3 onion stuffed paratha, 1 cup curd,3 cashews,4 almonds, 2 walnuts\r\nMid-Meal: 1 cup mango shake\r\nLunch: 1 cup pulse/chicken curry, 1 cup potato and cauliflower,3 flat bread, cup rice, salad\r\nEvening: 1 cup pomegranate juice, 2 butter toasted bread\r\nDinner: 1 cup beans/potato, 3 flat bread, salad\r\n\r\n', 2),
(10, 'https://www.news-medical.net/health/What-are-the-Health-Benefits-of-a-Vegan-Diet.aspx', 'Day 3:\r\nBreakfast: 3 cheese stuffed rice cake, green chutney,1 cup curd,3 cashews,4 almonds,2 walnuts\r\nMid-Meal: 1 apple smoothie with maple syrup\r\nLunch: 1 cup pulse,3 flat bread, 1/2 cup rice, 1 cup curd, salad\r\nEvening: 1 cup tomato soup with bread crumbs, 1 cup potato\r\nDinner: 1 cup vegetable,3 flat bread, salad\r\n\r\n', 2),
(11, NULL, 'Day 4:\r\nBreakfast: 1.5 cup vegetable with rice, 1 cup milk,3 cashews,4 almonds, 2 walnuts\r\nMid-Meal: 1 cup ripe banana with 2 tsp ghee\r\nLunch: 1 cup beans curry,1 cup spinach potato, 3 flat bread ,1/2 cup rice,salad\r\nEvening: 1 cup vegetable soup,1 cup rice cake\r\nDinner: 1.5 cup sauteed vegetable, 3 flat bread, salad\r\n\r\n', 2),
(12, NULL, 'Day 5:\r\nBreakfast: 2 cucumber potato sandwich, 1 tsp green chutney, 1 orange juice, 3 cashews, 2 walnuts, 4 almonds\r\nMid-Meal: 1 cup buttermilk + 1 cup sweet potato\r\nLunch: 1 cup fish curry, 3 flat bread, 1/2 cup rice, salad\r\nEvening: 1 cup almond milk, banana\r\nDinner: 1 cup cauliflower and potato, 3 flat bread, salad\r\n\r\n\r\n', 2),
(13, NULL, 'Day 6:\r\nBreakfast: 2 cup flattened rice with milk, 1 cup curd, 3 cashews, 4 almonds, 2 walnuts\r\nMid-Meal: 2 cups watermelon juice\r\nLunch: 1 cup pulse, 1 cup okra, 3 flat bread,1/2 cup rice,salad\r\nEvening: 1 cup sprouts salad,2 potato, green chutney\r\nDinner: 1 cup peas and mushroom vegetable,3 flat bread, salad\r\n\r\n', 2),
(14, NULL, 'Day 7:\r\nBreakfast: 3 vegetable ricecake, 1 cup strawberry shake, 4 cashews, 4 almonds, 3 walnuts\r\nMid-Meal: 1 cup coconut water, 1 cup pomegranate\r\nLunch: 1 cup pulse, 1 cup soybean curry, 3 flat bread, 1/2 cup curd, salad\r\nEvening: 1 cup fruit salad, 4 vegetable cutlets, green chutney\r\nDinner: 1 cup vegetable, 3 flat bread, salad\r\n\r\n', 2);