#!/usr/bin/python

import socket
import sys
import os
import MySQLdb

#Connection to the required Database (Provenance Image)
conn = MySQLdb.connect (host = "localhost",
                           user = "root",
                           passwd = "",
                           db = "vcl")

serversocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
serversocket.bind(('192.168.50.1', 5555))
serversocket.listen(100)

#provsocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
#provsocket.connect(('127.0.0.1', 5555))

while True:
        (clientsocket, addr) = serversocket.accept()
        clientfile = clientsocket.makefile('r', 0)
	
	#Start a connection
	cursor = conn.cursor()

	qstr = "select R.imageid, L.id, R.id from reservation R, log L, request Req, computer C  where R.requestid = Req.id and Req.logid = L.id and R.computerid = C.id and C.privateIPaddress = \"%s\" and L.finalend > NOW();" % (clientsocket.getpeername()[0])
	cursor.execute(qstr);
        row = cursor.fetchone();
	print "IMG_ID=" + str(row[0])
	print "LOG_ID=" + str(row[1])
	print "RESERVATION_ID=" + str(row[2])
	cursor.close()
        for line in clientfile:
                print "%s" % (line),
                #provsocket.send(line)

        clientsocket.close()

conn.close()
#provsocket.close();

