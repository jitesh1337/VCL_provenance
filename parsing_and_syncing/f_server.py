#!/usr/bin/python

import socket
import sys
import math
import os

if len(sys.argv) != 2:
	sys.exit("Provide the mn_id as command line argument!")

mn_id = int(sys.argv[1])

if mn_id == 1:
	addr = "192.168.40.1"
if mn_id == 2:
	addr = "192.168.5.1"
if mn_id == 3:
	addr = "192.168.60.1"

serversocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

serversocket.bind((addr, 5000))

serversocket.listen(1)

while 1:
	oldout = sys.stdout
	fsock = open('/tmp/dyn_logfile', 'w')
	sys.stdout = fsock

	(clientsocket, addr) = serversocket.accept()
	clientfile = clientsocket.makefile('r', 0)
	
	while 1:
		line = clientfile.readline()
		if line == '':
			break
		line_1 = line.split("\n")
		print "%s" % (line_1[0])

	clientsocket.close()

	sys.stdout = oldout
	fsock.close()

	set_mn = sys.argv[1]
	str = "python /root/VCL_provenance/parsing_and_syncing/dyn_parse.py " + set_mn + " /tmp/dyn_logfile"
	os.system(str)

