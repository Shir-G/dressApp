import time
from selenium import webdriver
from selenium.webdriver.common.by import By
#import MySQLdb
import sys
import pymysql.cursors

try:
    db = pymysql.connect(
        host = '188.121.44.180',
        user = 'dressapp',
        passwd = 'Dressapp1',
        db = 'dressapp'
        )
except Exception as e:
    sys.exit('cant get into database')

cursor = db.cursor()


def getProducts(url):
	driver = webdriver.Chrome()  # Optional argument, if not specified will search path.
	#categories
	driver.get(url);
	# items
	for element in driver.find_elements(By.XPATH, '//div[@class="pb_dropdown_submenu_option"]/a'):
		categoryUrl = element.get_attribute('href')
		cdriver = webdriver.Chrome()

		if categoryUrl == 'https://www.pullandbear.com/il/man/clothing/new-c29064.html':
			continue;
		if categoryUrl == 'https://www.pullandbear.com/il/man/clothing/coats-and-jackets-c1030009520.html':
			continue
		print("-----------------",categoryUrl)
		cdriver.get(categoryUrl);
		# items
		for element in cdriver.find_elements(By.XPATH, '//a[@class="grid_itemContainer"]'):
			try:
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
						index = src.index("_1_1_1")
						qr = src[(index-10):index]
						print(qr)
						print(src)
						break;
				category = driver.find_elements(By.XPATH, '//div[@id="Product_BreadcrumbsLink"]/a') 
				category = category[0].get_attribute('innerHTML')
				print(category)
				price = driver.find_elements(By.XPATH, '//div[@id="Product_PriceNew"]') 
				price = price[0].get_attribute('innerHTML')
				price = price[3:]
				print(price)
				try:	
					cursor.execute('INSERT INTO items3 (qr_code, item_type, price, image) VALUES ("%s", "%s", "%s", "%s") ON DUPLICATE KEY UPDATE price = "%s", item_type = "%s"'  % (qr, category, price, src, price, category))
				except Exception as e:
					print('Something wrong with query: ',e)
					db.ping(True)
					
				driver.close();
			except Exception as e:
				print('cant get the data from the page ',e)
		cdriver.close();
		continue
	driver.close();

#getProducts('https://www.pullandbear.com/il/man-c1010141504.html')
getProducts('https://www.pullandbear.com/il/woman/new-c1030017536.html')