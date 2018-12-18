
# coding: utf-8

# In[1]:


# General:
import tweepy           # To consume Twitter's API
import pandas as pd     # To handle data
import numpy as np      # For number computing
import pyodbc
import time
import datetime as dt
from datetime import timedelta
import sys


# In[2]:


from credentials import *    # This will allow us to use the keys as variables

def twitter_setup():
    """
    Utility function to setup the Twitter's API
    with our access keys provided.
    """
    # Authentication and access using keys:
    auth = tweepy.OAuthHandler(CONSUMER_KEY, CONSUMER_SECRET)
    auth.set_access_token(ACCESS_TOKEN, ACCESS_SECRET)

    # Return API with authentication:
    api = tweepy.API(auth)
    return api


# In[3]:


def tweets_call(username):
    
    conn = pyodbc.connect("DRIVER={SQL Server}; server=.; database=Momment; uid=; pwd=")
    c = conn.cursor()
    trigger = 0
    
    extractor = twitter_setup()
#     user = extractor.get_user(username)
    
    tweets = extractor.user_timeline(id = username, count = 25, include_rts = False, tweet_mode='extended')
    for tweet in tweets :
#         print(tweet)
        tweet_id = tweet.id_str
        tweet_created = tweet.created_at
        tweet_content = tweet.full_text
        location = tweet.user.location
        retweet_count = tweet.retweet_count
        favorite_count = tweet.favorite_count
        account_id = tweet.user.id_str
        reply_status_id = tweet.in_reply_to_status_id_str
        reply_user_id = tweet.in_reply_to_user_id_str
        reply_screen_name = tweet.in_reply_to_screen_name
        created_at = dt.datetime.now()
        
        screen_name = tweet.user.screen_name
        
        c.execute("SELECT * FROM twitter_tweets WHERE tweet_id = (?)", tweet_id)
        for row in c:
            if row.tweet_id is not None:
                trigger = 1
        
        if trigger == 0 :
            c.execute("INSERT INTO twitter_tweets VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", 
                        (tweet_id, tweet_created, tweet_content, location, retweet_count, favorite_count, account_id, reply_status_id, reply_user_id, reply_screen_name, created_at))
            conn.commit()
        trigger = 0    
            
    print("successfully insert " + screen_name + " tweets")    


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
        print("successfully insert " + screen_name + " logs")
    else :
        c.execute("UPDATE twitter_accounts_log SET name=?, screen_name=?, photo_url=?, banner_url=?, description=?, favorites_count=?, followers_count=?, friends_count=?, statuses_count=?, location=?, created=?, updated_at=? WHERE twitter_id = (?) and cast(created_at as date) = (?)", (name, screen_name, photo_url, banner_url, description, favourites_count, followers_count, friends_count, statuses_count, location, created, updated_at, twitter_id, str(date_check)))
        conn.commit()
        print("successfully update " + screen_name + " logs")
    trigger = 0

    print("====================================================================")


# In[5]:


def getAccountData() :
    
    global INSERTED_COUNT
    global ALREADY_INSERTED_COUNT
    
    conn = pyodbc.connect("DRIVER={SQL Server}; server=.; database=Momment; uid=; pwd=")
    c = conn.cursor()
    
    c.execute("SELECT twitter_id FROM twitter_accounts where is_account = 1 or is_competitor = 1")
    accounts = c.fetchall()
    for account in accounts :
        tweets_call(account[0])
        logs_call(account[0])


# In[6]:


if __name__ == "__main__":
    getAccountData()

#     extractor = twitter_setup()
#     user = extractor.get_user(username)
    
#     tweets = extractor.user_timeline(id = "jokowi", count = 1, include_rts = False, tweet_mode='extended')
#     for tweet in tweets :
#         print(tweet)

