# API Examples

Assume you have this list of content in your Open Social Installation:

*Events*
* `3a2c758c-deef-11e5-b86d-9a79f06e9478`
* `3a2c6c40-deef-11e5-b86d-9a79f06e9478`

*Event enrollments*
* `5751754c-eabe-11e5-9ce9-5e5517507c66`

*Users*
* `44fc40ec-da2f-11e5-b5d2-0a1d41d68578`

## List all events created after given timestamp
`GET {{host}}/jsonapi/node/event?filter[datefilter][condition][path]=created&filter[datefilter][condition][operator]=>&filter[datefilter][condition][value]=1568646154`

## List all events in the next week
`GET {{host}}/jsonapi/node/event?filter[datefilter][condition][path]=field_event_date&filter[datefilter][condition][operator]=BETWEEN&filter[datefilter][condition][value][]=1569196800&filter[datefilter][condition][value][]=1569801600`

## List all events matching a given tag
`GET {{host}}/jsonapi/node/event?filter[social_tagging.name]=Volunteering`

## List all events a user is enrolled to
Two requests are needed for this:

### Get all event enrollments for a user
`GET {{host}}/jsonapi/event_enrollment/event_enrollment?filter[field_account.id]=44fc40ec-da2f-11e5-b5d2-0a1d41d68578`

### Get all events (with certain IDs)
Now list all the event ids from the previous request and add those to the filtering.

`GET {{host}}/jsonapi/node/event?filter[id-filtering][condition][path]=id&filter[id-filtering][condition][operator]=IN&filter[id-filtering][condition][value][]=3a2c758c-deef-11e5-b86d-9a79f06e9478&filter[id-filtering][condition][value][]=3a2c6c40-deef-11e5-b86d-9a79f06e9478`

## Add event enrollments
`POST {{host}}/jsonapi/event_enrollment/event_enrollment`

- Type of request: POST
- Headers: 
-- Content-type: application/vnd.api+json
-- Accept: application/vnd.api+json
- Body:
```
{
  "data": {
    "type": "event_enrollment--event_enrollment",
    "attributes": {
      "name": "Title",
      "field_enrollment_status": "1",
      "langcode": "und"
    },
    "relationships": {
      "user_id": {
        "data": {
          "type": "user--user",
          "id": "44fc40ec-da2f-11e5-b5d2-0a1d41d68578"
        }
      },
      "field_account": {
		"data": {
		  "type": "user--user",
		  "id": "44fc40ec-da2f-11e5-b5d2-0a1d41d68578"
		}
	  },
	  "field_event": {
        "data": {
          "type": "node--event",
          "id": "3a2c758c-deef-11e5-b86d-9a79f06e9478"
        }
	  }
    }
  }
}
```

## Remove event enrollments
`DELETE {{host}}/jsonapi/event_enrollment/event_enrollment/5751754c-eabe-11e5-9ce9-5e5517507c66`
