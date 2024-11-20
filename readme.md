# WordPress Headless CMS API - Authors & Podcasts

This repository provides a headless CMS setup for managing **Authors** and **Podcasts** post types in WordPress. The API exposes endpoints for retrieving and managing authors and podcasts, supporting features such as pagination, filtering, and custom fields.

## **Authors API Endpoints**

### 1. **List of All Authors**
Fetch a list of all authors with their basic information.

#### Endpoint
GET /wp-json/v1/authors


#### Example Request
```bash
GET https://zariab.cyborgtech.co/wp-json/v1/authors
Example Response
json
[
    {
        "id": 1,
        "slug": "john-doe",
        "title": "John Doe",
        "content": "This is John's biography.",
        "meta": {
            "location": "New York",
            "job": "Author",
            "sum_of_topics": 50,
            "age": 30,
            "facebook_link": "https://facebook.com/john",
            "instagram_link": "https://instagram.com/john",
            "telegram_link": "https://telegram.me/john",
            "youtube_link": "https://youtube.com/john"
        },
        "featured_image": "https://zariab.cyborgtech.co/wp-content/uploads/2023/01/john-doe.jpg"
    },
    {
        "id": 2,
        "slug": "jane-smith",
        "title": "Jane Smith",
        "content": "This is Jane's biography.",
        "meta": {
            "location": "Los Angeles",
            "job": "Writer",
            "sum_of_topics": 40,
            "age": 28,
            "facebook_link": "https://facebook.com/jane",
            "instagram_link": "https://instagram.com/jane",
            "telegram_link": "https://telegram.me/jane",
            "youtube_link": "https://youtube.com/jane"
        },
        "featured_image": "https://zariab.cyborgtech.co/wp-content/uploads/2023/01/jane-smith.jpg"
    }
]
2. Single Author by Slug
Fetch a single author’s details by their slug.

Endpoint
bash
GET /wp-json/v1/authors/{slug}
Example Request
bash
GET https://zariab.cyborgtech.co/wp-json/v1/authors/john-doe
Example Response
json
{
    "id": 1,
    "slug": "john-doe",
    "title": "John Doe",
    "content": "This is John's biography.",
    "meta": {
        "location": "New York",
        "job": "Author",
        "sum_of_topics": 50,
        "age": 30,
        "facebook_link": "https://facebook.com/john",
        "instagram_link": "https://instagram.com/john",
        "telegram_link": "https://telegram.me/john",
        "youtube_link": "https://youtube.com/john"
    },
    "featured_image": "https://zariab.cyborgtech.co/wp-content/uploads/2023/01/john-doe.jpg"
}
3. Similar Authors (Excluding the Provided Author)
Fetch a list of authors similar to the provided author, excluding the author’s own details. Supports pagination.

Endpoint
bash
GET /wp-json/v1/similar_authors
Example Request
bash
GET https://zariab.cyborgtech.co/wp-json/v1/similar_authors
Example Response
json
[
    {
        "id": 2,
        "slug": "jane-smith",
        "title": "Jane Smith",
        "content": "This is Jane's biography.",
        "meta": {
            "location": "Los Angeles",
            "job": "Writer",
            "sum_of_topics": 40,
            "age": 28,
            "facebook_link": "https://facebook.com/jane",
            "instagram_link": "https://instagram.com/jane",
            "telegram_link": "https://telegram.me/jane",
            "youtube_link": "https://youtube.com/jane"
        },
        "featured_image": "https://zariab.cyborgtech.co/wp-content/uploads/2023/01/jane-smith.jpg"
    }
]
Podcasts API Endpoints
1. List of All Podcasts
Fetch a list of all podcasts with their basic information such as title, slug, host name, and guest name.

Endpoint
bash
GET /wp-json/v1/podcasts
Example Request
bash
GET https://zariab.cyborgtech.co/wp-json/v1/podcasts
Example Response
json
[
    {
        "id": 1,
        "slug": "sample-podcast",
        "title": "Sample Podcast",
        "content": "This is the content of the podcast.",
        "meta": {
            "host_name": "John Doe",
            "guest_name": "Jane Smith",
            "audio_file": "https://zariab.cyborgtech.co/wp-content/uploads/2023/01/podcast-audio.mp3",
            "podcast_date_shamsi": "1403/08/10",
            "podcast_duration": "01:15:30"
        },
        "featured_image": "https://zariab.cyborgtech.co/wp-content/uploads/2023/01/podcast-image.jpg"
    },
    {
        "id": 2,
        "slug": "another-podcast",
        "title": "Another Podcast",
        "content": "This is another podcast.",
        "meta": {
            "host_name": "Alice",
            "guest_name": "Bob",
            "audio_file": "https://zariab.cyborgtech.co/wp-content/uploads/2023/02/podcast-audio-2.mp3",
            "podcast_date_shamsi": "1403/09/15",
            "podcast_duration": "00:45:00"
        },
        "featured_image": "https://zariab.cyborgtech.co/wp-content/uploads/2023/02/podcast-image-2.jpg"
    }
]
2. Single Podcast by Slug
Fetch the details of a single podcast by its slug.

Endpoint
bash
GET /wp-json/v1/podcast/{slug}
Example Request
bash
GET https://zariab.cyborgtech.co/wp-json/v1/podcast/sample-podcast
Example Response
json
{
    "id": 1,
    "slug": "sample-podcast",
    "title": "Sample Podcast",
    "content": "This is the content of the podcast.",
    "meta": {
        "host_name": "John Doe",
        "guest_name": "Jane Smith",
        "audio_file": "https://zariab.cyborgtech.co/wp-content/uploads/2023/01/podcast-audio.mp3",
        "podcast_date_shamsi": "1403/08/10",
        "podcast_duration": "01:15:30"
    },
    "featured_image": "https://zariab.cyborgtech.co/wp-content/uploads/2023/01/podcast-image.jpg"
}
3. Similar Podcasts (Excluding the Provided Podcast)
Fetch a list of podcasts similar to the provided podcast, excluding the podcast with the provided slug. Supports pagination.

Endpoint
bash
GET /wp-json/v1/podcast/similar/{slug}?per_page={number}&page={page_number}
Example Request
bash
GET https://zariab.cyborgtech.co/wp-json/v1/podcast/similar/sample-podcast?per_page=5&page=1
Example Response
json
[
    {
        "id": 2,
        "slug": "another-podcast",
        "title": "Another Podcast",
        "content": "This is another podcast.",
        "meta": {
            "host_name": "Alice",
            "guest_name": "Bob",
            "audio_file": "https://zariab.cyborgtech.co/wp-content/uploads/2023/02/podcast-audio-2.mp3",
            "podcast_date_shamsi": "1403/09/15",
            "podcast_duration": "00:45:00"
        },
        "featured_image": "https://zariab.cyborgtech.co/wp-content/uploads/2023/02/podcast-image-2.jpg"
    }
]
API Response Format
Each response will return a JSON object containing the requested data. In the case of errors (e.g., 404 Not Found or 400 Bad Request), the response will include the error code and message.

Usage Example
You can use these endpoints to integrate authors and podcasts into your front-end application or mobile app. All responses are paginated for efficient retrieval of large data sets.

Example Request for Authors List:
bash
GET https://zariab.cyborgtech.co/wp-json/v1/authors
Example Request for Single Podcast by Slug:
bash
GET https://zariab.cyborgtech.co/wp-json/v1/podcast/sample-podcast
License
This repository is licensed under the MIT License. See the LICENSE file for more details.

yaml

---

This `README.md` provides clear and structured documentation for the Authors and Podcasts APIs,