import crawler
from flask import Flask
app = Flask(__name__)

@app.route("/")
def hello():
	crawler.getProducts('https://www.pullandbear.com/il/man-c1010141504.html')
	crawler.getProducts('https://www.pullandbear.com/il/woman/new-c1030017536.html')
	
if __name__ == "__main__":
    app.run()



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
