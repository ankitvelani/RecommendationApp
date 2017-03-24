args <- commandArgs(TRUE)
id <- as.integer(args[1])

setwd("/var/www/html/aasha/R")
.libPaths("packrat/lib/x86_64-pc-linux-gnu/3.3.3")

require(reshape2)
require(recommenderlab)
require(jsonlite)
load("RecommendationEngine.rda")
 
recom <- predict(recommender_model, ratingmat[id],n=5) 
#Obtain top 10 recommendations for 1st user in dataset
recom_list <- as(recom, "list") #convert recommenderlab object to readable list
print(toJSON(recom_list[[1]]))

