import nltk
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
import pymorphy2
from langdetect import detect

nltk.download('wordnet')
nltk.download('punkt')
nltk.download('stopwords')
morph = pymorphy2.MorphAnalyzer()

def generate(text, count_keywords):
	tokens = word_tokenize(text)

	detected_lang = detect(text)

	if detected_lang == "ru" or detected_lang == "mk":
		lang = "russian"
	elif detected_lang == "uk":
		lang = "ukrainian"
	else: 
		lang = "english";

	stop_words = set(stopwords.words(lang))
	filtered_tokens = [word for word in tokens if word.lower() not in stop_words]
	lemmatized_tokens = [morph.parse(word)[0].normal_form for word in filtered_tokens]
	freq_dist = nltk.FreqDist(lemmatized_tokens)
	keys = freq_dist.most_common(count_keywords)

	return { 
		"keys": keys,
		"lang": lang
	}