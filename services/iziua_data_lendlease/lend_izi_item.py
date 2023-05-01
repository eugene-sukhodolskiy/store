import requests
import json
import sys
import os

url = sys.argv[1];
print("Load " + str(url))
response = requests.get(url, timeout=10)

json_data = str(str(str(response.content.decode("utf-8")).split('<script type="application/ld+json">')[1]).split("</script>")[0])
json_data = '{"@context"' + str(json_data.split('{"@context"')[1])
json_data = json_data.strip()
data = json.loads(json_data);

item = {
	"title": data["name"],
	"description": data["description"],
	"image": data["image"][0],
	"price": data["offers"]["price"],
	"currency": data["offers"]["priceCurrency"]
}

json_item_data = json.dumps(item)
print("Trying adding uadpost from data")
os.system("cd ../../ && php console.php create.uadpost '" + str(json_item_data) + "'")