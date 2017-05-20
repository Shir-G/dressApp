import crawler
from flask import Flask
app = Flask(__name__)

@app.route("/")
def hello():
    crawler.getProducts('https://www.pullandbear.com/il/woman/new-c1030017536.html')
    crawler.getProducts('https://www.pullandbear.com/il/man-c1010141504.html')
	
if __name__ == "__main__":
    app.run()