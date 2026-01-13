@echo off
title Monitoring Temps Reel - Systeme de Vote
color 0B

:loop

echo ===== SURVEILLANCE TEMPS REEL =====
echo Heure : %time%
echo.

echo --- Apache / MySQL ---
tasklist | findstr /I "httpd.exe mysqld.exe"
echo.

echo --- MySQL PROCESSLIST ---
mysql -u root -p -e "SHOW PROCESSLIST;"
echo.

timeout /t 3 /nobreak > nul
goto loop
