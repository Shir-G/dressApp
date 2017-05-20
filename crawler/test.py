import MySQLdb
import sys

try:
    db = MySQLdb.connect(
        host = '188.121.44.180',
        user = 'dressapp',
        passwd = 'Dressapp1',
        db = 'dressapp'
        )
except Exception as e:
    sys.exit('cant get into database')

name = "alejandro"
passw = "222"
cursor = db.cursor()
#cursor.execute('SELECT * FROM  users2')
#cursor.execute('INSERT INTO users2 (username, password, email, hash) VALUES ("%s", "123", "email", "%s") ON DUPLICATE KEY UPDATE hash = "%s"'  % (name ,passw,passw))
# qr = "qr"
# price = "123"
# src = "src"
# category = "category"
# store = "store"
#cursor.execute('INSERT INTO items3 (item_id, qr_code, item_type, price, store, image) VALUES (NULL, "code", "type", "price", "store", "image");')
try:
    cursor.execute('INSERT INTO items3 (qr_code, item_type, price, image) VALUES ("%s", "%s", "%s", "%s") ON DUPLICATE KEY UPDATE price = "%s"'  % (qr, category, price, src, price))
except Exception as e:
    sys.exit('nope')
# result = cursor.fetchall()

# if result:
#     for row in result:
#         print row[1]