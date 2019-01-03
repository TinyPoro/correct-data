
MathType for CKEditor 4 [![Tweet](https://img.shields.io/twitter/url/http/shields.io.svg?style=social)](https://twitter.com/wirismath)
===================================

MathType is a WYSIWYG editor to edit math equations and chemistry formulas. This package allows integrating MathType into CKEditor4.

![MathType for CKEditor4 screenshot](http://www.wiris.com/system/files/attachments/1202/CKEditor_editor_plugin.png)

# Table of Contents
- [Install instructions](#install-instructions)
- [Services](#services)
- [Documentation](#documentation)

## Install instructions

1. Install the npm module
    ```
    npm install @wiris/mathtype-ckeditor4
    ```

2. Add the plugin as an external plugin

    ```js
    CKEDITOR.plugins.addExternal('ckeditor_wiris', '../node_modules/@wiris/mathtype-lib-ckeditor4/', 'plugin.js');
    ```

3. Update the CKEditor configuration by adding the new plugin and allowing MathML content.

    ```js
        CKEDITOR.editorConfig = function(config)
     {
        extraPlugins = 'ckeditor_wiris';
        // Allow MathML content.
        allowedContent = true;
    };
    ```

    Notice that the example is assuming that you have the following directory structure and the plugin path may be adjusted.

    ```
    └───index.html
    └───ckeditor
    └───node_modules
        └───@wiris/mathtype-ckeditor4
    ```

## Services

This npm module uses services remotely hosted to render MathML data. However is strongly recommended to install this services in your backend. This will allow you, among other things, to customize the backend service and store locally the images generated by MathType.

The services are available for the following technologies: Java, PHP, .NET and Ruby on Rails. If you use any of this technologies, please download the plugin for your backend technology from [here](http://www.wiris.com/en/plugins3/ckeditor/download).

In order to install the plugin along with the correspondent services, please follow the [CKEditor4 install instructions](http://docs.wiris.com/en/mathtype/mathtype_web/integrations/html/ckeditor).

## Documentation
To find out more information about MathType , please go to the following documentation:

* [Install instructions](http://docs.wiris.com/en/mathtype/mathtype_web/integrations/html/ckeditor)
* [MathType documentation](http://docs.wiris.com/en/mathtype/mathtype_web/start)
* [Introductory tutorials](http://docs.wiris.com/en/mathtype/mathtype_web/intro_tutorials)
* [Service customization](http://docs.wiris.com/en/mathtype/mathtype_web/integrations/config-table)
* [Testing](http://docs.wiris.com/en/mathtype/mathtype_web/integrations/html/plugins-test)