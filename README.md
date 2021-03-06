# php-framework
Django inspired framework in php

# Get Started
Copy the configtemplate.php in the settings folder and rename it to config.php.
Copy the templateapp and rename it to whatever you want. Finaly you need to add an item to the array in settings/urls.php like this ```'^URL_HERE'=>'YOUR_APP/urls.php'```.
and you're done with setting everything up

# How does it work
You write all the knowledge in an app and you use the urls.py to connect everything. You need to add your view/function in the settings/urls.php. You can also add an urls.php in your app and add the path to the settings/urls.php
then it will search further in that url file to get the functions to load the page.

Every app can have a static folder and a template folder for his stylesheet and his views you create them by just creating a folder named templates or static.
you can load your static files with this command:```LoadStatic()```. then can you search your file like this ``` GetStaticFile('subfolder','filename')``` . If you want to load templates then you need to use this command: 
``` LoadTemplates()```. Then you can import them like this: ```GetTemplate(sub folder,filename)``` it also can be used like this: ```GetTemplate('filename')``` if you don't use subfolders.

# Testing

if you want to test your website your can type this in your terminal: ``` php -S localhost:8000 manage.php ```. it wil run a webserver on url ``` localhost:8000 ```

# Admin page
You can go to the admin page by typing this in your webbrowser http://yourwebsite.com/admin. There you can add/edit users, change rows in almost every table, change roles and permission, show a log of all admin changes and show statistics of your webpage

# Functions

## Load templates
```php
<?php
// load templates
LoadTemplates()
// use template
GetTemplate(sub folder,filename)
// or just the filename if you doesn't use subfolders
GetTemplate('filename') ?>
```
## Load static files
```php
// load templates
<?php LoadStatic();
// use template
GetStaticFile('subfolder','filename'); ?>
```
## Database
In the model folder of your app you have a file named ```model.php``` in that file you can create your database like this:
```php
    # class name is tablename
    class testclass extends ModelObj{
        function __construct(){
            # name, length, defaultvalue can be null, can be null
            $this->testchar = new ModelVarchar('testchar',255,"test",True);
            # name, length, defaultvalue can be null, can be null, autoincrement
            $this->testint = new ModelInt('testint',11,NULL, False,False);
            # name, default current timestamp, can be null
            $this->datet = new ModelDateTime('datet',False,False);
            # name, can be null
            $this->timet = new ModelTime('timet',False);
            # name, can be null
            $this->date = new ModelDate('date',False); 
        }

    }
    # class name is table name
    class classtest extends ModelObj{
        function __construct(){
            # name, length, defaultvalue can be null, can be null
            $this->testchar = new ModelVarchar('testchar',255,"test",True);
            # name, length, defaultvalue can be null, can be null, autoincrement
            $this->testint = new ModelInt('testint',11,NULL, False,False);
            # name, length, defaultvalue can be null, can be null
            $this->decima = new ModelDecimal('decima',11,NULL, False,False);
            # name, defaultvalue can be null, can be null
            $this->fl = new ModelFloat('fl',NULL, False);
            # name, defaultvalue can be null, can be null
            $this->dbl = new ModelDouble('dbl',NULL, False);
            # name, defaultvalue can be null, can be null
            $this->test = new ModelBool('test',NULL, False);
            # name, defaultvalue can be null, can be null
            $this->test = new ModelText('test',NULL, False);
            # name, fk name, reference table as model class,  can be null
            $this->fkField = new ModelFK('fkField','fk_field',testclass::Class, False);
        }
    }
``` 
When you're done creating your model you can migrate it by typing this in your terminal ``` php manage.php migrate ```
If you have default value in your model you can create an `insert` function inside your model to insert data afterwards:
```php
function insert(){
    <MODELNAME>::Create([COLUMNNAME=>VALUE]);
}
```
Then you can run ```php manage.php insertData``` to insert all of your data

You can access your models like this:

```php
<?php
$model = classtest::filter('id'=>'1'); # to fetch all row's

$model = classtest::Get('id'=>'1'); # to fetch one row
# for normal data
$val = $model->testchar->value;
# to use foreign keys you can do this:
$val = $model->fkField->object->datet->value;
# to insert data in your table:
$model = classtest::Create([COLUMNNAME=>VALUE]); 
# to update data:
$model = classtest::Set([COLUMN_NEED_TO_UPDATE=>NEW_VALUE]);

?>
```
## User function
```php
<?php
// creates an user
// array keyname is column name value is value of column
User::createUser($array);
// Login function and creates a session when is successfull
User::Login($user,$pass);
// checks if the user has the specific permission
User::RoleExist($username,$permissionname);
?>
```
## Input function
```php
<?php
// Create an input. default is bootstrap on
createInput(type,name/id,value/placeholder,['class'=>'classname','bootstrap'=>False,'props'=>"style='width='100%''"]);
?>
```
## Upload function
```php
<?php
// upload a file in de uploads folder with a random name
$path = upload(file,whitelist extension, whitelist filetype);
?>
```
 
