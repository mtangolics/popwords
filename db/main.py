
from collections import OrderedDict
import data
import db
import sys

if __name__ == '__main__':
    year = sys.argv[4]
    map = data.getYear(year,sys.argv[3])
    print(map)
    songs = list()
    for artist in map:
        for name in map[artist]:
            song = data.getLyrics(artist, name)
            if song:
                songs.append(song)
            else:
                print("Error getting lyrics for " + artist + " : " + name)
    table = data.buildFreqTable(songs)
    alist = OrderedDict(sorted(table.items(), key=lambda t: t[1], reverse=True))

    print(alist)
    
    db.insertYearData(alist,year,sys.argv[1],sys.argv[2])
    pass