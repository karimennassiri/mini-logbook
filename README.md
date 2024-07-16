# LogBook mini

## Introduction

The mini LogBook application offers to import a file with different locations. The Locations are categorized by name, address, status, description and telephone number. I have added a new column, it's `countryCode` to help me better format the phone number. I am allowed to modify the column titles to match the column names in the database. You will found a proper CSV file attached to this GitHub repo

Once the locations are loaded they are displayed in a table with the possibility of clicking on the edit button to modify the data for any location. Clicking on the edit button will take you back to the modification view in which you can change the data you want, don't forget to validate and if I change your mind it's always possible to return to home

Concerning the aesthetics of the mini application, I reused some aspects of the default vue style and I used [primeVue](https://primevue.org/) to use components (text field, button, etc.) that were already ready and which will allow me to 'go more quickly to the most interesting parts.I tried to use the colors of the LogBook logo to stay in the theme

## Recommendations

In this technical test, I was asked to propose, according to my vision, the things that will change if we decide to open our API to a partner. For this, I added recommendations in the form of todo in the main controller `LocationController`. I even added examples of fictitious middlware to provide assistance on the possible implementation of these proposed solutions


## Installation

Make sure that you have docker & docker-composer installed. Once it is good, run the docker-compose build to create the containers and run the backend and the frontend applications

`cd project_folder && docker-compose build -d`

Once the containers are up, the front application will be server at `http://localhost`
You must ensure that localhost is free and that it does not serve any application

## TODO
- Tests
- Better error handling

