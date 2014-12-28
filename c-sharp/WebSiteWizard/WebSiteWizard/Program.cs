using System;
using System.IO;

namespace WebSiteWizard
{
    class Program
    {
        static void Main()
        {
            string devDir = @"D:\Dev\www",
                hostsFile = @"C:\Windows\System32\drivers\etc\hosts",
                hostsContent,
                hostsToAdd,
                projectName,
                projectDir,
                wwwDir;

            string[] title = new string[] {
                @"   ____                          __               ____        __             ",
                @"  /\  _`\                       /\ \__           /\  _`\   __/\ \__          ",
                @"  \ \ \/\_\  _ __    __     __  \ \ ,_\    __    \ \,\L\_\/\_\ \ ,_\    __   ",
                @"   \ \ \/_/_/\`'__\/'__`\ /'__`\ \ \ \/  /'__`\   \/_\__ \\/\ \ \ \/  /'__`\ ",
                @"    \ \ \L\ \ \ \//\  __//\ \L\.\_\ \ \_/\  __/     /\ \L\ \ \ \ \ \_/\  __/ ",
                @"     \ \____/\ \_\\ \____\ \__/.\_\\ \__\ \____\    \ `\____\ \_\ \__\ \____\",
                @"      \/___/  \/_/ \/____/\/__/\/_/ \/__/\/____/     \/_____/\/_/\/__/\/____/"
            };

            Console.WriteLine();

            for (int i = 0; i < title.Length; i++)
            {
                Console.WriteLine(title[i]);
            }

            Console.WriteLine();
            Console.Write("Please insert the name of your new web project: ");

            projectName = Console.ReadLine();
            projectDir = System.IO.Path.Combine(devDir, projectName);
            wwwDir = System.IO.Path.Combine(projectDir, "wwwroot");

            Console.WriteLine();

            if (Directory.Exists(projectDir) || Directory.Exists(wwwDir))
            {
                Console.WriteLine("The path " + wwwDir + " already exists.");
            }
            else
            {
                System.IO.Directory.CreateDirectory(projectDir);
                Console.WriteLine(projectDir + " created.");
                System.IO.Directory.CreateDirectory(wwwDir);
                Console.WriteLine(wwwDir + " created");

                hostsContent = System.IO.File.ReadAllText(hostsFile);

                hostsToAdd = "\n127.0.0.1\t" + projectName + ".dev";
                hostsToAdd += "\n127.0.0.1\twww." + projectName + ".dev";

                hostsContent += hostsToAdd;

                System.IO.StreamWriter file = new System.IO.StreamWriter(hostsFile);
                file.WriteLine(hostsContent);
                file.Close();

                Console.WriteLine();
                Console.WriteLine("The following entries were added to your hosts file:");
                Console.WriteLine(hostsToAdd);
            }

            Console.WriteLine();
            System.Console.WriteLine("Press any key to exit.");
            System.Console.ReadKey();
        }
    }
}
