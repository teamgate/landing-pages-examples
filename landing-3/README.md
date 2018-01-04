# Landing Page Example #3

This request form searches a Company and Person in your database, if not found, it creates a new contact with filled information in your Teamgate account as new company and new person. For new contact creates a deal with chosen service as tag. The only thing you have to do is fill out your API key and User token key from your Teamgate account.

| Request form | Forms after success request |
| ---| --- |
![alt text](https://github.com/teamgate/landing-pages-examples/blob/master/landing-3/images/landing-3_form.png "Empty request form") | ![alt text](https://github.com/teamgate/landing-pages-examples/blob/master/landing-3/images/landing-3_success.png "Forms after success request")
### In form used API methods

- [GET: v4/global](http://docs.teamgate.com/v4/reference#global-search) - Search existing Company and Person in your database by from data: _Company name, Full name_.
- [POST: v4/people](http://docs.teamgate.com/v4/reference#person-create) - Creating New person with data from form: _Full name, Email, Phone_.
- [POST: v4/companies](http://docs.teamgate.com/v4/reference#company-create) - Creating New company with data from form: _Company name_ and Created person _Id_.
- [POST: v4/deals](http://docs.teamgate.com/v4/reference#deal-create) - Creating deal for contact. Using data from form: _Service_ and Company _Id_.
