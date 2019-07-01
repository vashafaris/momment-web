
# coding: utf-8

# In[1]:


import tweepy           
import pandas as pd     
import numpy as np      
import pyodbc
import time
import datetime as dt
from datetime import timedelta
import sys
import bs4
import pyodbc
from urllib.request import urlopen as uo
from bs4 import BeautifulSoup as soup
from collections import Counter
import re
import csv


# # Tweets and Accounts Log

# In[2]:


from credentials import *    

def twitter_setup():

    auth = tweepy.OAuthHandler(CONSUMER_KEY, CONSUMER_SECRET)
    auth.set_access_token(ACCESS_TOKEN, ACCESS_SECRET)

    api = tweepy.API(auth)
    return api


# In[3]:


def tweets_call(username):
    
    conn = pyodbc.connect("DRIVER={SQL Server}; server=.; database=Momment; uid=; pwd=")
    c = conn.cursor()
    trigger = 0
    
    extractor = twitter_setup()
    
    tweets = extractor.user_timeline(id = username, count = 25, include_rts = False, tweet_mode='extended')
    for tweet in tweets :
        try :
            tweet_media = None
            if 'media' in tweet.entities:
                for image in  tweet.entities['media']:
                    tweet_media = image['media_url']
        except Exception as e :
            print(e)
        tweet_id = tweet.id_str
        tweet_created = tweet.created_at
        tweet_created = tweet_created + timedelta(hours=7)
        tweet_content = tweet.full_text.strip()
        tweet_content = tweet_content.replace("&amp;","&")
        location = tweet.user.location
        retweet_count = tweet.retweet_count
        favorite_count = tweet.favorite_count
        twitter_id = tweet.user.id_str
        reply_status_id = tweet.in_reply_to_status_id_str
        reply_user_id = tweet.in_reply_to_user_id_str
        reply_screen_name = tweet.in_reply_to_screen_name
        created_at = dt.datetime.now()
        
        screen_name = tweet.user.screen_name
        
        
        c.execute("SELECT * FROM twitter_tweets WHERE tweet_id = (?)", tweet_id)
        for row in c:
            if row.tweet_id is not None:
                trigger = 1
        
        if not hasattr(tweet, 'retweeted_status') :
            if trigger == 0 :
                c.execute("INSERT INTO twitter_tweets VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", 
                            (tweet_id, twitter_id, tweet_created, tweet_content, tweet_media, location, retweet_count, favorite_count, 0, reply_status_id, reply_user_id, reply_screen_name, 0, created_at))
                conn.commit()
            else :
                c.execute("UPDATE twitter_tweets SET retweet_count=?, favorite_count=? where tweet_id = ?", (retweet_count, favorite_count, tweet_id))
                conn.commit()
            trigger = 0    
            
    


# In[4]:


def logs_call(username) :
    
    conn = pyodbc.connect("DRIVER={SQL Server}; server=.; database=Momment; uid=; pwd=")
    c = conn.cursor()
    trigger = 0
    
    extractor = twitter_setup()
    user = extractor.get_user(username)    
    
    twitter_id = username
    name = user.name
    screen_name = user.screen_name
    try :
        photo_url = user.profile_image_url.replace("_normal","")
    except :
        photo_url = None
    try :
        banner_url = user.profile_banner_url
    except :
        banner_url = None
    description = user.description
    favourites_count = user.favourites_count
    followers_count = user.followers_count
    friends_count = user.friends_count
    statuses_count = user.statuses_count
    location = user.location
    created = user.created_at
    created_at = dt.datetime.now()
    updated_at = dt.datetime.now()
    
    date_check = dt.datetime.now().date()
    
    c.execute("SELECT * FROM twitter_accounts_log WHERE twitter_id = ? and cast(created_at as date) = ?", (username, str(date_check)))
    for row in c:
        if row.twitter_id is not None:
            trigger = 1
                
    if trigger == 0 :
        c.execute("INSERT INTO twitter_accounts_log VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", (twitter_id, name, screen_name, photo_url, banner_url, description, favourites_count, followers_count, friends_count, statuses_count, location, created, created_at, updated_at))
        conn.commit()
    else :
        c.execute("UPDATE twitter_accounts_log SET name=?, screen_name=?, photo_url=?, banner_url=?, description=?, favorites_count=?, followers_count=?, friends_count=?, statuses_count=?, location=?, created=?, updated_at=? WHERE twitter_id = (?) and cast(created_at as date) = (?)", (name, screen_name, photo_url, banner_url, description, favourites_count, followers_count, friends_count, statuses_count, location, created, updated_at, twitter_id, str(date_check)))
        conn.commit()
    trigger = 0


# In[5]:


def getAccountData(twitterID) :
    try :
        tweets_call(twitterID)
        logs_call(twitterID)
        print("success")
    except :
        print("failed")


# In[6]:


if __name__ == "__main__":
    twitterID = sys.argv[1]
    getAccountData(twitterID)
#     print("finished getting account data")
#     getTweetData()
#     print("finished getting tweet data")
#     getSentiment()
#     print("finished getting sentiment")
#     getRecommendationData()
#     print("finished getting recommendation")

