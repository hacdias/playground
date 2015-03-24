using System;
using System.IO;

namespace Sitify
{
    class Program
    {
        protected static string devDir = @"D:\dev\www",
            hostsFile = @"c:\Windows\System32\drivers\etc\hosts";

        public static void Main(string[] args)
        {
            printLogo();

            string input;
            int option = 9999;

            do
            {
                printMenu();

                Console.Write("Option: ");
                input = Console.ReadLine();
                Int32.TryParse(input, out option);
                Console.WriteLine();

                switch (option)
                {
                    case 5:
                        backupHosts();
                        break;
                    case 3:
                        //deleteHostsEntry(true);
                        modifyHosts(true, false, true);
                        break;
                    case 2:
                        //newHostsEntry(true);
                        modifyHosts(false, true, true);
                        break;
                    case 1:
                        newSite();
                        break;
                    case 0:
                        System.Environment.Exit(0);
                        break;
                    default:
                        Console.WriteLine("There is not option " + option + ".");
                        break;
                }

            } while (option != 0);
        }

        private static void printLogo()
        {
            string[] title = new string[] {
                @"                  ____          __            ___             ",
                @"                 /\  _`\    __ /\ \__  __   /'___\            ",
                @"                 \ \,\L\_\ /\_\\ \ ,_\/\_\ /\ \__/  __  __    ",
                @"                  \/_\__ \ \/\ \\ \ \/\/\ \\ \ ,__\/\ \/\ \   ",
                @"                    /\ \L\ \\ \ \\ \ \_\ \ \\ \ \_/\ \ \_\ \  ",
                @"                    \ `\____\\ \_\\ \__\\ \_\\ \_\  \/`____ \ ",
                @"                     \/_____/ \/_/ \/__/ \/_/ \/_/   `/___/> \",
                @"                                                        /\___/",
                @"                                                        \/__/ "
            };

            Console.WriteLine();

            for (int i = 0; i < title.Length; i++)
            {
                Console.WriteLine(title[i]);
            }

            Console.WriteLine();
            Console.Write("Welcome to Sitify. To continue choose one of the following options.");
        }

        private static void printMenu()
        {
            string[] title = new string[] {
                @"Choose one of the following options:",
                @"  1 - New Website",
                @"  2 - New Hosts Entry",
                @"  3 - Delete Hosts Entry",
                @"  4 - Delete Whole Website (NOT AVAILABLE)",
                @"  5 - Backup Hosts File",
                @"  0 - Close"
            };

            for (int i = 0; i < title.Length; i++)
            {
                Console.WriteLine(title[i]);
            }

            Console.WriteLine();
        }

        private static void modifyHosts(bool remove, bool add, bool justDoIt, string projectName = @"")
        {
            if (remove == add)
                return;

            string hostsFileContent, hostsOfThisProject, 
                word = remove ? "removed" : "added";

            if (justDoIt)
            {
                Console.Write("Insert the project name: ");
                projectName = Console.ReadLine();
            }

            hostsFileContent = System.IO.File.ReadAllText(hostsFile);

            hostsOfThisProject = "\n127.0.0.1\t" + projectName + ".dev";
            hostsOfThisProject += "\n127.0.0.1\twww." + projectName + ".dev";

            if (remove)
            {
                hostsFileContent = hostsFileContent.Replace(hostsOfThisProject, "");
            }

            if (add)
            {
                hostsFileContent += hostsOfThisProject;
            }

            System.IO.StreamWriter file = new System.IO.StreamWriter(hostsFile);
            file.WriteLine(hostsFileContent);
            file.Close();

            Console.WriteLine();
            Console.WriteLine("The following entries were " + word + " to your hosts file:");
            Console.WriteLine(hostsOfThisProject);
            Console.WriteLine();
        }

        private static void newSite()
        {
            string projectName,
                projectDir,
                wwwDir;

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

                modifyHosts(false, true, false, projectName);
            }
        }

        private static void backupHosts()
        {
            Console.Write("Insert the backup path: ");
            string backupLocation = Console.ReadLine();

            try
            {
                File.Copy(hostsFile, backupLocation);
            }
            catch (IOException copyError)
            {
                Console.WriteLine(copyError.Message);
            }

            Console.WriteLine();
            System.Console.Write("Press any key to continue.");
            System.Console.ReadKey();
        }
    }
}
