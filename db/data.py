
from suds.client import Client
import re
import urllib2
import json

common_words = ['i','you','no','yes','the','it','a',"it's",'its','on','and','my','your','in',"you're","i'm",'is','was','but','what','had','oh','for',
                'yeah','yea','me','na','all','to','do','be','this','gonna','know','of','come','like','so','way','just','said','would','now','we','that',
                'got','when','dont','im','are','id']

# Returns list of lyrics split into words
def getLyrics(artist,name):
    url = "http://lyrics.wikia.com/server.php?wsdl"
    client = Client(url)
    
    if artist and name:
        resp = client.service.getSong(artist=artist,song=name)
        if "Not found" not in resp.lyrics:
            lyrics = resp.lyrics
            
            lyrics = re.sub(r'[\(\)\,\.\?\!\"|\[.{0,2}\]|(x\d)]',"",lyrics)

            return lyrics.split()
    return None

# Returns dict of artist/song combos for specified year
def getYear(year,bbkey):
    url = "http://api.billboard.com/apisvc/chart/v1/list?id=379&format=json&count=50&sdate=" + year + "-01-01&edate=" + year + "-12-31&api_key=" + bbkey
    req = urllib2.Request(url)
    doc = urllib2.urlopen(req)
    content = str(doc.read())
    songMap = dict()
    
    jsobj = json.loads(content)

    if jsobj:
        results = jsobj["searchResults"]

        for entry in results["chartItem"]:
            name = entry["song"]
            artist = entry["artist"]
            if name and artist:
                print(artist + ' - ' + name)
                try:
                    if name not in songMap[artist]:
                        songMap[artist].append(name)
                except KeyError:
                    songMap[artist] = [name]
        return songMap
    else:
        return None

# Build frequency table of words       
def buildFreqTable(songlist):
    freqTable = dict()
    for song in songlist:
        for lyric in song:
            if lyric:
                lyric = lyric.lower().encode("utf-8")
                if lyric not in common_words:
                    if lyric in freqTable:
                        freqTable[lyric] += 1
                    else:
                        freqTable[lyric] = 1
                
    return freqTable 
