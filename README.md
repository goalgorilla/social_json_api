# Social JSON API

Social JSON API provides an API which can be used with the following entities:

* comment
* event_enrollment
* file
* group
* group_content
* node
* post
* profile
* taxonomy_term
* user

It works out of the box for these entities. However you'll need to do some configuration to access the API (authentication and authorization). 

## Installation

1. Enable this module and all its dependencies.
1. The module will automatically create a folder outside your docroot (web/html) directory where you can store the public and private key combination. By default this is: `private://oauth_api_keys/`.
1. If your site has a sitemanager role it will automatically assign a bunch of permissions to this role. 
1. Check if all the right entities are enabled in social_json_api_entity_type_alter().

## Configuration

The API System which is implemented has multiple authentication grants available. These are all allowed in Open Social by default. 

To determine which grant is applicable for your use-case please read the [oauth2 documentation](http://oauth2.thephpleague.com/authorization-server/which-grant/) For demo purposes we assume you'll want the password grant, which means that you'll login with account details of a given user. This user should exist in Open Social.

1. Go to /admin/config/people/simple_oauth and configure the OAuth settings to your needs. Double check the expiration times and if the keys exist. During development you can set the access token expiration time on a higher value. Usually this should be below 300 seconds.
1. Create a consumer on /admin/config/services/consumer/add
1. Fill in at least:
    * Label: The label for your consumer (e.g. My CRM system)
    * User: leave this empty
    * New secret: Generate a secure string here (e.g. using Lastpass, but do remember this, you'll need this later)
    * Is confidential: yes
    * Is this consumer 3rd party?: yes
    * Redirect URL: leave empty
    * Scopes: select the roles you want to use here, e.g. Sitemanager (this determines the permissions for the API)
1. After saving the consumer you'll go to the consumer overview where you can see the consumer uuid.

## Authentication
Now you can get access to the API by doing a POST Request on `/oauth/token` with the following body:

```
grant_type:password
client_id:uuid
client_secret:secret
username:{username}
password:{password}
```

Just fill in the client_id, client_secret, username and password accordingly. You will receive an access_token and refresh_token which you can use in subsequent requests, e.g. in refresh_token requests or you can use the same access_token during the expire time.

More info here: http://oauth2.thephpleague.com/authorization-server/resource-owner-password-credentials-grant/

## Documentation

Some more information is available on your site on:
`/admin/config/opensocial/social-json-api`

You will also find a link to the documentation for your API there. The documentation is automatically generated and displayed with [ReDoc](https://github.com/Rebilly/ReDoc).
