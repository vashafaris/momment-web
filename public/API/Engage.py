
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
        tweet_content = tweet.full_text
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
        
        if trigger == 0 :
            c.execute("INSERT INTO twitter_tweets VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", 
                        (tweet_id, twitter_id, tweet_created, tweet_content, tweet_media, location, retweet_count, favorite_count, 0, reply_status_id, reply_user_id, reply_screen_name, 0, created_at))
            conn.commit()
        else :
            c.execute("UPDATE twitter_tweets SET retweet_count=?, favorite_count=? where tweet_id = ?", (retweet_count, favorite_count, tweet_id))
            conn.commit()
        trigger = 0    
            
    print("successfully insert " + screen_name + " tweets")


# In[ ]:


if __name__ == "__main__":
    username = sys.argv[1]
    twitter_call(username)

