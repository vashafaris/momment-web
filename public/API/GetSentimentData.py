
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
from selenium import webdriver
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.common.keys import Keys
import re
import csv


# # Replies

# In[2]:


main_url = "https://twitter.com/"
TREND_DATA = []


# In[3]:


def findReplies(username, tweetID) :
    conn = pyodbc.connect("DRIVER={SQL Server}; server=.; database=Momment; uid=; pwd=")
    c = conn.cursor()
    url = main_url + username + "/status/" + tweetID
    print(url)

    trigger = 0

    browser = webdriver.Chrome("C:/Users/Asus/Desktop/Skripsi/Python Script Skripsi/chromedriver.exe")
    browser.get(url)
    html_source = browser.page_source
    pageSoup = soup(html_source,'html.parser')
    counter = 0
    repliesCount = pageSoup.find("span",{"class":"ProfileTweet-actionCount"})
    repliesCount = repliesCount['data-tweet-stat-count']
    repliesDetails = pageSoup.findAll("li",{"class":"ThreadedConversation--loneTweet"})

    for repliesDetail in repliesDetails :
        account_raw = repliesDetail.ol.li.div['data-permalink-path']
        screen_name = account_raw.split("/")[1]
        replies_id = account_raw.split("/")[3]
        try :
            reply_account_photo = repliesDetail.find("img",{"class":"avatar"})['src'].replace("_bigger","")
        except :
            reply_account_photo = None
        replies_content_raw = repliesDetail.find("p").text
        try :
            replies_content = replies_content_raw.split("pic.twitter.com")[0].strip()
        except :
            replies_content = replies_content_raw.strip()
        try :
            replies_media = repliesDetail.find("div",{"class":"AdaptiveMedia-photoContainer"})['data-image-url']
        except :
            replies_media = None
        replies_created = repliesDetail.find("a",{"class":"tweet-timestamp"})['title']
        name = repliesDetail.ol.li.div['data-name']
        reply_account_id = repliesDetail.ol.li.div['data-user-id']
        created_at = dt.datetime.now()

        c.execute("UPDATE twitter_tweets SET replies_count = (?) WHERE tweet_id = (?)",(repliesCount,tweetID))
        conn.commit()

        c.execute("SELECT * FROM twitter_replies WHERE replies_id = (?)", replies_id)
        for row in c:
            if row.tweet_id is not None:
                trigger = 1

        if trigger == 0 :
            c.execute("INSERT INTO twitter_replies VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
                        (replies_id, tweetID, replies_content, replies_created, replies_media, reply_account_id, name, screen_name, reply_account_photo, None, None, created_at))
            conn.commit()
        trigger = 0

    browser.quit()


# In[4]:


def processTweet(tweet):

    tweet = tweet.lower()
    tweet = re.sub('((www\.[^\s]+)|(https?://[^\s]+))','URL',tweet)
    tweet = re.sub('@[^\s]+','AT_USER',tweet)
    tweet = re.sub(r'#([^\s]+)', r'\1', tweet)
    tweet = re.sub(r'[^\w\s]','',tweet)
    tweet = re.sub('[\s]+', ' ', tweet)
    tweet = tweet.strip('\'"')
    return tweet

stopWords = []

def getStopWordList():
    stopWords = []
    stopWords.append('AT_USER')
    stopWords.append('URL')
    return stopWords

def getFeatureVector(tweet):
    featureVector = []
    words = tweet.split()
    stopWords = getStopWordList()
    for w in words:
        val = re.search(r"^[a-zA-Z][a-zA-Z0-9]*$", w)
        if(w in stopWords or val is None):
            continue
        else:
            featureVector.append(w.lower())
    return featureVector

def sentimentAnalysis(repliesId,featureVectors) :

    conn = pyodbc.connect("DRIVER={SQL Server}; server=.; database=Momment; uid=; pwd=")
    c = conn.cursor()

    print("repliesId " + repliesId)
    print(featureVectors)
    sentimentScore = []
    temp = []
    dictionary = open("C:\\xampp\\htdocs\\momment-web\\public\\API\\dictio.txt", "r", encoding="utf8")

    for word in dictionary :
        check = word.split("|")
        for featureVector in featureVectors :
            if (check[3] == featureVector and check[3] not in  temp) :
                sentimentScore.append(float(check[4]))
                sentimentScore.append(-float(check[5]))
                temp.append(check[3])

    print(sentimentScore)
    print(sum(sentimentScore))
    result = sum(sentimentScore)
    if (result > 0) :
        sentiment = 'positif'
        print("sentiment = positif")
    elif (result < 0) :
        sentiment = 'negatif'
        print("sentiment = negatif")
    else :
        sentiment = 'netral'
        print("sentiment = netral")

    c.execute("UPDATE twitter_replies SET sentiment=?, sentiment_weight=? where replies_id = ?", (sentiment, result, repliesId))
    conn.commit()

def getSentiment(twitterID) :

    conn = pyodbc.connect("DRIVER={SQL Server}; server=.; database=Momment; uid=; pwd=")
    c = conn.cursor()

    processedTweets = []
#     c.execute("SELECT * FROM twitter_replies where cast(created_at as date) = cast(CURRENT_TIMESTAMP as date)")
    c.execute("SELECT b.* FROM twitter_tweets a join twitter_replies b on a.tweet_id = b.tweet_id where a.twitter_id = ? and cast(b.created_at as date) = cast(CURRENT_TIMESTAMP as date)",(twitterID))
    tweets = c.fetchall()

    for tweet in tweets :
        processedTweets.append(processTweet(tweet[2]))

    for counter,processedTweet in enumerate(processedTweets) :
        featureVectors = getFeatureVector(processedTweet)
        sentimentAnalysis(tweets[counter][0],featureVectors)
        print("")


# In[5]:


def getRepliesData(twitterID) :

    conn = pyodbc.connect("DRIVER={SQL Server}; server=.; database=Momment; uid=; pwd=")
    c = conn.cursor()

    c.execute("select distinct b.screen_name, a.tweet_id from twitter_tweets a join twitter_accounts_log b on a.twitter_id = b.twitter_id where a.twitter_id = ? and cast(tweet_created as date) > DATEADD(day, -7, convert(date, GETDATE()))",(twitterID))
    tweets = c.fetchall()
    print(tweets)
    for tweet in tweets :
        try :
            findReplies(tweet[0],tweet[1])
        except Exception as e:
            print(e)


# In[6]:


if __name__ == "__main__":
    twitterID = sys.argv[1]
    try :
        getRepliesData(twitterID)
        getSentiment(twitterID)
        print("success")
    except Exception as e :
        print(e)
