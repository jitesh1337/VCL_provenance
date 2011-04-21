#!/usr/bin/python

import socket
import sys

if len(sys.argv) != 2:
        sys.exit("Provide the mn_id as command line argument!")

mn_id = int(sys.argv[1])

if mn_id == 1:
        addr = '192.168.40.1'
if mn_id == 2:
        addr = '192.168.5.1'
if mn_id == 3:
        addr = '192.168.60.1'

clientsocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

print addr
clientsocket.connect((addr, 5000))

fp = open("/tmp/dyn_logfile","r")

while True:
        line = fp.readline()

        if len(line) == 0:
                break
	
	clientsocket.send(line)

clientsocket.close()

