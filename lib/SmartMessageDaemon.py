#!/usr/bin/env python

import logging, time, MySQLdb, ConfigParser, imp, os
import logging.handlers
from lib.daemon import *

class SmartMessageDaemon(Daemon):

	def load_from_file(filepath):
		class_inst = None
		expected_class = 'MyClass'

		mod_name,file_ext = os.path.splitext(os.path.split(filepath)[-1])

		if file_ext.lower() == '.py':
			py_mod = imp.load_source(mod_name, filepath)
		elif file_ext.lower() == '.pyc':
			py_mod = imp.load_compiled(mod_name, filepath)

		if hasattr(py_mod, expected_class):
			class_inst = getattr(py_mod, expected_class)()

		return class_inst

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
		        SQLCur.execute("SELECT `Module_Path` FROM `Modules` WHERE `Module_Enabled` = '1';")
			modPath = SQLCur.fetchone()[0]
		        my_logger.info(modPath)
			try:
				command_module = __import__(modPath)
			except ImportError:
				# Display error message
				my_logger.error("Module not found %s" % modPath)
			my_logger.info("Successfully loaded %s" % modPath)
			del SQLCur
			del db

			command_module.run()
			time.sleep(1)
