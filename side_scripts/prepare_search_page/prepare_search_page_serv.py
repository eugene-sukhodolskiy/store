from flask import Flask, request
import json
import prepare_search_page as psp

app = Flask(__name__)
psp.load_keywords()

@app.route('/search')
def search():
	sq = request.args.get("sq")
	filters = request.args.get("filters")

	result = psp.query(sq, json.loads(filters))
	return json.dumps({
		"result": result
	})

@app.route('/keywords-reload')
def keywords_reload():
	return json.dumps({
		"result": psp.load_keywords()
	})

if __name__ == '__main__':
  app.run(debug=True, port=5001)