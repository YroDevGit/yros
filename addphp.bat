@echo off
net session >nul 2>&1
if %errorLevel% neq 0 (
    echo Requesting administrator access...
    powershell -Command "Start-Process cmd -ArgumentList '/c %~fnx0' -Verb RunAs"
    exit /b
)

setx /M PATH "%PATH%;C:\xampp\php"
echo PHP path added to the system environment variables.

