#!/usr/bin/python

import sys
import MySQLdb
import os
import commands
import socket

def exec_query(query_str):
     cursor = conn.cursor ()
     cursor.execute (query_str)
     rows = cursor.fetchall ()

     for row in rows:
	  first = 0
	  output_str = ""
	  for field in row:
		if first != 0:
			output_str += "#"
		else:
			first = 1
		output_str += str(field).strip()
          clientsocket.send("%s\n" % output_str)
	  print output_str

     cursor.close()

try:
     conn = MySQLdb.connect (host = "localhost",
                             user = "root",
                             passwd = "",
                             db = "vcl")
except MySQLdb.Error, e:
     print "Error %d: %s" % (e.args[0], e.args[1])
     sys.exit (1)

#addr=commands.getoutput("ifconfig gre1 | grep \"inet addr\" | awk '{print $2}' | cut -d ':' -f 2")
addr="127.0.0.1"
serversocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
serversocket.bind((addr, 5001))
serversocket.listen(10)

while True:
	fsock = open('/tmp/output', 'w')
	oldout = sys.stdout
	sys.stdout = fsock

	(clientsocket, addr) = serversocket.accept()
	line = clientsocket.recv(4)
	if line != "GET":
		clientsocket.close()
		fsock.close()
		sys.stdout = oldout
		continue;

	# Read gre1 interface IP address
	f=commands.getoutput("ifconfig gre1 | grep \"inet addr\" | awk '{print $2}' | cut -d ':' -f 2")

	# Take information from the image table
	# fields: id, name, prettyname, lastupdate, datecreated
	print "Table#image#%s#5" % f
	clientsocket.send("Table#image#%s#5\n" % f)
	query_str="select I.id, I.name, I.prettyname, I.lastupdate, IR.datecreated from image I, imagerevision IR where I.id = IR.id order by I.id asc"
	exec_query(query_str)


	# Take information from the request table
	# fields: requestid, logid, start, end, daterequested 
	#f=commands.getoutput("ifconfig gre1 | grep \"inet addr\" | awk '{print $2}' | cut -d ':' -f 2")
	print "Table#request#%s#5" % f
	clientsocket.send("Table#request#%s#5\n" % f);
	query_str="select id as requestid, logid, start, end, daterequested from request order by requestid asc"
	exec_query(query_str)


	# Take information from the reservation table
	# fields: imageid, requestid, reservationid, managementnodeid, lastcheck 
	#f=commands.getoutput("ifconfig gre1 | grep \"inet addr\" | awk '{print $2}' | cut -d ':' -f 2")
	print "Table#reservation#%s#5" % f
	clientsocket.send("Table#reservation#%s#5\n" % f);
	query_str="select imageid, requestid, id as reservationid, managementnodeid, lastcheck from reservation order by imageid asc"
	exec_query(query_str)


	# Take information from the Log table
	# fields: logid, imageid, requestid, start, initialend, finalend
	#f=commands.getoutput("ifconfig gre1 | grep \"inet addr\" | awk '{print $2}' | cut -d ':' -f 2")
	print "Table#log#%s#6" % f
	clientsocket.send("Table#log#%s#6\n" % f);
	query_str="select id as logid, imageid, requestid, start, initialend, finalend from log order by logid asc"
	exec_query(query_str)


	# Take information from the computer table
	# fields: computerid, eth0macaddress, lastcheck, reservationid, timestamp, additionalinfo
	#f=commands.getoutput("ifconfig gre1 | grep \"inet addr\" | awk '{print $2}' | cut -d ':' -f 2")
	print "Table#computer#%s#5" % f
	clientsocket.send("Table#computer#%s#5\n" % f)
	query_str="select C.id as computerid, C.eth0macaddress, C.lastcheck, C.IPaddress, C.privateIPaddress from computer C order by C.id asc"
	exec_query(query_str);

	sys.stdout=oldout
	fsock.close()
	clientsocket.close();


serversocket.close();
conn.close()
