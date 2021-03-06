args <- commandArgs(TRUE)
id <- as.integer(args[1])

setwd("/var/www/html/aasha/R")
.libPaths("packrat/lib/x86_64-pc-linux-gnu/3.3.3")

require(tm)
require(reshape2)
require(recommenderlab)
require(jsonlite)
load("RecommendationEngine.rda")


getDocumentTermMatrix <- function(res)
{
  
  CorpusDocument <- Corpus(VectorSource(res))
  # Clearning and Transforming Data
  CorpusDocument <- tm_map(CorpusDocument,tolower)
  CorpusDocument <- tm_map(CorpusDocument,removePunctuation)
  CorpusDocument <- tm_map(CorpusDocument,removeNumbers)
  CorpusDocument <- tm_map(CorpusDocument,removeWords,stopwords("en"))
  CorpusDocument <- tm_map(CorpusDocument,stripWhitespace)
  
  # Generating Term Matrix 
  DocumentMatrix <- (TermDocumentMatrix(CorpusDocument)) # Created Document Term Matrix and Created Transpose of matrix
  DocumentMatrix <- as.matrix(DocumentMatrix)
  DocumentMatrixs <- as.data.frame(DocumentMatrix)
  
  wordFreq <- rowSums(DocumentMatrixs)
  DocumentMatrixs <- data.frame(word = names(wordFreq),freq=wordFreq)
  
  return(DocumentMatrixs)
}





 
recom <- predict(recommender_model, ratingmat[id],n=10) 
#Obtain top 10 recommendations for 1st user in dataset
recom_list <- as(recom, "list") #convert recommenderlab object to readable list
recom_lists <- recom_list
#print(toJSON(recom_lists[[1]]))

trim <- function (x) gsub("^X|", "", x)
recom_list=trim(recom_list[[1]])
finalResult<- as.data.frame(recom_list)
finalResult$Freq=0
names(finalResult)<-c("PaperID","Freq")

i<-1
while(i<length(finalResult$PaperID)){

res<-paper.table[paper.table$ID==finalResult$PaperID[i],2:3]
res<-paste(res$title,res$abstract)

paperKeywords<-getDocumentTermMatrix(res)
userKeywords <- getDocumentTermMatrix(user.table[user.table$ID==id,c('keywords')])

result<-as.data.frame(table(userKeywords$word %in% paperKeywords$word))

#finalResult[finalResult$PaperID==finalResult$PaperID[i],2] <- result[result$Var1=="TRUE",2]
finalResult[finalResult$PaperID==finalResult$PaperID[i],2] <- sum(result[result$Var1=="TRUE",2])

i <- i + 1
}

finalResult<-finalResult[order(-finalResult$Freq),]
print(toJSON(head(finalResult$PaperID,n=5)))

