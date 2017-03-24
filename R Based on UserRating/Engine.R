setwd("/var/www/html/aasha/R")
.libPaths("packrat/lib/x86_64-pc-linux-gnu/3.3.3")

require(reshape2)
require(recommenderlab)
require(RMySQL)
require(jsonlite)

# MySQL DataBase Connection 
connection = dbConnect(MySQL(), user='root', password='root', host='localhost', dbname="aasha")
#Reading Paper & Rating table from the database
rs <- dbSendQuery(connection, "SELECT * FROM rating")
rating.table<-dbFetch(rs,n=-1) # Fetching All the rows for the Rating table
rs <- dbSendQuery(connection, "SELECT * FROM paper")
paper.table<-dbFetch(rs,n=-1) # Fetching All the Rows for the Paper Table
dbDisconnect(connection) # Closing the MySQL Connection

rating <- rating.table
paper <- paper.table

#Create ratings matrix. Rows = UserID, Columns = PaperID
ratingmat <- dcast(rating, UserID~PaperID, value.var = "rating", na.rm=FALSE)
ratingmat <- as.matrix(ratingmat[,-1]) #remove userIds
ratingmat<-sapply(data.frame(ratingmat),as.numeric)
#Convert rating matrix into a recommenderlab sparse matrix
ratingmat <- as(ratingmat, "realRatingMatrix")

#Normalize the data
ratingmat_norm <- normalize(ratingmat)

#Create Recommender Model. using POPULAR Algorithm
recommender_model <- Recommender(ratingmat, method = "POPULAR")#, param=list(method="Cosine",nn=30))

rm(paper)
rm(paper.table)
rm(rating)
rm(rating.table)
rm(connection)
rm(rs)
rm(ratingmat_norm)
save.image("RecommendationEngine.rda")
