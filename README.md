# dutyPhone
This is the dutyPhone system that will forward SMS and calls to a designated number.

SMSes can be forwarded to multiple parties (i.e. supervisors), while calls will only be diverted to the duty number.

Supervisors can also subscribe to keywords.

To run: ./startWork.py

To run in headless mode:
nohup ./startWork.py > out.log&

This will output the log to the file out.log
