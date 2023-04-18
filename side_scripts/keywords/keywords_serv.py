from flask import Flask, request
import json
import gen_keywords

app = Flask(__name__)

@app.route('/')
def index():
	text = request.args.get("text")
	number = request.args.get("number")
	return json.dumps( gen_keywords.generate(text, int(number)) )

if __name__ == '__main__':
  app.run(debug=False)
