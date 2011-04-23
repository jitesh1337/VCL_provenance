import socket
import sys
import time

clientsocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
while 1:
        fp = open("parse_sar_output","r")
        clientsocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        clientsocket.connect(('192.168.50.1', 5555))
        while 1:
                line = fp.readline()
                if line.strip() == "END":
                        break;
                if line == '':
                        break;
                #print line,
                clientsocket.send(line)
        clientsocket.close()
        fp.close()
        time.sleep(1)
