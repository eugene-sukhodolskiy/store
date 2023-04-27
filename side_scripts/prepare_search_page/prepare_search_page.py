import mysql.connector
import nltk
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
import pymorphy2
import math
from langdetect import detect

nltk.download('wordnet')
nltk.download('punkt')
nltk.download('stopwords')
morph = pymorphy2.MorphAnalyzer()

keywords = []

db = mysql.connector.connect(
	host="localhost",
	user="eugene",
	password="root",
	database="store"
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

	points = {k: v for k, v in sorted(points.items(), key=lambda item: item[1], reverse=True)}
	results = [groups[uap_id] for uap_id in points]

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

def query(sq):
	global keywords

	detected_lang = detect(sq)

	if detected_lang == "ru" or detected_lang == "mk":
		lang = "russian"
	elif detected_lang == "uk":
		lang = "ukrainian"
	else: 
		lang = "english";

	keys = get_keywords_from_search_query(sq, lang)

	sresult = []
	for keyword in keywords:
		if keyword["keyword"] in keys:
			sresult.append(keyword)

	groups = group_by_uap(sresult)
	groups = sort_by_relevant(groups)
	items = get_items_from_groups(groups)

	return {
		"uaps": items,
		"lang": lang
	}

def load_keywords():
	global keywords
	cursor.execute("SELECT * FROM `uadposts_keywords`")
	keywords = cursor.fetchall()
	return len(keywords)