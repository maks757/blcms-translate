Translations module for Black-Lamp CMS
======================================

INSTALLATION
------------

### Migrate language table

	yii migrate --migrationPath=@yii/i18n/migrations/

### Composer require section
```javascript
"black-lamp/blcms-translate": "*"
```
### Add to main.php
```php
'modules' => [
        'translation' => [
            'class' => \bl\cms\translate\Translation::className()
        ],
        ...
    ],
```
