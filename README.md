# WPMB-class-autoloader

**_STATUS: Testing_**

Automatically and conditionally load your classes.

Rules to follow:

1. This is for classes in the plugins directory.
2. You have to use namespaces that follow the plugin's directory pattern.
3. The namespace starts at the plugin folder.
4. The file name must match the class name as per WPCS.

If you do those 4 things, this will automatically include your class file
without you having to do anything else. When the class is needed, the
function will use the namespace to create the file path and then include
the file.

Example:
My plugin's folder is 'jwr'.
In my plugin, I have a class named 'My_Widgets'.
It's in a subdirectory named 'php'.

That means my file name is: 'class-my-widgets.php' (per WPCS)
The file's namespace is: 'jwr\php\'

I cannot provide support. But if you have questions (or suggestions), find [me on twitter](https://twitter.com/_JoshRobbs)
