## About Project

The project was created as a test task for a job with CoMedia.
The project implements a system for editing any json document using the PATCH method. The system client must be able to create an empty draft of the document. While the document is in the draft status, you can edit it as many times as you want. You can publish a draft document. Once published, the document can no longer be edited.

The project is implemented on the Laravel framework.

I hope I met the expectations of my future employer.

## Installation

In the file .env edit the desired lines. You must set these configuration parameters:
DB_CONNECTION
DB_HOST
DB_PORT
DB_DATABASE
DB_USERNAME
DB_PASSWORD

To create the necessary tables, perform the migration on the command line:
php artisan migrate

Optionally, you can fill in the tables with test data. To do this, run the command line:
php artisan db:seed

## API features:
POST /api/v1/document/ - create a draft document
GET /api/v1/document/{id} - get a document by id
PATCH /api/v1/document/{id} - edit document
POST /api/v1/document/{id}/publish - published document
GET /api/v1/document/?page=1&perPage=20 - get a list of documents broken down into pages, while sorting to the most recently created ones at the top.