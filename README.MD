<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://koinz.app/assets/images/src/assets/Logo_Logo%20Orange.6f311d40.png" width="400" alt="Laravel Logo"></a></p>


# Koinz Backend Assessement Task (Books Recommender)

You find reading both enjoyable and beneficial for personal growth, and You've decided to launch a reading recommendation system to inspire others to discover the
joy of reading and self-improvement.

Your system manages two main operations. The first operation is to allow the users to submit an interval of starting and ending pages that he/she read in a specific
book. Note that the user can submit multiple intervals for the same book.

While the second operation is to announce the most recommended five books in the system, which are picked based on how many unique pages have been read for
all the users that submitted their intervals in the first operation (sorted by books with the most read pages to books with the least read pages).


## Requirements

- :white_check_mark: Feel free to use any programming language, framework, or DBMS.
- :white_check_mark: Use git and commit your changes often.
- :white_check_mark: Upload your project to your preferred version control system (Github, Gitlab, etc.) and email us the repository URL after you finish.
- :white_check_mark: Use seeders to populate the database with some users and books if needed.
- :white_check_mark: Be sure to follow good coding standards.
- :white_check_mark: Document how to run the project in the README file.
- :white_check_mark: [Plus] Write API docs.
- :white_check_mark: [Plus] Dockerize the app.
- :white_check_mark: [Plus] Write unit tests for your code.
- :white_check_mark: [Big Plus] Deploy your project to any free hosting platform


## Demo



## Installation

```bash
- git clone git@github.com:kemox5/koinz-task.git
- cd koinz-task
- cp .env.example .env #update db configs
- docker compose up -d
- docker exec koinz-app bash ./setup.bash
```

## Usage
- See Api docs http://localhost/docs/api


## Testing
```bash
- php artisan test
```
