#!/usr/bin/python

import socket
import sys

clientsocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
clientsocket.connect(('127.0.0.1', 5555))

#while True:
fp = open("parse_sar_output","r")
for line in fp:
	#print line
	clientsocket.send(line)
fp.close()

clientsocket.close()

