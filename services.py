import subprocess
from multiprocessing import Process, Queue

def read_output(process, queue):
	for line in iter(process.stdout.readline, b''):
		queue.put(line)

def start_process(args):
	process = subprocess.Popen(args, stdout=subprocess.PIPE, stderr=subprocess.STDOUT, text=True)
	return process

if __name__ == '__main__':
	queue1 = Queue()
	queue2 = Queue()

	# Prepare Search Results
	process1 = start_process(["python3", "services/prepare_search_page/prepare_search_page_serv.py"])

	process2 = start_process(["python3", "services/keywords/keywords_serv.py"])

	p1 = Process(target=read_output, args=(process1, queue1))
	p1.start()

	p2 = Process(target=read_output, args=(process2, queue2))
	p2.start()

	while True:
		if not p1.is_alive() and not p2.is_alive():
			break
		while not queue1.empty():
			print(f"{queue1.get()}", end="")
		while not queue2.empty():
			print(f"{queue2.get()}", end="")
