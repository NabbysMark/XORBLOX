# RCCServiceSoap08

Documentation here:
[RCCServiceSoap08 Docs](https://compactinteractive.com/docs/RCCServiceSoap08/1.0)

Install:

composer require compactinteractive/rccservicesoap08

Example:

```php
use CompactInteractive\RCCServiceSoap08;

RCCServiceSoap08::init("127.0.0.1", 64989);
$result = RCCServiceSoap08::execute('print("Hello")');

```
More examples in the Examples/ folder!
