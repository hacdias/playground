package dependencies

// Composer type
type Composer struct {
	folder string `string:"vendor"`
}

func (c *Composer) checkFolder() {

}

/*
class Composer:
    def __init__(self):
        self.main = 'composer.json'
        self.lock = 'composer.lock'
        self.json = json.loads(open(self.main).read())
        self.folder = 'vendor'
        self.__check_folder()

    def __check_folder(self):
        if 'config' in self.json:
            if 'vendor-dir' in self.json['config']:
                self.folder = self.json['config']['vendor-dir']

        self.folder = os.path.normpath(self.folder)

    def update(self):
        if os.path.isfile(self.lock):
            os.remove(self.lock)

        if os.path.isdir(self.folder):
            shutil.rmtree(self.folder)

        subprocess.call('composer install', shell=True)
*/
