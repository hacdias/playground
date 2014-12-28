#Web Site Wizard

My web programming environment has the following setup to the apache virtual hosts:

```Apache
<Virtualhost *:80>
    VirtualDocumentRoot "D:/Dev/www/%1/wwwroot"
    ServerName sites.dev
    ServerAlias *.dev
    UseCanonicalName Off
</Virtualhost>
```

Here is everything automated: I only have to create the folders to access their content with an URL similar to this: ```*.dev``` .

So if I want to create the ```hello.dev``` site, I have to create the folder ```D:/Dev/www/hello/wwwroot``` and add the following information to the

But when I want to create a new site I have to create the folders and add the following information to the Windows hosts file:

```
127.0.0.1   hello.dev
```

As Windows doesn't support wildcards in its hosts file, I can't simply write the following:

```
127.0.0.1   *.dev
```

And repeat the same process every time is boring so I've created this C# console application that creates the folders and adds the information to the Windows hosts file.

You just have to change the following lines into "Program.cs" and recompile it.

```c#
string devDir = @"D:\Dev\www",
    hostsFile = @"C:\Windows\System32\drivers\etc\hosts",
```

It's simple, easy and useful.
