#!python.exe

import os
import cgitb
import dbconn
cgitb.enable()

print("Content-Type: text/html;charset=utf-8")
print()

#for param in os.environ.keys():
#   print ("<b>%20s</b>: %s </br>" % (param, os.environ[param]))
   
print(os.environ["QUERY_STRING"].split("&"),"<br>")
ret = dbconn.connect()

for line in ret:
	print(line,"<br>")