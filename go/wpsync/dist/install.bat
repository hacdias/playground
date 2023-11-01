@ECHO OFF
TITLE Installing WPSync
SET vendor=%programfiles%\hacdias
SET bin=%vendor%\bin
MKDIR "%vendor%"
MKDIR "%bin%"
COPY "%~dp0\wpsync.exe" "%bin%"
SETX PATH "%PATH%;%bin%"
ECHO Done.
PAUSE
