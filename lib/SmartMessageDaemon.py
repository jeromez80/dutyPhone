#!/usr/bin/env python

import logging, time, MySQLdb, ConfigParser
import logging.handlers
from lib.daemon import Daemon

class SmartMessageDaemon(Daemon):
	def run(self):
		my_logger = logging.getLogger('MyLogger')
		my_logger.setLevel(logging.DEBUG)

		handler = logging.handlers.SysLogHandler(address = '/dev/log')
		my_logger.addHandler(handler)

		#my_logger.debug('this is debug')
		#my_logger.critical('this is critical')

		my_logger.info('SmartMessage starting up...')
		dConfig = ConfigParser.ConfigParser()
		dConfig.read("/etc/SmartMessage.conf")
		DBHOST = dConfig.get('DB', 'DBHost')
		DBUSER = dConfig.get('DB', 'DBUser')
		DBPASS = dConfig.get('DB', 'DBPass')
		DBNAME = dConfig.get('DB', 'DBName')
		my_logger.info('Loaded DB settings @ '+DBHOST)

		while True:
			try:
				db = MySQLdb.connect(host=DBHOST, user=DBUSER, passwd=DBPASS, db=DBNAME)  
			except:
				my_logger.critical('DB Connect error. Please check your config file.')
				sys.exit(2)
		        SQLCur = db.cursor()
		        SQLCur.execute("SELECT `Config_Value` FROM `ConfigData` WHERE `Config_Key` = 'SMSC_Num';")
		        my_logger.info(SQLCur.fetchone()[0])
			del SQLCur
			del db
			time.sleep(1)
