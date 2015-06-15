package plugin

/* class Plugin:
   def __init__(self):
       self.plugin_file = 'plugin.php'
       self.plugin_file_content = ''
       self.readme_file = 'readme.txt'
       self.readme_file_content = ''
       self.old_version = []
       self.new_version = []
       self.the_version = ''
       self.index = 2
       self.version_control = 'git'
       self.wordpress_svn = ''
       self.ignore_files = []

   def update(self):
       self.__get_plugin_file_content()
       self.__get_readme_content()
       self.__get_current_version()
       self.__get_new_version()

       try:
           input("Confirm you want to update your plugin to v" + self.the_version)
       except SyntaxError:
           pass

       self.__change_version_files()
       self.__update_this_repo()
       self.__update_wordpress_repo()

   def __get_current_version(self):
       match = re.search("Version:[ \t]*[\d+\.]+\d", self.plugin_file_content)

       if match is None:
           print("We can't understand the version of your plugin :(")
           exit(1)

       version = match.group(0)
       version = re.search("[\d+\.]+\d", version).group(0)
       version = version.split('.')

       self.old_version = list(map(int, version))

   def __get_plugin_file_content(self):
       self.plugin_file_content = open(self.plugin_file, 'r').read()

   def __get_readme_content(self):
       self.readme_file_content = open(self.readme_file, 'r').read()

   def __get_new_version_helper(self):
       if (self.new_version[self.index] + 1) > 9 and self.index != 0:
           self.new_version[self.index] = 0
           self.index -= 1
           self.__get_new_version_helper()
       else:
           self.new_version[self.index] += 1

   def __get_new_version(self):
       # get the version index to update
       # major.minor[.build[.revision]]
       # default is build
       index_list = {
           'major': 0,
           'minor': 1,
           'build': 2,
           'revision': 3
       }

       self.index = index_list[self.index]
       self.new_version = self.old_version
       self.__get_new_version_helper()

       self.new_version = list(map(str, self.new_version))
       self.the_version = '.'.join(self.new_version)

   def __change_version_files(self):
       plugin_search = 'Version:[ \t]*[\d+\.]+\d'
       plugin_replace = 'Version: ' + self.the_version

       self.plugin_file_content = re.sub(plugin_search, plugin_replace, self.plugin_file_content)

       with open(self.plugin_file, 'w') as fs:
           fs.write(self.plugin_file_content)

       readme_search = 'Stable tag:[ \t]*[\d+\.]+\d'
       readme_replace = 'Stable tag: ' + self.the_version

       self.readme_file_content = re.sub(readme_search, readme_replace, self.readme_file_content)

       with open(self.readme_file, 'w') as fs:
           fs.write(self.readme_file_content)

   def __update_this_repo(self):
       if self.version_control == 'svn':
           svn = Svn()
           svn.tag = 'v' + self.the_version
           svn.commit = 'v' + self.the_version
           svn.update()
           return

       # in case of being git
       git = Git()
       git.tag = 'v' + self.the_version
       git.commit = 'v' + self.the_version
       git.update()

   def __update_wordpress_repo(self):
       # save the path where we're working and creates a temporary one
       main_path = os.getcwd()
       temp_path = tempfile.mkdtemp()

       # set the files to ignore
       ignore_files = shutil.ignore_patterns(*self.ignore_files)

       # changes the working path to the temporary path
       os.chdir(temp_path)

       subprocess.call('svn checkout ' + self.wordpress_svn + ' .', shell=True)

       trunk = os.path.join(temp_path, 'trunk')
       temporary_content = os.path.join(temp_path, 'contents_temp')

       # copy the new plugin files to the temporary_folder, ignoring some files
       shutil.copytree(main_path, temporary_content, False, ignore_files)

       # replace the current 'trunk' folder with the new contents
       shutil.rmtree(trunk)
       shutil.move(temporary_content, trunk)

       svn = Svn()
       svn.commit = 'v' + self.the_version
       svn.tag = self.the_version
       svn.update()

       # return to the first working path
       os.chdir(main_path)

       # remove the temporary folder
       shutil.rmtree(temp_path, True)*/
