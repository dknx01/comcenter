# comcenter

A small application for twitter timeline, laverna notes and automatically mark rss entries as read in FreshRss

# Twitter timeline Bundle
reading , save it locally into MongoDB and show it
Possibility to:
* mark entry as deleted
* pin an entry
* show only pinned / deleted items

more is comming

# Show laverna note  from remoteStorage
read the notes, save it in MongoDB and show them on a website. The purpose is to have some kind of developer notes collection website  

# Mark FreshRSS entries as read
Attempt to automatically mark not needed entries in FreshRss as "read". Especially for not important feed entries. Based on a list of regex.


# Config requirements
* In app/config/config.yml configure your mongodb connection (doctrine):
```
doctrine_mongodb:
    connections:
        default:
            server: mongodb://localhost:27017
            options: { username: "%mongodb_user%", password: "%mongodb_password%"} 
    default_database: [YOUR_DATABASE]
    document_managers:
        default:
            auto_mapping: true
```

* In app/config/parameters.yml configure your twitter keys and mongodb credentials:
```
    twitter:
        oauth_access_token: [YOUR OAUTH_ACCESS_TOKEN]
        oauth_access_token_secret: [YOUR OAUTH_ACCESS_TOKEN_SECRET]
        consumer_key: [YOUR CONSUMER_KEY]
        consumer_secret: [YOUR CONSUMER_SECRET]
    mongodb_user: [YOUR MONGODB_USER]
    mongodb_password: [YOUR MONGODB_PASSWORD]
    shownotestozoid.paths.notes: [PATH/TO/LAVERNA/NOTES/IN/REMOTESTORAGE/FOLDER]
```
