import os
import smtplib
from email.message import EmailMessage
from segredos import senha

EMAIL_ADDRESS = 'marcelo.ost7@gmail.com'
EMAIL_PASSWORD = senha

msg = EmailMessage()
msg['Subject'] = 'Jogo Grêmio'
msg['From'] = 'marcelo.ost7@gmail.com'
msg['To'] = 'marcelo.ost7@gmail.com'
msg.set_content('Jogo do Grêmio hoje contra o Cruzeiro.')

with smtplib.SMTP_SSL('smtp.gmail.com',465) as smtp:
    smtp.login(EMAIL_ADDRESS,EMAIL_PASSWORD)
    smtp.send_message(msg)