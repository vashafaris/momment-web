
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
import pyodbc
from urllib.request import urlopen as uo
from bs4 import BeautifulSoup as soup
from collections import Counter
import re
import csv


# In[2]:


def countRecommendation (twitterID) :
    
    conn = pyodbc.connect("DRIVER={SQL Server}; server=.; database=Momment; uid=; pwd=")
    c = conn.cursor()
    sentiment_positives = []
    sentiment_negatives = []
    datas = []
    
    c.execute("SELECT retweet_count, replies_count, favorite_count FROM twitter_tweets WHERE twitter_id = ? and cast(created_at as date) > DATEADD(day, -7, convert(date, GETDATE())) order by created_at", (twitterID))
    raw_datas = c.fetchall()
    c.execute("SELECT tweet_id FROM twitter_tweets WHERE twitter_id = ? and cast(created_at as date) > DATEADD(day, -7, convert(date, GETDATE())) order by created_at",(twitterID))
    tweet_ids = c.fetchall()
    
    for tweet_id in tweet_ids :
        c.execute("SELECT count(*) as sentiment_negative FROM twitter_replies WHERE tweet_id = ? and sentiment = 'negatif'",(tweet_id))
        sentiment_negative = c.fetchone()
        c.execute("SELECT count(*) as sentiment_positive FROM twitter_replies WHERE tweet_id = ? and sentiment = 'positif'",(tweet_id))
        sentiment_positive = c.fetchone()
        sentiment_positives.append(sentiment_positive[0])
        sentiment_negatives.append(sentiment_negative[0])
        
    for counter, i in enumerate(sentiment_positives) :
        datas.append([sentiment_positives[counter]])
    
    for counter, i in enumerate(datas) :
        i.append(sentiment_negatives[counter])
        i.append(raw_datas[counter].retweet_count)
        i.append(raw_datas[counter].replies_count)
        i.append(raw_datas[counter].favorite_count)
    
    Wj = []
    Si = []
    temp = []
    Vi = []

    weights = [1,1,3,2,1]
    totalWeights = sum(weights)
    for counter, weight in enumerate(weights) :
        Wj.append(round(weight/totalWeights,4))
    for counter, data in enumerate(datas) :
        temp = []
        for counter2, element in enumerate(data) :
            if (counter2 == 1) :
                temp.append((element+0.1)**(-Wj[counter2]))
            else :
                temp.append((element+0.1)**(Wj[counter2]))
        Si.append(np.prod(temp))
#     print(Si)
    for s in Si :
        Vi.append(s/sum(Si))
#     print(Vi)
    
    for counter, recommendationResult in enumerate(Vi) :

        c.execute("UPDATE twitter_tweets SET recommendation = ? where tweet_id = ?", (recommendationResult,tweet_ids[counter][0]))
        conn.commit()
#         print("updated tweet id = " + tweet_ids[counter][0])


# In[3]:


if __name__ == "__main__":
    twitterID = sys.argv[1]
    try :        
        countRecommendation(twitterID)
        print('success')
    except Exception as e :
        print(e)

