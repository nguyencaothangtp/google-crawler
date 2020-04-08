
# REST API with Lumen

A RESTful API app for crawling Google search results

## Getting Started
First, clone the repo:
```bash
$ git clone https://github.com/nguyencaothangtp/google-crawler.git
```

#### Configure the Environment
Create `.env` file:
```
$ cat .env.example > .env
```

Then simply run the app with Docker:
```bash
$ docker-compose up
```

### API Routes
| HTTP Method	| Path | Desciption  |
| ----- | ----- |------------- |
| GET      | /api/v1/auth/login | Login
| POST     | /api/v1/upload | Upload CSV file
| GET      | /api/v1/keyword-statistics | Get keywords statistics list
| GET      | /api/v1/keyword-statistics/{id} |  Get a specific statistics for a keyword id


### API Filtering
Filter page and number item per page:
```
.../keyword-statistics?per_page=2&page=1
```
Order by a certain field:
```
.../keyword-statistics?order[created_at]=asc&limit=10
```
Matches all keywords similar to 'iphone':
```
.../keyword-statistics?filter[keyword]=like:*iphone*
```
Filter all keywords that has total links greater than 100 (use 'lt' for less than)
```
.../keyword-statistics?filter[links_num]=gt:100
```
Matches all keywords where created_at is between 2020-12-10 and 2020-12-08:
```
.../keyword-statistics?filter[created_at]=lt:2020-12-10:and:gt:2020-12-08
```
