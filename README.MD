<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://koinz.app/assets/images/src/assets/Logo_Logo%20Orange.6f311d40.png" width="400" alt="Laravel Logo"></a></p>


# Koinz Backend Assessement Task (Books Recommender)

You find reading both enjoyable and beneficial for personal growth, and You've decided to launch a reading recommendation system to inspire others to discover the
joy of reading and self-improvement.

Your system manages two main operations. The first operation is to allow the users to submit an interval of starting and ending pages that he/she read in a specific
book. Note that the user can submit multiple intervals for the same book.

While the second operation is to announce the most recommended five books in the system, which are picked based on how many unique pages have been read for
all the users that submitted their intervals in the first operation (sorted by books with the most read pages to books with the least read pages).

## Installation

```bash
- git clone git@github.com:kemox5/koinz-task.git
- cd koinz-task
- cp .env.example .env
- docker compose up -d
- docker exec koinz-app php artisan key:generate
- docker exec koinz-app php artisan db:seed
```

## Usage
- See Api docs http://localhost/docs/api


## Testing
```bash
- php artisan test
```

## License

[MIT](https://choosealicense.com/licenses/mit/)