
require(NLP)
require(tm)
require(RMySQL)
require(RWeka)
require(ngram)
N <- 7
# MySQL DataBase Connection 
connection = dbConnect(MySQL(), user='root', password='root', host='localhost', dbname="aasha")
#Reading Paper & Rating table from the database
rs <- dbSendQuery(connection, "SELECT * FROM user")
user.table<-dbFetch(rs,n=-1) # Fetching All the rows for the Rating table

rs <- dbSendQuery(connection, "SELECT * FROM paper")
paper.table<-dbFetch(rs,n=-1) # Fetching All the Rows for the Paper Table

dbDisconnect(connection) # Closing the MySQL Connection

keywordList<-unlist(strsplit(user.table$keywords[N],","))
print(keywordList)

# Removing white space from the keywords
trim <- function (x) gsub("^\\s+|\\s+$", "", x)

trim(keywordList)

table(grepl(keywordList, paper.table$abstract))
