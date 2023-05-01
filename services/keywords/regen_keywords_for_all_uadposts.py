import mysql.connector
import json
import requests
import sys
import time
sys.path.append("services")
import app

# CONFIG
regen_req_url = "http://store.local/uadpost/f/regenerate-keywords/$uadpost_alias"
size_of_pack = 10
app_config = app.config()
# END OF CONFIG

db = None
cursor = None

def get_cursor(db_conf):
	global db, cursor
	db = mysql.connector.connect(
		host = db_conf["host"],
		user = db_conf["user"],
		password = db_conf["password"],
		database = db_conf["dbname"]
	)

	if db.is_connected():
		cursor = db.cursor(dictionary = True)
		return cursor
	else:
		print("Error of connect to db")
		exit()
	pass

def get_total_uadposts(cursor):
	cursor.execute("SELECT COUNT(*) FROM `uadposts`")
	result = cursor.fetchone()
	return result["COUNT(*)"]
	pass

def get_absolute_last_uadpost_id(cursor):
	cursor.execute("SELECT `id` FROM `uadposts` ORDER BY `id` DESC LIMIT 1")
	result = cursor.fetchone()
	return result["id"]
	pass

def uadpost_info_part_msg(uadpost):
	return "ID" + str(uadpost["id"]) + " [" + uadpost["alias"] + "]"
	pass

def show_err_msg(uadpost):
	print("Failed regenerate keywords for uadpost " + uadpost_info_part_msg(uadpost))
	pass

def show_success_msg(uadpost, response):
	print("Success uadpost with " + uadpost_info_part_msg(uadpost) + " - " + str(len(response["keywords"]["keys"])))
	pass

def regen_uadposts_pack(cursor, size_of_pack, last_id):
	query = "SELECT `id`, `alias` FROM `uadposts` WHERE `id` < '" + str(last_id) + "' ORDER BY `id` DESC LIMIT " + str(size_of_pack)
	cursor.execute(query)
	uadposts = cursor.fetchall()
	
	for uadpost in uadposts:
		start_time = time.perf_counter()
		response = requests.get(regen_req_url.replace("$uadpost_alias", uadpost["alias"]))
		if not response:
			show_err_msg(uadpost)
		else:
			response = json.loads(response.text)
			if not response["status"]:
				show_err_msg(uadpost)
			else:
				show_success_msg(uadpost, response["data"])
		end_time = time.perf_counter()
		execution_time = end_time - start_time
		print("Executed {:.2f}s".format(execution_time))
	
	return uadposts[-1]["id"]
	pass


# SCRIPT
cursor = get_cursor(app_config["db"])
last_id = get_absolute_last_uadpost_id(cursor)
total = get_total_uadposts(cursor)

print("Starting keywords regeneration...")
print("Total uadposts " + str(total)) 
print("Number of uadposts in one pack " + str(size_of_pack))

part_counter = 0
while total > part_counter * size_of_pack:
	print("#" + str(part_counter) + " pack starting")
	last_id = regen_uadposts_pack(cursor, size_of_pack, last_id)
	print("#" + str(part_counter) + " pack finished")
	part_counter += 1
	pass