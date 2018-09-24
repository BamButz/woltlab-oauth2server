@ECHO OFF

SET publishDir=build
SET packagePath=%publishDir%/package.tar
SET sourcePath=src
SET tempDir=tmp

rmdir /s /q %publishDir%
mkdir %publishDir%

mkdir %tempDir%

rem Package.xml ist zwingend!
IF NOT EXIST %sourcePath%/package.xml (
    ECHO Package.xml wurde nicht gefunden!
    GOTO PAUSE
)

ECHO Packe package.xml..
tar -cf %packagePath% -C %sourcePath% package.xml

rem Wenn SQL Dateien vorhanden sind diese packen
IF EXIST %sourcePath%/*.sql (
    ECHO Packe SQL Dateien..
    tar -rf %packagePath% -C %sourcePath% *.sql
)

rem Wenn Cronjobs vorhanden sind diese packen
IF EXIST %sourcePath%/cronjobs.xml (
    ECHO Packe cronjobs.xml Datei..
    tar -rf %packagePath% -C %sourcePath% cronjobs.xml
)

rem Wenn Options vorhanden sind diese packen
IF EXIST %sourcePath%/options.xml (
    ECHO Packe options.xml Datei..
    tar -rf %packagePath% -C %sourcePath% options.xml
)

rem Wenn UserGroupOptions vorhanden sind diese packen
IF EXIST %sourcePath%/options.xml (
    ECHO Packe userGroupOptions.xml Datei..
    tar -rf %packagePath% -C %sourcePath% userGroupOptions.xml
)

rem Wenn UserMenus vorhanden sind diese packen
IF EXIST %sourcePath%/userMenu.xml (
    ECHO Packe userMenu.xml Datei..
    tar -rf %packagePath% -C %sourcePath% userMenu.xml
)

rem Wenn Pages vorhanden sind diese packen
IF EXIST %sourcePath%/page.xml (
    ECHO Packe page.xml Datei..
    tar -rf %packagePath% -C %sourcePath% page.xml
)

rem Wenn Files Ordner vorhanden ebenfalls packen
IF EXIST %sourcePath%/files/ (
    ECHO Packe Files Verzeichnis..
    tar -cf %tempDir%/files.tar -C %sourcePath%/files *
    tar -rf %packagePath% -C %tempDir% files.tar
)

rem Wenn Templates Ordner vorhanden ebenfalls packen
IF EXIST %sourcePath%/templates/ (
    ECHO Packe Templates Verzeichnis..
    tar -cf %tempDir%/templates.tar -C %sourcePath%/templates *
    tar -rf %packagePath% -C %tempDir% templates.tar
)

rem Wenn AcpTemplates Ordner vorhanden ebenfalls packen
IF EXIST %sourcePath%/acptemplates/ (
    ECHO Packe AcpTemplates Verzeichnis..
    tar -cf %tempDir%/acptemplates.tar -C %sourcePath%/acptemplates *
    tar -rf %packagePath% -C %tempDir% acptemplates.tar
)

rem Wenn Sprachdateien existieren diese packen
IF EXIST %sourcePath%/languages/ (
    ECHO Packe Languages Verzeichnis..
    tar -rf %packagePath% -C %sourcePath% languages
)

rmdir /s /q %tempDir%

ECHO Buildvorgang beendet!

rem Vermutlich erfolgreich wir überspringen die Pause
GOTO :EOF

:PAUSE
pause