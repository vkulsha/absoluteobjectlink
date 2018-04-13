#from mysql.connector import MySQLConnection, Error
import pymysql.cursors
from dbconf import get_db_conf
 
def connect():
	db_config = get_db_conf()
	query = "select id, n from object order by id limit 10"

	try:
		connection = pymysql.connect(host='192.168.5.134',
			user='root',
			password='1234',
			db='simplehr',
			charset='utf8',
			cursorclass=pymysql.cursors.DictCursor)
			
		#conn = MySQLConnection(**db_config)

		#if not conn.is_connected():
		#	print('connection failed.')

		cursor = conn.cursor()
		cursor.execute(query)
		#row = cursor.fetchone()
		row = cursor.fetchall()

		#while row is not None:
		#	print(row)
		#	row = cursor.fetchone()		
		return row
		
	except Error as error:
		print(error)

	finally:
		conn.close()
		#print('Connection closed.')
