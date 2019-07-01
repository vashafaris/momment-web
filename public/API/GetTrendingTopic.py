
# coding: utf-8

# In[1]:


import tweepy
import sys
import numpy as np
import bs4
import pyodbc
import time
import datetime as dt
import configparser as cf
from urllib.request import urlopen as uo
from bs4 import BeautifulSoup as soup
from collections import Counter
from selenium import webdriver
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.common.keys import Keys


# In[2]:


main_url = "https://trends24.in/indonesia/"
replies_url = "https://twitter.com/"
TREND_DATA = []


# In[3]:


def scraping ():
    global TREND_DATA
    uClient = uo(main_url)
    forum_page = uClient.read()
    uClient.close()
    pageSoup = soup(forum_page, "html.parser")

    trendListContainer = pageSoup.findAll("div",{"class":"trend-card"})
    for i in trendListContainer :
        trendTime = i.find("h5").text
        trendList = i.findAll("li")
        for j in trendList :
            TREND_DATA.append(j.text)
    print("=========MOMMENT TRENDING SCRAPE==========")
    FindMostTrending()


# In[4]:


def FindMostTrending() :
    conn = pyodbc.connect("DRIVER={SQL Server}; server=.; database=Momment; uid=; pwd=")
    c = conn.cursor()
    trigger = 0
    triggerCheck = 0


    cnt = Counter(TREND_DATA).most_common(10)
    print("TOP 10 TODAY TRENDING TOPICS")

#     c.execute("SELECT COUNT(*) FROM twitter_trends WHERE cast(created_at as date) = cast(current_timestamp as date)")
#     if (c.fetchone()[0] == 10) :
#         triggerCheck = 1
#     else :
    c.execute("delete twitter_trends where cast(created_at as date) = cast(CURRENT_TIMESTAMP as date)")
    conn.commit()
    c.execute("delete twitter_trend_detail where cast(created_at as date) = cast(CURRENT_TIMESTAMP as date)")
    conn.commit()

    for counter, i in enumerate(cnt) :

        created_at = dt.datetime.now()
        c.execute("INSERT INTO twitter_trends VALUES (?, ?, ?, ?)", i[0], i[1], created_at, created_at)
        conn.commit()
        print("--INSERT DATA--")

        trigger = 0
        print("\nTOPIC => " + str(i))

        c.execute("SELECT id_trend FROM twitter_trends WHERE created_at = ?",(created_at))
        id_trend = c.fetchone()[0]
        if " " in i[0] :
            FindSampleTweet(i[0].replace(" ","%20"), id_trend)
        elif "#" in i[0] :
            FindSampleTweet(i[0].replace("#",""), id_trend)
        else :
            FindSampleTweet(i[0], id_trend)


# In[5]:


from credentials import *

def twitter_setup():

    auth = tweepy.OAuthHandler(CONSUMER_KEY, CONSUMER_SECRET)
    auth.set_access_token(ACCESS_TOKEN, ACCESS_SECRET)

    api = tweepy.API(auth)
    return api


# In[6]:


def FindSampleTweet(key, tweetID) :
    conn = pyodbc.connect("DRIVER={SQL Server}; server=.; database=Momment; uid=; pwd=")
    c = conn.cursor()
    url = "https://twitter.com/search?q="+ (key) + "&src=typd&lang=id"
    extractor = twitter_setup()
    trends = tweepy.Cursor(extractor.search,q=key,result_type='popular',timeout=50000,tweet_mode="extended").items(50)
    for trend in trends :
        name = trend.user.name
        screen_name = trend.user.screen_name
        tweet_id = trend.id_str
        tweet = trend.full_text
        try :
            tweet_pic = None
            if 'media' in trend.entities:
                for image in  trend.entities['media']:
                    tweet_pic = image['media_url']
            is_verified = trend.user.verified
            if (is_verified == True) :
                is_verified = 1
            else :
                is_verified = 0
        except Exception as e :
            print(str(e) + " " + str(url) + str(key))
        try :
            photo_url = trend.user.profile_image_url_https
            try :
                photo_url = photo_url.replace("_normal","")
            except Exception as e :
                print(str(e) + " " + str(url) + str(key))
        except :
            photo_url = None
        retweet_count = trend.retweet_count
        favorite_count = trend.favorite_count
        recommendation = 0
        id_trend = tweetID
        created_at = dt.datetime.now()

        if not hasattr(trend, 'retweeted_status') :
            c.execute("INSERT INTO twitter_trend_detail VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", id_trend, name, screen_name, tweet_id, tweet, tweet_pic, is_verified, photo_url, retweet_count, favorite_count, 0, 1, recommendation, created_at)
            conn.commit()
            try :
                findReplies(screen_name,tweet_id)
            except Exception as e :
                print(str(e) + " " + str(url) + str(key))

    c.execute("SELECT COUNT(*) FROM twitter_trend_detail WHERE id_trend = ?",tweetID)
    count = c.fetchone()[0]
    print(count)
    items_count = 25 - count
    looping = 0
    times = 0
    key = key + ' -filter:retweets'
    if (count < 25) :
        print(items_count)
        trends = tweepy.Cursor(extractor.search,q=key,result_type='recent',timeout=50000,tweet_mode="extended").items(items_count)
        for trend in trends :
            trigger = 0
            name = trend.user.name
            screen_name = trend.user.screen_name
            tweet_id = trend.id_str
            tweet = trend.full_text
            try :
                tweet_pic = None
                if 'media' in trend.entities:
                    for image in  trend.entities['media']:
                        tweet_pic = image['media_url']
                is_verified = trend.user.verified
                if (is_verified == True) :
                    is_verified = 1
                else :
                    is_verified = 0
            except Exception as e :
                print(str(e) + " " + str(url) + str(key))
            try :
                photo_url = trend.user.profile_image_url_https
                try :
                    photo_url = photo_url.replace("_normal","")
                except Exception as e :
                    print(str(e) + " " + str(url) + str(key))
            except :
                photo_url = None
            retweet_count = trend.retweet_count
            favorite_count = trend.favorite_count
            recommendation = 0
            id_trend = tweetID
            created_at = dt.datetime.now()

            c.execute("SELECT * FROM twitter_trend_detail WHERE tweet_id = ?", (tweet_id))
            for row in c:
                if row.tweet_id is not None:
                    trigger = 1

            if trigger == 0 :
                if not hasattr(trend, 'retweeted_status') :
                    c.execute("INSERT INTO twitter_trend_detail VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", id_trend, name, screen_name, tweet_id, tweet, tweet_pic, is_verified, photo_url, retweet_count, favorite_count, 0, 0, recommendation, created_at)
                    conn.commit()
                    try :
                        findReplies(screen_name,tweet_id)
                    except Exception as e :
                        print(str(e) + " " + str(url) + str(key))
                else :
                    c.execute("INSERT INTO twitter_trend_detail VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", id_trend, name, screen_name, tweet_id, tweet, tweet_pic, is_verified, photo_url, retweet_count, favorite_count, 0, 1, recommendation, created_at)
                    conn.commit()
                    try :
                        findReplies(screen_name,tweet_id)
                    except Exception as e :
                        print(str(e) + " " + str(url) + str(key))
            trigger = 0


# Scraping()


# In[7]:


def findReplies(username, tweetID) :
    conn = pyodbc.connect("DRIVER={SQL Server}; server=.; database=Momment; uid=; pwd=")
    c = conn.cursor()
    url = replies_url + username + "/status/" + tweetID
    print(url)

    trigger = 0

    browser = webdriver.Chrome("C:/Users/Asus/Desktop/Skripsi/Python Script Skripsi/chromedriver.exe")
    browser.get(url)
    html_source = browser.page_source
    pageSoup = soup(html_source,'html.parser')
    counter = 0
    repliesCount = pageSoup.find("span",{"class":"ProfileTweet-actionCount"})
    repliesCount = repliesCount['data-tweet-stat-count']

    c.execute("UPDATE twitter_trend_detail SET replies_count = (?) WHERE tweet_id = (?)",(repliesCount,tweetID))
    conn.commit()

    browser.quit()


# In[8]:


def updateDataRecommendation() :
    conn = pyodbc.connect("DRIVER={SQL Server}; server=.; database=Momment; uid=; pwd=")
    c = conn.cursor()

    c.execute("SELECT id_trend FROM twitter_trend_detail WHERE cast (created_at as date) = cast (CURRENT_TIMESTAMP as date)")
    id_trends = c.fetchall()

    for id_trend in id_trends :
        countRecommendation (id_trend[0])


# In[9]:


def countRecommendation (id_trend) :

    conn = pyodbc.connect("DRIVER={SQL Server}; server=.; database=Momment; uid=; pwd=")
    c = conn.cursor()

    c.execute("SELECT is_verified,retweet_count, replies_count, favorite_count FROM twitter_trend_detail WHERE id_trend = ? order by created_at", (id_trend))
    datas = c.fetchall()
    c.execute("SELECT tweet_id FROM twitter_trend_detail WHERE id_trend = ? order by created_at",(id_trend))
    tweet_ids = c.fetchall()

    Wj = []
    Sj = []
    temp = []
    Vj = []

    weights = [4,3,2,1]
    totalWeights = sum(weights)
    print(weights)
    print(totalWeights)
    for counter, weight in enumerate(weights) :
        Wj.append(round(weight/totalWeights,4))
    print(Wj)
    for counter, data in enumerate(datas) :
        temp = []
        for counter2, element in enumerate(data) :
            temp.append((element+0.1)**(Wj[counter2]))
        Sj.append(np.prod(temp))
    print(Sj)
    for s in Sj :
        Vj.append(s/sum(Sj))
    print(Vj)

    for counter, recommendationResult in enumerate(Vj) :

        c.execute("UPDATE twitter_trend_detail SET recommendation = ? where tweet_id = ?", (recommendationResult,tweet_ids[counter][0]))
        conn.commit()
        print("updated tweet id = " + tweet_ids[counter][0])


# In[10]:


if __name__ == "__main__":
    # scraping()
    # print("Scrape twitter trending finished")
    # updateDataRecommendation()
    # print("Finish update trending recommendation")
