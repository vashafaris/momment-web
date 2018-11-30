
# coding: utf-8

# In[1]:


# General:
import tweepy           # To consume Twitter's API
import pyodbc
import time
import datetime as dt
import sys
import json

# In[2]:


from credentials import *    # This will allow us to use the keys as variables

# API's setup:
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


def twitter_call(username):
    extractor = twitter_setup()
    user = extractor.get_user(username)
    PERSON = []
    ITEM = {}
    try :
        ITEM['banner_url'] = user.profile_banner_url
    except :
        ITEM['banner_url'] = None
    ITEM['created'] = user.created_at
    ITEM['description'] = user.description
    ITEM['favorites_count'] = user.favourites_count
    ITEM['followers_count'] = user.followers_count
    ITEM['friends_count'] = user.friends_count
    try :
        ITEM['location'] = user.location
    except :
        ITEM['location'] = None
    ITEM['name'] = user.name
    try :
        ITEM['photo_url'] = user.profile_image_url.replace("_normal","")
    except :
        ITEM['photo_url'] = None
    ITEM['screen_name'] = user.screen_name
    ITEM['statuses_count'] = user.statuses_count
    ITEM['user_id'] = user.id

    PERSON.append(ITEM)
    pretty_json = json.dumps(PERSON, indent=4,sort_keys=True, default=str)
    print(pretty_json)


# In[4]:


if __name__ == "__main__":
    username = sys.argv[1]
    twitter_call(username)
