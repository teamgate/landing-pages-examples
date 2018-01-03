## Landing Page Examples

[Landing Pages](https://www.teamgate.com/features/landing-pages)

### Technical Dependencies

- [PHP](http://www.php.net)
- [PEST](https://github.com/pest-parser/pest)
- [Teamgate API](http://docs.teamgate.com/v4/reference)

### Steps to run locally

1. Choose a landing page and clone them repository. Example: `git clone https://github.com/teamgate/landing-page-examples/landing-1.git  && cd landing*`
2. Open PHP file `save.php` and enter authentication data:
```php
    private $_baseUrl = ''; // Your website URL
    private $_apiKey = ''; // Located at yout Teamgate account -> Settings -> Additional features -> External Apps
    private $_userToken = ''; // Located at yout Teamgate account -> My profile -> Integrations -> API access
```
3. Browse to [http://localhost/landing-1](http://localhost/landing-1) on your machine.
4. Volia!

### Credits and Resources

- [Bootstrap](http://getbootstrap.com)
- [JQuery](http://jquery.com)
- [Font Awesome](http://fontawesome.io/)
