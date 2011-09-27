
import boto

def insertYearData(freqTable,year,awskey,awssecret):
    print("using awskey:" + awskey + " and awssecret:" + awssecret)
    sdb = boto.connect_sdb(awskey,awssecret)
    print(sdb)
    if sdb:
        exists = sdb.lookup('poplyrics',validate=True)
        if not exists:
            domain = sdb.create_domain('poplyrics')
        else:
            domain = sdb.get_domain('poplyrics')
        print(domain)
        yearitems = domain.get_item(year)
        if not yearitems:
            item = domain.new_item(year)
            if freqTable:
                cnt = 0;
                for key in freqTable:
                    if cnt > 254:
                        break
                    print(key + ": " + str(freqTable[key]))
                    item[key] = freqTable[key]
                    cnt += 1
            item.save()
        else:
            print("year already exists in domain")
    pass

def deleteYearData(awskey,awssecret):
    sdb = boto.connect_sdb(awskey,awssecret)
    if sdb:
        exists = sdb.lookup('poplyrics',validate=True)
        if exists:
            domain = sdb.get_domain('poplyrics')
            domain.delete()
                
    pass
                    
