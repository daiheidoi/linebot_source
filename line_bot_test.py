from flask import Flask
from flask import request

import requests
import json
import re

LINEBOT_API_EVENT ='https://trialbot-api.line.me/v1/events'
LINE_HEADERS = {
    'Content-type': 'application/json; charset=UTF-8',
    'X-Line-ChannelID':'1461716189', # Channel ID
    'X-Line-ChannelSecret':'a1c0a8a95a5c88c0444bad85a82fe0d4', # Channel secre
    'X-Line-Trusted-User-With-ACL':'u72e361d4b846000f48c81f9dd04a538f' # MID (of Channel)
}

def post_event( content):
    msg = {
        'to': ["u72e361d4b846000f48c81f9dd04a538f"],
        'toChannel': 1383378250, # Fixed  value
        'eventType': "138311608800106203", # Fixed value
        'content': content
    }
    r = requests.post(LINEBOT_API_EVENT, headers=LINE_HEADERS, data=json.dumps(msg))

def post_text( text ):
    content = {
        'contentType':1,
        'toType':1,
        'text':text,
    }
    post_event( content)

post_text("hello")
