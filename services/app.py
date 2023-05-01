import json
import os

def get_path_to_project_root(path = "./"):
	for filename in os.listdir(path):
		if filename == "Fury":
			return path
	return get_path_to_project_root(path + "../")
	pass

def config():
	result = os.popen('cd ' + get_path_to_project_root() + ' && php console.php get.config').read()
	return json.loads(result)
	pass