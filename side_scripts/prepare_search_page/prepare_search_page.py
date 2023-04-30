import mysql.connector
import nltk
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
import pymorphy2
import math
from langdetect import detect
import sys
sys.path.append("../")
import app

nltk.download('wordnet')
nltk.download('punkt')
nltk.download('stopwords')
morph = pymorphy2.MorphAnalyzer()

keywords = []
addition_data = []

app_config = app.config()
db = mysql.connector.connect(
	host = app_config["db"]["host"],
	user = app_config["db"]["user"],
	password = app_config["db"]["password"],
	database = app_config["db"]["dbname"]
)

cursor = db.cursor(dictionary=True)

def get_keywords_from_search_query(sq, lang):
	tokens = word_tokenize(sq)
	stop_words = set(stopwords.words(lang))
	filtered_tokens = [word for word in tokens if word.lower() not in stop_words]
	lemmatized_tokens = [morph.parse(word)[0].normal_form for word in filtered_tokens]
	return lemmatized_tokens

def group_by_uap(sresult):
	groups = {}
	for item in sresult:
		if not item["uap_id"] in groups.keys():
			groups[item["uap_id"]] = [ item ]
		else:
			groups[item["uap_id"]].append(item)

	return groups
	pass

def sort_by_relevant(groups):
	points = {}
	for i in groups:
		points[i] = 0;
		for item in groups[i]:
			points[i] = points[i] + item["freq"]
		points[i] = points[i] * len(groups[i])

	points = { k: v for k, v in sorted(points.items(), key = lambda item: item[1], reverse = True) }
	results = [ groups[uap_id] for uap_id in points ]

	return results
	pass

def groups_to_pages(groups, per_page):
	pages = [[]]
	i = 0
	for group in groups:
		if len(pages[i]) == per_page - 1:
			i = i + 1
			pages.append([])
		pages[i].append(group)
	return pages
	pass

def get_items_from_groups(groups):
	return [ g[0]["uap_id"] for g in groups ]
	pass

def data_enrichment(items):
	global addition_data

	results = {}
	addition_data_keys = addition_data.keys()
	for uap_id in items:
		if uap_id in addition_data_keys:
			results[uap_id] = addition_data[uap_id]
		else:
			results[uap_id] = addition_data[uap_id]
		
	return results
	pass

def filter_by_price(items, from_val, to_val):
	result = {}
	for uap_id in items.keys():
		if items[uap_id]["single_price"] >= from_val and items[uap_id]["single_price"] <= to_val:
			result[uap_id] = items[uap_id]
	return result
	pass

def filter_by_condition(items, condition):
	print("CONDITION: " + str(condition))
	result = {}
	for uap_id in items.keys():
		if items[uap_id]["condition_used"] == condition:
			result[uap_id] = items[uap_id]
	return result
	pass

def query(sq, filters):
	global keywords

	if len(sq):
		detected_lang = detect(sq)
	else:
		detected_lang = "english"

	if detected_lang == "ru" or detected_lang == "mk":
		lang = "russian"
	elif detected_lang == "uk":
		lang = "ukrainian"
	else: 
		lang = "english";

	keys = get_keywords_from_search_query(sq, lang)

	sresult = []
	if not len(keys):
		sresult = keywords

	for keyword in keywords:
		if keyword["keyword"] in keys:
			sresult.append(keyword)

	groups = group_by_uap(sresult)
	groups = sort_by_relevant(groups)
	items = get_items_from_groups(groups)
	items = data_enrichment(items)

	if "price" in filters:
		items = filter_by_price(items, filters["price"]["from"], filters["price"]["to"])

	if "condition" in filters and filters["condition"] in [1, 2]:
		items = filter_by_condition(items, filters["condition"])

	return {
		"uaps": list(items.keys()),
		"lang": lang
	}

def load_keywords():
	global keywords, addition_data
	print("Init keywords")
	cursor.execute("SELECT * FROM `uadposts_keywords`")
	keywords = cursor.fetchall()

	print("Init uadposts data")
	cursor.execute("SELECT `id`, `single_price`, `condition_used` FROM `uadposts`")
	addition_data = { item["id"]: item for item in cursor.fetchall() }
	return len(keywords)