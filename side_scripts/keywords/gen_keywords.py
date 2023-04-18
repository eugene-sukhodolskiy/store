import nltk
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
from nltk.stem import WordNetLemmatizer
import pymorphy2
from langid.langid import LanguageIdentifier, model

nltk.download('wordnet')
nltk.download('punkt')
nltk.download('stopwords')
morph = pymorphy2.MorphAnalyzer()

def generate(text, count_keywords):
	tokens = word_tokenize(text)

	identifier = LanguageIdentifier.from_modelstring(model, norm_probs=True)
	detected_lang = identifier.classify(text)

	if detected_lang[0] == "ru":
		lang = "russian"
	elif detected_lang[0] == "uk":
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