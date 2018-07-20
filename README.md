# Leading Systems API bundle for Contao 4

The API bundle adds the Leading Systems API functionality to Contao 4. 

This extension is meant to assist other Leading Systems extensions such as the
e-commerce extension Merconis. Technically, standalone usage is possible but we can't offer
support for this extension unless it's combined with Merconis.

For more information visit the [Merconis website](https://merconis.com)


## What is LS API and what is it good for?

LS API adds REST-like API functionality to Contao and allows you to write your own
API resources.

LS API can be used in the Contao frontend and backend and it comes with a basic
authentication and authorization system.

## Usage

### Getting started

#### Backend usage
With this Contao extension installed the Contao backend navigation has a new navigation
group "LS API". One of the navigation items is labeled "API receiver". A click on it
opens the backend API endpoint in the browser window. Since no API resource has been
specified, the API will present you a JSON response with information about all
available resources.

The URL of the backend API endpoint will look like this:

`http://mydomain.com/contao?do=be_mod_ls_apiReceiver`

To call a specific API resource, the parameter "resource" needs to be added to the URL:

`http://mydomain.com/contao?do=be_mod_ls_apiReceiver&resource=getCurrentBackendUserName`

Calling this URL directly would result in an "access denied" response because we didn't
specify an API key:

```
{
"status": "error",   
"data": null,
"message": "Access denied",  
"code": 0  
}
```

In order to use our API credentials when accessing a resource, we need to make a POST
request to the API url sending the following POST parameters:

```
ls_api_key:       SOME-KEY-SPECIFIED-IN-THE-CONTAO-BACKEND
ls_api_username:  username-of-an-api-user
ls_api_password:  password-of-an-api-user
```

The API can accept API users, frontend users or backend users, depending on the requested
resource. If a resource accepts only API users (users explicitly defined as API users
in the backend) the parameters `ls_api_username` and `ls_api_password` are mandatory.

If a resource accepts frontend or backend users the parameter `ls_api_key` still has to
be provided but the user credentials for an API user can be omitted if there's a frontend
or backend user logged in.

#### Frontend usage

To create a frontend API endpoint you have to create a frontend module of the type
`LS API RECEIVER` and place that frontend module on a frontend page (e.g. using a content
element or placing it in the layout).

You can then call the API by simply calling this page:

`http://mydomain.com/api.html`

To call a specific API resource, the parameter "resource" needs to be added to the URL:

`http://mydomain.com/api/resource/getCurrentFrontendUserName.html`

Calling this URL directly would result in an "access denied" response because we didn't
specify an API key. The frontend API endpoint behaves in exactly the same way as mentioned
before with the backend API endpoint.