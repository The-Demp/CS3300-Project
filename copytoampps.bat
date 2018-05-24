@echo off
SET amppsPath="%ProgramFiles(x86)%\Ampps\www\CS3300-Project"
SET sourcePath="%~dp0"

xcopy %sourcePath:~0,-2%" %amppsPath% /S /Y /I
for /f %%F in ('dir %amppsPath% /b /a-d ^| findstr /vile ".html .php .js .css"') do del %amppsPath:~0,-1%\%%F"

explorer %amppsPath%