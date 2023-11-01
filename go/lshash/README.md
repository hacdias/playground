# lshash
[![Build](https://img.shields.io/travis/hacdias/lshash.svg?style=flat-square)](https://travis-ci.org/hacdias/lshash) [![License](https://img.shields.io/github/license/hacdias/lshash.svg?style=flat-square)](https://github.com/hacdias/lshash/blob/master/LICENSE)

List your files and print their MD5, SHA1, SHA256 and/or SHA512 hash in JSON format.


To use this CLI, you need to have [Go 1.1+](https://golang.org/) installed on your computer. Then ,you just have to run the following commands:

```
go get github.com/hacdias/lshash
go install github.com/hacdias/lshash
```

**Usage**

```
generate an hash from a file and prints in json format

Usage:
  hasher [file or directory] [flags]

Flags:
  -h, --help        help for hasher
      --md5         get the MD5 hash
  -r, --recursive   iterate the directory recursively
      --sha1        get the SHA1 hash
      --sha256      get the SHA256 hash
      --sha512      get the SHA512 hash
```

**Example**

```
lshash . --md5
```

```
{
    "desktop.ini": {
        "md5": "3a37312509712d4e12d27240137ff377"
    },
    "httpd-2.4.18-win64-VC14.zip": {
        "md5": "af54ee8a7dc6aff1f2e5b5ee0213f566"
    },
    "hugo_0.15_linux_amd64.tar.gz": {
        "md5": "6c8c5ea886e24f8d74618bc752f0e7cb"
    },
    "hugo_0.15_linux_arm.tar.gz": {
        "md5": "25e14e566dee6d03d29b17951c40adc2"
    },
    "hugo_0.15_netbsd_386.zip": {
        "md5": "417fa68b0ea8d9e5573b552815531814"
    },
    "hugo_0.15_netbsd_amd64.zip": {
        "md5": "1f20d886db2db54bf3be98db2e6a0931"
    },
    "hugo_0.15_netbsd_arm.zip": {
        "md5": "f58fe5f048f42bfecc9161d9d8a58202"
    },
    "hugo_0.15_openbsd_386.zip": {
        "md5": "ed940c0754ac695de8fd815e1073547e"
    },
    "hugo_0.15_openbsd_amd64.zip": {
        "md5": "afab10fe06df2dd0ba951bf7da49b1b8"
    },
    "hugo_0.15_windows_386_32-bit-only.zip": {
        "md5": "fa0c4c426bdf1956381279f76546e796"
    }
}
```
