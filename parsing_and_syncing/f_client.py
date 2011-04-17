#!/usr/bin/python

import socket
import sys

clientsocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

clientsocket.connect(('192.168.1.114', 5555))

fp = open("/tmp/output","r")

while True:
        line = fp.readline()

        if len(line) == 0:
                break
	
	clientsocket.send(line)

clientsocket.close()

