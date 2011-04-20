#!/usr/bin/python

import sys
import MySQLdb
import os
import commands

try:
     conn = MySQLdb.connect (host = "localhost",
                             user = "root",
                             passwd = "",
                             db = "vcl")
except MySQLdb.Error, e:
     print "Error %d: %s" % (e.args[0], e.args[1])
     sys.exit (1)

oldout = sys.stdout
fsock = open('/tmp/output', 'w')
sys.stdout = fsock

# Take information from the image table
# fields: id, name, prettyname, lastupdate, datecreated
f=commands.getoutput("ifconfig gre1 | grep \"inet addr\" | awk '{print $2}' | cut -d ':' -f 2")
print "Table#image#%s#5" % f

query_str="select I.id, I.name, I.prettyname, I.lastupdate, IR.datecreated from image I, imagerevision IR where I.id = IR.id order by I.id asc"
try:
     cursor = conn.cursor ()
     cursor.execute (query_str)
     rows = cursor.fetchall ()
     for row in rows:
       print "%d#%s#%s#%s#%s" % (row[0], row[1], row[2], row[3], row[4])

     cursor.close()

except MySQLdb.Error, e:
     print "Error %d: %s" % (e.args[0], e.args[1])
     sys.exit (1)

# Take information from the reservation table
# fields: imageid, requestid, reservationid, managementnodeid, lastcheck 
f=commands.getoutput("ifconfig gre1 | grep \"inet addr\" | awk '{print $2}' | cut -d ':' -f 2")
print "Table#reservation#%s#5" % f

query_str="select imageid, requestid, id as reservationid, managementnodeid, lastcheck from reservation order by imageid asc"
try:
     cursor = conn.cursor ()
     cursor.execute (query_str)
     rows = cursor.fetchall ()

     for row in rows:
          print "%d#%d#%d#%d#%s" % (row[0], row[1], row[2], row[3], row[4])

     cursor.close()

except MySQLdb.Error, e:
     print "Error %d: %s" % (e.args[0], e.args[1])
     sys.exit (1)

# Take information from the request table
# fields: requestid, logid, start, end, daterequested 
f=commands.getoutput("ifconfig gre1 | grep \"inet addr\" | awk '{print $2}' | cut -d ':' -f 2")
print "Table#request#%s#5" % f

query_str="select id as requestid, logid, start, end, daterequested from request order by requestid asc"
try:
     cursor = conn.cursor ()
     cursor.execute (query_str)
     rows = cursor.fetchall ()

     for row in rows:
          print "%d#%d#%s#%s#%s" % (row[0], row[1], row[2], row[3], row[4])

     cursor.close()

except MySQLdb.Error, e:
     print "Error %d: %s" % (e.args[0], e.args[1])
     sys.exit (1)

# Take information from the Log table
# fields: logid, imageid, requestid, start, initialend, finalend
f=commands.getoutput("ifconfig gre1 | grep \"inet addr\" | awk '{print $2}' | cut -d ':' -f 2")
print "Table#log#%s#6" % f

query_str="select id as logid, imageid, requestid, start, initialend, finalend from log order by logid asc"
try:
     cursor = conn.cursor ()
     cursor.execute (query_str)
     rows = cursor.fetchall ()

     for row in rows:
          print "%d#%d#%d#%s#%s#%s" % (row[0], row[1], row[2], row[3], row[4], row[5])

     cursor.close()

except MySQLdb.Error, e:
     print "Error %d: %s" % (e.args[0], e.args[1])
     sys.exit (1)

# Take information from the computer table
# fields: computerid, eth0macaddress, lastcheck, reservationid, timestamp, additionalinfo
f=commands.getoutput("ifconfig gre1 | grep \"inet addr\" | awk '{print $2}' | cut -d ':' -f 2")
print "Table#computer#%s#6" % f

query_str="select C.id as computerid, C.eth0macaddress, C.lastcheck, CL.reservationid, CL.timestamp, CL.additionalinfo from computer C, computerloadlog CL where C.id = CL.computerid order by C.id asc"
try:
     cursor = conn.cursor ()
     cursor.execute (query_str)
     rows = cursor.fetchall ()

     for row in rows:
          print "%d#%s#%s#%d#%s#%s" % (row[0], row[1], row[2], row[3], row[4], row[5])

     cursor.close()

except MySQLdb.Error, e:
     print "Error %d: %s" % (e.args[0], e.args[1])
     sys.exit (1)

sys.stdout=oldout
fsock.close()
conn.close()
