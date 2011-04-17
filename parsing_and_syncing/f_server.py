#!/usr/bin/python

import socket
import sys

serversocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

serversocket.bind(('192.168.1.114', 5555))

serversocket.listen(1)

(clientsocket, addr) = serversocket.accept()
clientfile = clientsocket.makefile('r', 0)
	
while 1:
	line = clientfile.readline()
	if line == '':
		break
	print "%s" % (line)
clientsocket.close()

