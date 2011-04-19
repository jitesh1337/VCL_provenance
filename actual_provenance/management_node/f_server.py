#!/usr/bin/python

import socket
import sys
import os

serversocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
serversocket.bind(('127.0.0.1', 5555))
serversocket.listen(100)

#provsocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
#provsocket.connect(('127.0.0.1', 5555))

while True:
	(clientsocket, addr) = serversocket.accept()
	clientfile = clientsocket.makefile('r', 0)
	
	for line in clientfile:
		#print "%s" % (line)
		provsocket.send(line)
	clientsocket.close()

#provsocket.close();
