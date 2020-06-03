# Laravel Cutlet Helper
### Installation

```

composer require va/cutlet-helper

```

#### Helper functions and facades that exists in package

```
1. integerToken($length = 5) : Generate integer token or code

2. stringToken($length = 16, $characters = '2345679acdefghjkmnpqrstuvwxyz') : Generate string token or code

3. digitsToEastern($number) : Covert a Weatern number(English) or digits to Eastern number(Persian or Arabic)

4. isActive($key, $activeClassName = 'active') : Check the route name(string) or route names(array) is avtive or no for css classes

..
```
#### Usage
```
## With Facade format:

CutletHelper::integerToken(length: 10);
CutletHelper::stringToken(length: 32, characters: '2345679acdefghjkmnpqrstuvwxyz');
CutletHelper::digitsToEastern(number: 1375);
CutletHelper::isActive(key: ['posts.index', 'posts.create', 'posts.edit'], activeClassName: 'acive');

## Call a helper function:

integerToken(length: 10)
stringToken(length: 32, characters: '2345679acdefghjkmnpqrstuvwxyz');
digitsToEastern(number: 1375);
isActive(key: ['posts.index', 'posts.create', 'posts.edit'], activeClassName: 'acive');

```
## Open–closed principle in this package
You can extended the CutletHelper Facade in another packages:
```
public function boot()
{
    CutletHelper::preCall('integerToken', function ($methodName, $args) {
        Log::info('This log stored befor execute integerToken function!');
    });
    
    CutletHelper::postCall('*Token', function ($methodName, $args, $result) {
        Log::info('This log stored after execute integerToken function!');
    });
}
```

#### Requirements:

- PHP v7.0 or above
- Laravel v5.8.0 or above