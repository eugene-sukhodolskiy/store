import gen_keywords
import argparse
import json

parser = argparse.ArgumentParser(description='Генерация ключевых слов из текста')
parser.add_argument('text', help='Текст для генерации ключевых слов')
parser.add_argument('number', type=int, help='Максимальное число ключевых слов')
args = parser.parse_args()

print( "Result:" + str(json.dumps(gen_keywords.generate( args.text, args.number ))) )
