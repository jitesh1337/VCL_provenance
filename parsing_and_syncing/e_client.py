#!/usr/bin/python

import socket
import sys
import os

if len(sys.argv) != 2:
        sys.exit("Provide the mn_id as command line argument!")

mn_id = int(sys.argv[1])

if mn_id == 1:
        addr = '192.168.40.2'
if mn_id == 2:
        addr = '192.168.5.2'
if mn_id == 3:
        addr = '192.168.60.2'

clientsocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

print addr
fsock = open('/tmp/output', 'w')
oldout = sys.stdout
sys.stdout = fsock

clientsocket.connect((addr, 5001))

clientsocket.send("GET")

clientfile=clientsocket.makefile('r',0)

for line in clientfile:
	print line,

sys.stdout=oldout
fsock.close()
	
clientsocket.close()

set_mn = sys.argv[1]
str = "python /root/VCL_provenance/parsing_and_syncing/parse.py " + set_mn
os.system(str)

