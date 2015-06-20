TITLE Installing WPSync

@ECHO OFF

SET vendor=%programfiles%\hacdias
SET bin=%vendor%\bin

MKDIR %vendor%
MKDIR %bin%

COPY wpsync.exe %bin%
SETX PATH "%PATH%;%bin%"

ECHO Done.
PAUSE
