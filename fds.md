# mudCMS Roadmap

- Convert return data to JSON-format
- Image upload
- 

## JSON

An example of the article API return JSON
```JSON
{
  "article": {
    "title": "Example title",
    "poster": "Example user",
    "postdate": 20191001,
    "category": "Example category",
    "content": {
      "summary": "A small portion of the overall data",
      "text": "lots of text",
      "code": "code",
      "image": "images"
    }
  }
}
```

I've yet to decide which date-formtatting we should go for. Might consider doing it dynamically through the set-up process.
This format makes it easy to access the article as a whole, or just a part of
it. 

## Image handling

The image uploading will be done through PHP, the image display might be done with a combination of PHP and JS(to make it more interactive). 

This is an modal example:
    https://jsfiddle.net/secretmud/kosex7bv/36/

The end product will look like a simplified file manager, considering creating a series of file data in the database so that you'll be able to search for content based on a single query. 


## Markdown

Code tag  - ~ before and after block
Link tag  - ! url - name
Header(s) - # easy and clean
Citation  - >

Code:
^~(\s\S.*)
Link:
^!(.*?)-(.*)
Header(s)
^#{1,6}(.*)
Citation
^>(.*)

```php
test
```