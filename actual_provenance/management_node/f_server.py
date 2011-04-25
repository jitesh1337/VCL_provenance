#!/usr/bin/python

import socket
import sys
import os
import MySQLdb
import commands

#Connection to the required Database (Provenance Image)
conn = MySQLdb.connect (host = "localhost",
                           user = "root",
                           passwd = "",
                           db = "vcl")

serversocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
serversocket.bind(('192.168.50.1', 5555))
serversocket.listen(100)

prov_addr=commands.getoutput("ifconfig gre1 | grep \"inet addr\" | awk '{print $2}' | cut -d ':' -f 2")
prov_addr=prov_addr.replace(".2", ".1");

while True:
        (clientsocket, addr) = serversocket.accept()
        clientfile = clientsocket.makefile('r', 0)

	provsocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
	provsocket.connect((prov_addr, 5000))

	if clientsocket.getpeername()[0] == '192.168.50.1':
		print "IMAGE_ID=" + "0"
		provsocket.send("IMAGE_ID=" + "0\n")
		print "LOG_ID=" + "0"
		provsocket.send("LOG_ID=" + "0\n")
		print "RESERVATION_ID=" + "0"
		provsocket.send("RESERVATION_ID=" + "0\n")
	else:
		#Start a connection
		cursor = conn.cursor()

		qstr = "select R.imageid, L.id, R.id from reservation R, log L, request Req, computer C  where R.requestid = Req.id and Req.logid = L.id and R.computerid = C.id and C.privateIPaddress = \"%s\" and L.finalend > NOW();" % (clientsocket.getpeername()[0])
		cursor.execute(qstr);
        	row = cursor.fetchone();
		print "IMAGE_ID=" + str(row[0])
		provsocket.send("IMAGE_ID=" + str(row[0]) + "\n")
		print "LOG_ID=" + str(row[1])
		provsocket.send("LOG_ID=" + str(row[1]) + "\n")
		print "RESERVATION_ID=" + str(row[2])
		provsocket.send("RESERVATION_ID=" + str(row[2]) + "\n")
		cursor.close()

        for line in clientfile:
                print "%s" % (line),
                provsocket.send("%s" % (line))

	provsocket.close();
        clientsocket.close()

conn.close()
