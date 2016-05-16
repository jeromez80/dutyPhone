#!/usr/bin/env python
import logging, ConfigParser, MySQLdb, time
import logging.handlers

class interactiveSMS:
	"""
	Interactive SMS module	
	"""
	db = None
	SQLCur = None
	my_logger = None

	def getMessagesFromDB(self):
		global SQLCur, kw
		self.SQLCur = self.db.cursor()
		self.SQLCur.execute("SELECT `SMS_ID`, `MsgFrom`, `Message` FROM `IncomingSMS` WHERE `Processed` = '0';")
		message = self.SQLCur.fetchone()
		while message:
			print ("ID %s, From %s, Txt: %s" % message)
			self.handleSms(message)
			message = self.SQLCur.fetchone()
	def run(self):
		self.my_logger = logging.getLogger('Module-iSMS')
		self.my_logger.setLevel(logging.DEBUG)

		handler = logging.handlers.SysLogHandler(address = '/dev/log')
		self.my_logger.addHandler(handler)

		self.my_logger.info('Interactive SMS starting up...')
		dConfig = ConfigParser.ConfigParser()
		dConfig.read("/etc/SmartMessage.conf")
		DBHOST = dConfig.get('DB', 'DBHost')
		DBUSER = dConfig.get('DB', 'DBUser')
		DBPASS = dConfig.get('DB', 'DBPass')
		DBNAME = dConfig.get('DB', 'DBName')
		self.my_logger.info('Loaded DB settings @ '+DBHOST)
		try:
			self.db = MySQLdb.connect(host=DBHOST, user=DBUSER, passwd=DBPASS, db=DBNAME)
		except:
			self.my_logger.critical('DB Connect error. Please check your config file.')
			sys.exit(2)
		self.getMessagesFromDB()

	def safeSendSms(self, number, message):
		print ('Sending %s to %s' % (message, number))
		SQLCur = self.db.cursor()
		SQLCur.execute("INSERT INTO `OutMessageQueue` (Job_ID, Job_Time, Job_Type, Dest_CtyCode, Dest_Number, Dest_Message) VALUES (NULL, NOW(), 'SMS', '65', '93822131', '%s')" % message)
		self.db.commit()

	def handleSms(self, message):
		DUTYNUM='+6593822131'
		SUPERVISORNUM=['+6593822131']
		SILENTNUM=[]
		print(u'== SMS message received ==\nFrom: {0}\nTime: {1}\nMessage:\n{2}\n'.format(message[1], message[0], message[2]))
		if message[1] in ['+6593822131'] or message[1] in ['+6593822131']:
			keyword = message[2].lower().split()[0]
			#============ TAKEOVER DUTY ===============
			if keyword == 'takeover':
				changeDutyNumber(sms)
			#============ GET HELP  ===============
			elif keyword == 'help':
				self.safeSendSms(message[1], 'takeover=Start duty\nreply <msg>=Reply msg to last sender\nmsg <num> <msg>=Send msg to num\nstatus=Check status\nsilence <n>=No alert for n hours\nsub <kw>=Get alerts matching kw\nunsub <kw>=Unsub kw\nmykw=List kw')
			#============ REPLY LAST MSG ===============
			elif keyword == 'reply':
				dmsg = message[2].split(' ', 1)[1]
				print('Replying message to %s.' % getLastIncomingNumber())
				modem.waitForNetworkCoverage(10)
				self.safeSendSms(getLastIncomingNumber(), dmsg)
				time.sleep(3)
				self.safeSendSms(message[1], 'Your message to %s has been sent.' % (getLastIncomingNumber()))
			#============ FORWARDING MSG ===============
			elif keyword == 'msg':
				dnum = message[2].split()[1]
				dmsg = message[2].split(' ', 2)[2]
				if (dnum[:3] != '+65'):
					self.safeSendSms(message[1], 'Your destination number must begin with +65. Message not sent, pls try again.')
				elif (len(dnum) != 11):
					self.safeSendSms(message[1], 'Your destination number is not valid. Message not sent, pls try again.')
				else:
					print('Forwarding message to %s.' % (dnum))
		  			self.safeSendSms(dnum, dmsg)
		  			time.sleep(3)
					self.safeSendSms(message[1], 'Your message to %s has been sent.' % (dnum))
			#============ SILENCE n HOURS ===============
			elif keyword == 'silence' or keyword == 'silent':
				if message[1] == DUTYNUM:
					self.safeSendSms(message[1], 'You are the duty phone and alerts cannot be silenced. :p')
				elif message[1] in SILENTNUM:
					self.safeSendSms(message[1], 'You have already disabled any incoming alerts.')      
				else:
					SILENTNUM.append(message[1])
					self.safeSendSms(message[1], 'You will NOT be notified of incoming alerts. Reply "alert" to re-enable alerts.')
			#============ RE-ENABLE ALERTS ===============
			elif keyword == 'alert':
				if message[1] in SILENTNUM:
					SILENTNUM.remove(message[1])
					self.safeSendSms(message[1], 'You will be notified of incoming alerts.')
				else:
					self.safeSendSms(message[1], 'You are already being notified of incoming alerts.')      
			#============ CHECK STATUS ===============
			elif keyword == 'status':
				v1='Supervisor' if message[1] in SUPERVISORNUM else 'Engineer'
				v2='No' if message[1] in SILENTNUM else 'Yes'
				kw = loadSupervisorKeywords(message[1])
				v3=generateWordList(kw)
				self.safeSendSms(message[1], u'Role: {0}\nAlerts: {1}\nOn-duty: {3}\nKeywords: {2}'.format(v1,v2,v3,DUTYNUM))      
			#============ SUBSCRIBE KW ===============
			elif keyword == 'sub':
				stafflevel='Supervisor' if message[1] in SUPERVISORNUM else 'Engineer'
				if stafflevel=='Engineer':
					self.safeSendSms(message[1], 'Sorry - feature not available to you')
				else:
					kw = loadSupervisorKeywords(message[1])
					newkw = message[2].lower().split()[1]
					kw.append(newkw)
					saveSupervisorKeywords(message[1], kw)
					self.safeSendSms(message[1], u'Added keyword: {0}\nSub:{1}'.format(newkw,generateWordList(kw)))
			#============ GET LIST OF KW ===============
			elif keyword == 'mykw':
				stafflevel='Supervisor' if message[1] in SUPERVISORNUM else 'Engineer'
				if stafflevel=='Engineer':
					self.safeSendSms(message[1], 'Sorry - feature not available to you')
				else:
					kw = loadSupervisorKeywords(message[1])
					self.safeSendSms(message[1], u'Your keywords:\n{0}'.format(generateWordList(kw)))
			#============ UNSUB KW ===============
			elif keyword == 'unsub':
				stafflevel='Supervisor' if message[1] in SUPERVISORNUM else 'Engineer'
				if stafflevel=='Engineer':
					self.safeSendSms(message[1], 'Sorry - feature not available to you')
				else:
					kw = loadSupervisorKeywords(message[1])
					delkw = message[2].lower().split()[1]
					if delkw in kw:
						kw.remove(delkw)
						saveSupervisorKeywords(message[1], kw)
						self.safeSendSms(message[1], u'Removed: {0}\nSub:{1}'.format(delkw,generateWordList(kw)))
					else:
						self.safeSendSms(message[1], u'You are not subscribed to {0}\nSub:{1}'.format(delkw,generateWordList(kw)))
			#============ INVALID COMMAND ===============
			else:
				self.safeSendSms(message[1], 'Sorry I do not understand your message. Try "help" for assistance.')
		else: #NOT FROM STAFF, forward it!
			#NOTE: Need to add in timestamp and originating number. Need to cater for long SMS by breaking it into two.
			#saveLastIncomingNumber(message[1])
			print(u'Sending SMS to duty number: {0} - {1}'.format(DUTYNUM, message[2]))
			try:
				modem.waitForNetworkCoverage(30)
				self.safeSendSms(DUTYNUM, u'[From: {0}]\n{1}'.format(message[1],message[2]))
			except:
				time.sleep(5)
				print('Exception when sending out message. Trying again...')
				self.safeSendSms(DUTYNUM, u'[From: {0}]\n{1}'.format(message[1],message[2]))
				#ONLY supervisors have keyword feature
			for supervisor in SUPERVISORNUM:
				time.sleep(3)
				if supervisor in SILENTNUM:
					print(u'Supervisor {0} is on silent mode.'.format(supervisor))
				elif supervisor == DUTYNUM:
					print(u'Supervisor {0} is on duty and already sent the message.'.format(supervisor))
				else: #OK, passed all the checks. Now check the supervisor filter.
					kw = loadSupervisorKeywords(supervisor)
					if '*all' in kw:
						print(u'Matched *ALL - Copying to supervisor {0}'.format(supervisor))
						self.safeSendSms(supervisor, u'[From: {0}]\n{1}'.format(message[1],message[2]))
					else:
						print('Checking keyword match')
						match = 0
						smslower = message[2].lower()
						for line in  kw:
							line = line.lower()
							print(u'Match {0}?'.format(line))
							if line in smslower and match == 0:
								self.safeSendSms(supervisor, u'[From: {0}]\n{1}'.format(message[1],message[2]))
								print(u'Matched '.format(line))
								match = 1
						if match == 0:
							print(u'No match. Ignoring alert for {0}'.format(supervisor))
		print(u'Completed processing of incoming SMS...')

#Interim defs for migration
def loadSupervisorKeywords(nameofsup):
	return ['*all'];

isms = interactiveSMS()
isms.run()
print "Done"
