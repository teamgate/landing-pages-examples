# Landing Page Example #1

This Request form creates a Lead with filled information in your Teamgate account. The only thing you have to do - fill your API key and User token key from your Teamgate account.

| Request form | Forms after success request |
| ---| --- |
![alt text](https://github.com/teamgate/landing-pages-examples/blob/master/landing-1/images/landing-1_form.png "Empty request form") | ![alt text](https://github.com/teamgate/landing-pages-examples/blob/master/landing-1/images/landing-1_success.png "Forms after success request")
### In form used API methods

- [POST: v4/leads](http://docs.teamgate.com/v4/reference#lead-create) - Creating New lead with data from form: _Name, Email, Phone_.
- [POST: v4/events](http://docs.teamgate.com/v4/reference#event-comment-create) - Creating note in created lead card. Using data from form: _Massage_.
