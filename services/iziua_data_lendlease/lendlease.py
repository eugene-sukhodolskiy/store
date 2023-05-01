import requests
import json
import sys
import xml.etree.ElementTree as ET
import os

url = sys.argv[1];
response = requests.get(url, timeout=30)
xml = response.content.decode("utf-8")

root = ET.fromstring(xml)

urls = []
with open("used_urls.json", "r") as f:
	used_urls = json.load(f)

for child in root:
	for grandchild in child:
		if("https" in grandchild.text):
			urls.append(grandchild.text)
		
for url in urls:
	if not url in used_urls:
		used_urls.append(url)
		with open("used_urls.json", "w") as f:
			json.dump(used_urls, f)
		os.system("python3 lend_izi_item.py " + str(url))