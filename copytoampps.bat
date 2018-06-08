@echo off
SET amppsPath="%ProgramFiles(x86)%\Ampps\www\CS3300-Project"
SET sourcePath="%~dp0"

for %%e in (html php js css) do (
	xcopy %sourcePath:~0,-2%\*.%%e" %amppsPath% /S /Y /I
)
REM for /f %%F in ('dir %amppsPath% /b /a-d ^| findstr /vile ".html .php .js .css"') do del %amppsPath:~0,-1%\%%F"