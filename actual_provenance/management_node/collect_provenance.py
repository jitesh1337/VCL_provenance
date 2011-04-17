#!/usr/bin/python
import MySQLdb
#Connection to the required Database (Provenance Image)
conn = MySQLdb.connect (host = "localhost",
                           user = "root",
                           passwd = "",
                           db = "vcl")
#Start a connection
cursor = conn.cursor ()
cursor.execute("SELECT computer.IPaddress,reservation.remoteIP FROM reservation,computer where reservation.computerid=computer.id");

while (1):
        row = cursor.fetchone();
        if row == None:
                break;

        # The reservation is being provisioned or destroyed
        if row[1] != None:
                print row[0]

cursor.close ()
conn.close ()
