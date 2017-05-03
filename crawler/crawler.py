import time
from selenium import webdriver
from selenium.webdriver.common.by import By


def getProducts(url):
	driver = webdriver.Chrome()  # Optional argument, if not specified will search path.
	#categories
	driver.get(url);
	# items
	for element in driver.find_elements(By.XPATH, '//div[@class="pb_dropdown_submenu_option"]/a'):
		categoryUrl = element.get_attribute('href')
		driver.get(categoryUrl);
		# items
		for element in driver.find_elements(By.XPATH, '//a[@class="grid_itemContainer"]'):
			href = element.get_attribute('href')
			driver = webdriver.Chrome()  
			driver.get(href)
			for div in driver.find_elements(By.XPATH, '//div[@id="Product_ImagesContainer"]'):	
				for img in div.find_elements(By.XPATH, 'img'):		
					src = img.get_attribute('src');			
					index = src.index(".jpg")
					src = src[:index-1] + "1" + src[index:]
					src = src[:index-3] + "1" + src[index-2:]
					src = src[:index-5] + "1" + src[index-4:]
					print(src)
					break;
			category = driver.find_elements(By.XPATH, '//div[@id="Product_BreadcrumbsLink"]/a') 
			category = category[0]
			print(category.get_attribute('innerHTML'))
			price = driver.find_elements(By.XPATH, '//div[@id="Product_PriceNew"]') 
			price = price[0]
			print(price.get_attribute('innerHTML'))
			driver.close();
	driver.close();




# http://stackoverflow.com/questions/372885/how-do-i-connect-to-a-mysql-database-in-python
# #!/usr/bin/python
# import MySQLdb

# db = MySQLdb.connect(host="localhost",    # your host, usually localhost
#                      user="john",         # your username
#                      passwd="megajonhy",  # your password
#                      db="jonhydb")        # name of the data base

# # you must create a Cursor object. It will let
# #  you execute all the queries you need
# cur = db.cursor()

# # Use all the SQL you like
# cur.execute("SELECT * FROM YOUR_TABLE_NAME")

# # print all the first cell of all the rows
# for row in cur.fetchall():
#     print row[0]

# db.close()
